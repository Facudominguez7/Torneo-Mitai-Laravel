<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstanciaFinal\StoreRequest;
use App\Models\Categoria;
use App\Models\Copa;
use App\Models\Dia;
use App\Models\Edicion;
use App\Models\Equipo;
use App\Models\Fase;
use App\Models\InstanciaFinal;
use App\Services\PartidoService;
use App\Traits\SeleccionarCategoriaTrait;
use Illuminate\Http\Request;

class ControladorInstanciaFinal extends Controller
{
    use SeleccionarCategoriaTrait;
    protected $partidoService;

    public function __construct(PartidoService $partidoService)
    {
        $this->partidoService = $partidoService;
    }

    public function index(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $idCategoria = $request->idCategoria;
        $idFase = $request->idFase;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;

        $query = InstanciaFinal::query();

        if ($idEdicion) {
            $query->where('idEdicion', $idEdicion);
        }

        if ($idCategoria) {
            $query->where('idCategoria', $idCategoria);
        }

        if ($idFase) {
            $query->where('idFase', $idFase);
        }

        $partidos = $query
            ->with([
                'equipoLocal:id,nombre,foto',
                'equipoVisitante:id,nombre,foto',
                'fase:id,nombre',
                'categoria:id,nombreCategoria'
            ])
            ->select('instancias_finales.*')
            ->orderByDesc('instancias_finales.id')
            ->paginate(7);

        $categorias = Categoria::where('idEdicion', $idEdicion)
            ->select('id', 'nombreCategoria')
            ->orderBy('nombreCategoria', 'desc')
            ->get();

        $fases = Fase::query()
            ->select('id', 'nombre')
            ->orderBy('nombre', 'desc')
            ->get();

        $nombreFase = $fases->firstWhere('id', $idFase)->nombre ?? null;
        $nombreCategoria = $categorias->firstWhere('id', $idCategoria)->nombreCategoria ?? null;

        return view('Panel.instancia_final.index', compact('partidos', 'ediciones', 'EdicionSeleccionada', 'fases', 'categorias', 'idCategoria', 'nombreFase', 'nombreCategoria'));
    }

    public function create(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $idCategoria = $request->idCategoria;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $CategoriaSeleccionada = $idCategoria ? Categoria::find($idCategoria) : null;
        $fases = Fase::query()
            ->select('id', 'nombre')
            ->orderBy('nombre', 'desc')
            ->get();
        if ($idEdicion > 3) {
            $equipos = Equipo::select('equipos.id', 'equipos.nombre')
                ->join('equipo_ediciones', 'equipos.id', '=', 'equipo_ediciones.idEquipo') // 
                ->where('equipo_ediciones.idEdicion', $idEdicion)                         // Filtrar por edición  
                ->where('equipos.idCategoria', $idCategoria)                              // Filtrar por categoría
                ->get();
        } else {
            $equipos = Equipo::select('equipos.id', 'equipos.nombre')
                ->join('equipos_grupos', 'equipos.id', '=', 'equipos_grupos.idEquipo')
                ->where('equipos.idEdicion', $idEdicion)
                ->where('idCategoria', $idCategoria)
                ->get();
        }
        $copas = Copa::orderByDesc('nombre')->get();
        $partido = new InstanciaFinal();
        return view('Panel.instancia_final.create', compact('ediciones', 'partido', 'EdicionSeleccionada', 'fases', 'equipos', 'idCategoria', 'CategoriaSeleccionada', 'copas'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        InstanciaFinal::create($data);
        $idEdicion = $data['idEdicion'];
        return to_route('instancia_final.index', ['idEdicion' => $idEdicion])->with('status', 'Partido creado con éxito.');
    }

    public function cargarResultadoInstancia(Request $request, InstanciaFinal $partido)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $idPartido = $request->idPartido;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $partido = InstanciaFinal::find($idPartido);
        $golesEquipoLocal = $request->input('golesEquipoLocal');
        $golesEquipoVisitante = $request->input('golesEquipoVisitante');
        $penalesEquipoLocal = $request->input('penalesEquipoLocal');
        $penalesEquipoVisitante = $request->input('penalesEquipoVisitante');
        $resultadoGlobal = $request->input('resultadoGlobal');

        if (!is_null($golesEquipoLocal) && !is_null($golesEquipoVisitante)) {
            $partido->golesEquipoLocal = $golesEquipoLocal;
            $partido->golesEquipoVisitante = $golesEquipoVisitante;
            $partido->penalesEquipoLocal = $penalesEquipoLocal;
            $partido->penalesEquipoVisitante = $penalesEquipoVisitante;
            $partido->resultadoGlobal = $resultadoGlobal;
            $partido->save();
            $this->partidoService->actualizarHistorialInstanciasFinales($partido, $golesEquipoLocal, $golesEquipoVisitante);
            $this->partidoService->actualizarGolesContraEquipoEdicion($partido->idEquipoLocal, $partido->idEdicion);
            $this->partidoService->actualizarGolesContraEquipoEdicion($partido->idEquipoVisitante, $partido->idEdicion);
            return to_route('instancia_final.index', ['idEdicion' => $idEdicion])->with('status', 'Resultado cargado con éxito.');
        }

        return view('Panel.cargar-resultado', compact('partido', 'ediciones', 'EdicionSeleccionada'));
    }
}
