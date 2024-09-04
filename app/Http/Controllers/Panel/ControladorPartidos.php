<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partido\StoreRequest;
use App\Models\Categoria;
use App\Models\Dia;
use App\Models\Edicion;
use App\Models\Equipo;
use App\Models\EquipoGrupo;
use App\Models\Fecha;
use App\Models\Grupo;
use App\Models\Partido;
use App\Services\PartidoService;
use App\Traits\SeleccionarCategoriaTrait;
use Illuminate\Http\Request;

class ControladorPartidos extends Controller
{
    protected $partidoService;
    use SeleccionarCategoriaTrait;

    public function __construct(PartidoService $partidoService)
    {
        $this->partidoService = $partidoService;
    }

    public function index(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $idFecha = $request->idFecha;
        $idGrupo = $request->idGrupo;
        $idCategoria = $request->idCategoria;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;

        $query = Partido::where('partidos.idEdicion', $idEdicion);
        
        if ($idGrupo) {
            $query->where('partidos.idGrupo', $idGrupo);
        }

        if ($idFecha) {
            $query->where('partidos.idFechas', $idFecha);
        }
        if ($idCategoria) {
            $query->where('partidos.idCategoria', $idCategoria);
        }

        $partidos = $query
            ->with([
                'equipoLocal:id,nombre,foto',
                'equipoVisitante:id,nombre,foto',
                'fecha:id,nombre',
                'dia:id,diaPartido',
            ])
            ->select('partidos.*')
            ->orderByDesc('partidos.id')
            ->paginate(7);

        $partidos->appends([
            'idEdicion' => $idEdicion,
            'idFecha' => $idFecha,
            'idGrupo' => $idGrupo,
            'idCategoria' => $idCategoria
        ]);

        $categorias = Categoria::where('idEdicion', $idEdicion)
            ->select('id', 'nombreCategoria')
            ->orderBy('nombreCategoria', 'desc')
            ->get();

        $fechas = Fecha::where('idEdicion', $idEdicion)
            ->where('idCategoria', $idCategoria)
            ->select('id', 'nombre')
            ->orderByDesc('id')
            ->distinct('nombre')
            ->get();

        $grupos = Grupo::where('idEdicion', $idEdicion)
            ->select('id', 'nombre')
            ->where('idCategoria', $idCategoria)
            ->get();

        $fechas = $fechas->unique('nombre');

        if (isset($idFecha) || isset($idGrupo) || isset($idCategoria)) {
            $fecha = $fechas->firstWhere('id', $idFecha);
            $nombreFecha = $fecha ? $fecha->nombre : null;
            $grupo = $grupos->firstWhere('id', $idGrupo);
            $nombreGrupo = $grupo ? $grupo->nombre : null;
            $categoria = $categorias->firstWhere('id', $idCategoria);
            $nombreCategoria = $categoria ? $categoria->nombreCategoria : null;

            return view('Panel.partido.index', compact('partidos', 'ediciones', 'EdicionSeleccionada', 'fechas', 'categorias', 'grupos', 'idCategoria', 'idGrupo', 'nombreFecha', 'nombreGrupo', 'nombreCategoria'));
        }

        return view('Panel.partido.index', compact('partidos', 'ediciones', 'EdicionSeleccionada', 'fechas', 'categorias', 'grupos', 'idCategoria', 'idGrupo'));
    }

    public function create(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $idCategoria = $request->idCategoria;
        $idGrupo = $request->idGrupo;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $GrupoSeleccionado = $idGrupo ? Grupo::find($idGrupo) : null;
        $CategoriaSeleccionada = $idCategoria ? Categoria::find($idCategoria) : null;
        $fechas = Fecha::where('idEdicion', $idEdicion)
            ->where('idCategoria', $idCategoria)
            ->select('id', 'nombre')
            ->orderByDesc('id')
            ->distinct('nombre')
            ->get();
        $dias = Dia::where('idEdicion', $idEdicion)
            ->select('id', 'diaPartido')
            ->orderByDesc('id')
            ->distinct('diaPartido')
            ->get();
        $equipos = Equipo::select('equipos.id', 'equipos.nombre')
            ->join('equipos_grupos', 'equipos.id', '=', 'equipos_grupos.idEquipo')
            ->where('idCategoria', $idCategoria)
            ->where('equipos_grupos.idGrupo', $idGrupo)
            ->where('equipos.idEdicion', $idEdicion)
            ->get();
        $grupo = Grupo::where('id', $idGrupo)->select('id', 'nombre')->get();
        $partido = new Partido();
        return view('Panel.partido.create', compact('ediciones','partido', 'EdicionSeleccionada','GrupoSeleccionado', 'fechas', 'equipos', 'dias', 'grupo', 'idGrupo', 'idCategoria', 'CategoriaSeleccionada'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Partido::create($data);
        $idEdicion = $data['idEdicion'];
        return to_route('partido.index', ['idEdicion' => $idEdicion])->with('status', 'Partido creado con éxito.');
    }

    public function show(Partido $partido)
    {
        return view('partidos.show', compact('partido'));
    }

    public function edit(Partido $partido)
    {
        return view('partidos.edit', compact('partido'));
    }

    public function update(StoreRequest $request, Partido $partido)
    {
        $data = $request->validated();
        $partido->update($data);
        return redirect()->route('partidos.index')->with('status', 'Partido actualizado con éxito.');
    }

    public function destroy(Partido $partido)
    {
        $partido->delete();
        return redirect()->route('partidos.index')->with('status', 'Partido eliminado con éxito.');
    }

    public function cargarResultado(Request $request, Partido $partido)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $idPartido = $request->idPartido;
        $partido = Partido::find($idPartido);
        $golesEquipoLocal = $request->input('golesEquipoLocal');
        $golesEquipoVisitante = $request->input('golesEquipoVisitante');
        
        if(isset($golesEquipoLocal) && isset($golesEquipoVisitante)){
            $this->partidoService->actualizarResultado($partido, $golesEquipoLocal, $golesEquipoVisitante);
            return to_route('partido.index', ['idEdicion' => $idEdicion])->with('status', 'Resultado cargado con éxito.');
        }

        return view('Panel.cargar-resultado', compact('partido', 'ediciones', 'EdicionSeleccionada'));
    }
}
