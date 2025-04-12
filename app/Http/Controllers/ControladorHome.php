<?php

namespace App\Http\Controllers;

use App\Models\Campeon;
use App\Models\Categoria;
use App\Models\Edicion;
use App\Models\Fase;
use App\Models\Fecha;
use App\Models\Goleador;
use App\Models\Grupo;
use App\Models\InstanciaFinal;
use App\Models\Partido;
use App\Models\Subcampeon;
use App\Models\TablaGoleador;
use App\Models\TablaPosicion;
use App\Models\User;
use App\Models\VallaMenosVencida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorHome extends Controller
{
    public function index(Request $request)
    {
        // Recuperar todas las ediciones de la base de datos
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $ultimaEdicion = null;
        if (is_null($idEdicion)) {
            $ultimaEdicion = Edicion::latest('id')->first();
        }
        $idCategoria = $request->query('idCategoria');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $categorias = Categoria::query();
        $roles = User::pluck('rol');
        if ($EdicionSeleccionada) {
            $categorias = $categorias->where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        }

        return view('welcome', compact('ediciones', 'ultimaEdicion', 'EdicionSeleccionada', 'categorias', 'idEdicion', 'idCategoria', 'roles'));
    }
    public function admin(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $horario = $request->query('horario');
        if ($horario) {
            $horario = date('Y-m-d H:i:s', strtotime('next Sunday ' . $horario));
        }
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $busquedaFecha = $request->query('busqueda');
        

        $ultimaFecha = Fecha::where('idEdicion', $idEdicion)->latest('id')->first();
        $partidosQuery = Partido::select('partidos.*', 'el.nombre as nombre_local', 'ev.nombre as nombre_visitante', 'el.foto as foto_local', 'ev.foto as foto_visitante', 'f.nombre as nombre_fecha', 'c.nombreCategoria as nombre_categoria')
            ->join('equipos as el', 'partidos.idEquipoLocal', '=', 'el.id')
            ->join('equipos as ev', 'partidos.idEquipoVisitante', '=', 'ev.id')
            ->join('fechas as f', 'partidos.idFechas', '=', 'f.id')
            ->join('categorias as c', 'partidos.idCategoria', '=', 'c.id')
            ->where('partidos.idEdicion', $idEdicion)
            ->when($ultimaFecha, function ($query) use ($ultimaFecha) {
            return $query->where('partidos.idFechas', $ultimaFecha->id);
            });

        if ($horario) {
            $partidosQuery->where('partidos.horario_datetime', $horario);
        }

        $partidos = $partidosQuery->orderByDesc('f.id')
            ->orderByDesc('c.nombreCategoria')
            ->when($partidosQuery->whereNotNull('partidos.horario_datetime'), function ($query) {
            return $query->orderBy('partidos.horario_datetime', 'asc');
            })
            ->get()
            ->groupBy('nombre_categoria');

        $categorias = Categoria::where('idEdicion', $idEdicion)->get();
        //$fechas = Fecha::where('idEdicion', $idEdicion)->get();

        return view('Panel.admin', compact('ediciones', 'EdicionSeleccionada', 'partidos', 'categorias', 'horario'));
    }

    public function campeones(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $categorias = Categoria::query();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        if ($EdicionSeleccionada) {
            $categorias = $categorias->where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        }
        $campeonesOro = Campeon::where('campeones.idEdicion', $idEdicion)
            ->join('copas', 'campeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Oro')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'campeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();

        $campeonesPlata = Campeon::where('campeones.idEdicion', $idEdicion)
            ->join('copas', 'campeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Plata')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'campeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();
        return view('layouts.campeones', compact('ediciones', 'EdicionSeleccionada', 'categorias', 'campeonesOro', 'campeonesPlata'));
    }

    public function subcampeones(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $categorias = Categoria::query();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        if ($EdicionSeleccionada) {
            $categorias = $categorias->where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        }
        $subcampeonesOro = Subcampeon::where('subcampeones.idEdicion', $idEdicion)
            ->join('copas', 'subcampeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Oro')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'subcampeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();
        $subcampeonesPlata = Subcampeon::where('subcampeones.idEdicion', $idEdicion)
            ->join('copas', 'subcampeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Plata')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'subcampeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();
        return view('layouts.subcampeones', compact('ediciones', 'EdicionSeleccionada', 'categorias', 'subcampeonesOro', 'subcampeonesPlata'));
    }
    public function goleadores(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        // Obtener los datos de los goleadores
        $goleadores = Goleador::where('goleadores.idEdicion', $idEdicion)
            ->join('equipos', 'goleadores.idEquipo', '=', 'equipos.id')
            ->join('categorias', 'goleadores.idCategoria', '=', 'categorias.id')
            ->select('goleadores.nombre as nombre_jugador', 'equipos.nombre as nombre_equipo', 'equipos.foto as foto_equipo', 'categorias.nombreCategoria as categoria_nombre')
            ->orderBy('categoria_nombre', 'desc')
            ->get();

        return view('layouts.goleadores', compact('ediciones', 'EdicionSeleccionada', 'goleadores'));
    }
    public function vallas(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;

        $vallas = VallaMenosVencida::where('vallas_menos_vencidas.idEdicion', $idEdicion)
            ->join('equipos', 'vallas_menos_vencidas.idEquipo', '=', 'equipos.id')
            ->join('categorias', 'vallas_menos_vencidas.idCategoria', '=', 'categorias.id')
            ->select('vallas_menos_vencidas.nombre as nombre_jugador', 'equipos.nombre as nombre_equipo', 'equipos.foto as foto_equipo', 'categorias.nombreCategoria as categoria_nombre')
            ->orderBy('categoria_nombre', 'desc')
            ->get();

        return view('layouts.vallas', compact('ediciones', 'EdicionSeleccionada', 'vallas'));
    }

    public function fixture(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $idCategoria = $request->idCategoria;
        $CategoriaSeleccionada = $idCategoria ? Categoria::find($idCategoria) : null;
        $idFecha = $request->idFecha;

        if (isset($EdicionSeleccionada)) {
            $categorias = Categoria::where('idEdicion', $idEdicion)
                ->select('id', 'nombreCategoria')
                ->orderBy('nombreCategoria', 'desc')
                ->get();
        }

        $fechas = null;
        $grupos = null;
        $nombreFecha = null;
        $nombreCategoria = null;
        $partidos = collect();

        if (isset($CategoriaSeleccionada)) {
            // Incluir las fechas que estén asociadas a la categoría seleccionada y también aquellas sin categoría asignada
            $fechas = Fecha::where('idEdicion', $idEdicion)
                ->where(function ($query) use ($idCategoria) {
                    $query->where('idCategoria', $idCategoria) // Fechas asociadas a la categoría seleccionada
                        ->orWhereNull('idCategoria'); // O fechas sin categoría
                })
                ->select('id', 'nombre')
                ->orderByDesc('id')
                ->distinct('nombre')
                ->get();

            $grupos = Grupo::where('idCategoria', $idCategoria)
                ->where('idEdicion', $idEdicion)
                ->select('id', 'nombre')
                ->distinct('nombre')
                ->get();

            if (isset($idFecha)) {
                $partidos = Partido::select('partidos.*', 'el.nombre as nombre_local', 'ev.nombre as nombre_visitante', 'el.foto as foto_local', 'ev.foto as foto_visitante')
                    ->join('equipos as el', 'partidos.idEquipoLocal', '=', 'el.id')
                    ->join('equipos as ev', 'partidos.idEquipoVisitante', '=', 'ev.id')
                    ->where('partidos.idFechas', $idFecha)
                    ->where('partidos.idEdicion', $idEdicion)
                    ->get();
                $fecha = Fecha::find($idFecha);
                $nombreFecha = $fecha->nombre;
            } else {
                $partidos = Partido::select('partidos.*', 'el.nombre as nombre_local', 'ev.nombre as nombre_visitante', 'el.foto as foto_local', 'ev.foto as foto_visitante', 'f.nombre as nombre_fecha')
                    ->join('equipos as el', 'partidos.idEquipoLocal', '=', 'el.id')
                    ->join('equipos as ev', 'partidos.idEquipoVisitante', '=', 'ev.id')
                    ->join('fechas as f', 'partidos.idFechas', '=', 'f.id')
                    ->where('partidos.idEdicion', $idEdicion)
                    ->orderByDesc('partidos.id')
                    ->get();
            }
        }
        if (isset($idCategoria)) {
            $categoria = Categoria::find($idCategoria);
            $nombreCategoria = $categoria->nombreCategoria;
        }
        return view('layouts.fixture', compact('nombreFecha', 'nombreCategoria', 'grupos', 'ediciones', 'EdicionSeleccionada', 'categorias', 'idCategoria', 'CategoriaSeleccionada', 'fechas', 'partidos'));
    }

    public function tablaPosiciones(Request $request)
    {
        $ediciones = Edicion::all();
        $idCategoria = $request->query('idCategoria');
        $idGrupo = $request->query('idGrupo');
        $idEdicion = $request->query('idEdicion');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;

        // Obtener el nombre de la categoría
        $categoria = Categoria::find($idCategoria);
        $nombreCategoria = $categoria ? $categoria->nombreCategoria : 'Categoría no encontrada';

        // Consulta utilizando Eloquent
        $tablaPosiciones = TablaPosicion::select('tabla_posiciones.*', 'equipos.nombre as nombreEquipo', 'equipos.foto as fotoEquipo', 'equipos.id as idEquipo')
            ->join('equipos', 'tabla_posiciones.idEquipo', '=', 'equipos.id')
            ->where('tabla_posiciones.idGrupo', $idGrupo)
            ->where(function ($query) use ($idEdicion) {
                $query->where('tabla_posiciones.idEdicion', $idEdicion)
                    ->orWhere('tabla_posiciones.idEdicion', 0);
            })
            ->orderBy('tabla_posiciones.puntos', 'DESC')
            ->orderBy('tabla_posiciones.diferenciaGoles', 'DESC')
            ->get();

        return view('layouts.tabla-posiciones', compact('tablaPosiciones', 'EdicionSeleccionada', 'nombreCategoria', 'ediciones'));
    }

    public function tablaGoleadores(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $idCategoria = $request->idCategoria;
        $search_value = $request->search_value;

        if (!is_null($idCategoria)) {
            $goleadores_t = TablaGoleador::search($search_value)->join('ediciones as ed', 'tabla_goleadores.idEdicion', '=', 'ed.id')
                ->join('equipos as e', 'tabla_goleadores.idEquipo', '=', 'e.id')
                ->join('categorias as cat', 'tabla_goleadores.idCategoria', '=', 'cat.id')
                ->select('tabla_goleadores.*', 'e.nombre as nombreEquipo', 'cat.nombreCategoria as nombreCategoria', 'e.id as idEquipo')
                ->where('tabla_goleadores.idEdicion', $idEdicion)
                ->where('tabla_goleadores.idCategoria', $idCategoria)
                ->orderBy('cat.nombreCategoria', 'desc')
                ->orderBy('tabla_goleadores.cantidadGoles', 'desc')
                ->paginate(30);
            $goleadores_t->appends(['idEdicion' => $idEdicion, 'idCategoria' => $idCategoria]);
        } else {
            $goleadores_t = TablaGoleador::search($search_value)->join('ediciones as ed', 'tabla_goleadores.idEdicion', '=', 'ed.id')
                ->join('equipos as e', 'tabla_goleadores.idEquipo', '=', 'e.id')
                ->join('categorias as cat', 'tabla_goleadores.idCategoria', '=', 'cat.id')
                ->select('tabla_goleadores.*', 'e.nombre as nombreEquipo', 'cat.nombreCategoria as nombreCategoria', 'e.id as idEquipo')
                ->where('tabla_goleadores.idEdicion', $idEdicion)
                ->orderBy('cat.nombreCategoria', 'desc')
                ->orderBy('tabla_goleadores.cantidadGoles', 'desc')
                ->paginate(30);
            $goleadores_t->appends(['idEdicion' => $idEdicion]);
        }

        if (isset($EdicionSeleccionada)) {
            $categorias = Categoria::where('idEdicion', $idEdicion)
                ->select('id', 'nombreCategoria')
                ->orderBy('nombreCategoria', 'desc')
                ->get();
        }

        return view('layouts.tabla-goleadores', compact('ediciones', 'EdicionSeleccionada', 'goleadores_t', 'categorias'));
    }
    public function instanciasFinales(Request $request)
    {
        $ediciones = Edicion::all();
        $ultimaEdicion = Edicion::latest('id')->first();
        $idEdicion = $request->query('idEdicion', $ultimaEdicion->id); // Proporcionar un valor por defecto si no está presente en la solicitud
        $EdicionSeleccionada = Edicion::find($idEdicion);

        // Obtener las categorías disponibles para el filtro
        $categorias = Categoria::where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        $selectedCategoria = $request->query('categoria'); // Obtener la categoría seleccionada

        $partidosQuery = InstanciaFinal::select(
            'instancias_finales.*',
            'fases.nombre as nombre_fase',
            'el.nombre as nombre_local',
            'ev.nombre as nombre_visitante',
            'el.foto as foto_local',
            'ev.foto as foto_visitante',
            'categorias.nombreCategoria as nombre_categoria',
            DB::raw("COALESCE(copas.nombre, '') as nombre_copa")
        )
            ->join('fases', 'instancias_finales.idFase', '=', 'fases.id')
            ->join('equipos as el', 'instancias_finales.idEquipoLocal', '=', 'el.id')
            ->join('equipos as ev', 'instancias_finales.idEquipoVisitante', '=', 'ev.id')
            ->join('categorias', 'instancias_finales.idCategoria', '=', 'categorias.id')
            ->leftjoin('copas', 'instancias_finales.idCopa', '=', 'copas.id')
            ->where('instancias_finales.idEdicion', $idEdicion)
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->orderBy('copas.nombre', 'asc')
            ->orderByRaw("
            FIELD(fases.nombre, 'Final', 'Semifinal', 'Cuartos de Final') ASC
        ");

        // Aplicar el filtro por categoría si se selecciona una
        if (!empty($selectedCategoria)) {
            $partidosQuery->where('categorias.id', (int) $selectedCategoria);
        }

        $partidos = $partidosQuery->get();

        return view('layouts.instancias-finales', compact('ediciones', 'ultimaEdicion', 'EdicionSeleccionada', 'partidos', 'categorias', 'selectedCategoria'));
    }
}
