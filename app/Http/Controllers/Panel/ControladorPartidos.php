<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Partido\StoreRequest;
use App\Models\Edicion;
use App\Models\Partido;
use App\Services\PartidoService;
use Illuminate\Http\Request;

class ControladorPartidos extends Controller
{
    protected $partidoService;

    public function __construct(PartidoService $partidoService)
    {
        $this->partidoService = $partidoService;
    }

    public function index(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $partidos = Partido::where('idEdicion', $idEdicion)
        ->with([
            'equipoLocal:id,nombre',
            'equipoVisitante:id,nombre',
            'fecha:id,nombre', 
            'dia:id,diaPartido', 
        ])
        ->select('id', 'idFechas', 'idEquipoLocal', 'idEquipoVisitante', 'idGrupo', 'idEdicion', 'golesEquipoLocal', 'golesEquipoVisitante', 'horario', 'cancha', 'idDia', 'jugado')
        ->paginate(7);
        $partidos->appends(['idEdicion' => $idEdicion]);
        return view('panel.partido.index', compact('partidos', 'ediciones', 'EdicionSeleccionada'));
    }

    public function create()
    {
        return view('partidos.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Partido::create($data);
        return redirect()->route('partidos.index')->with('status', 'Partido creado con éxito.');
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
        $golesEquipoLocal = $request->input('golesEquipoLocal');
        $golesEquipoVisitante = $request->input('golesEquipoVisitante');
        $this->partidoService->actualizarResultado($partido, $golesEquipoLocal, $golesEquipoVisitante);
        return redirect()->route('partidos.show', $partido)->with('status', 'Resultado cargado con éxito.');
    }
}
