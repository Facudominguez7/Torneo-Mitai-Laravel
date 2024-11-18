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
use App\Traits\SeleccionarCategoriaTrait;
use Illuminate\Http\Request;

class ControladorInstanciaFinal extends Controller
{
    use SeleccionarCategoriaTrait;
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
        $equipos = Equipo::where('idCategoria', $idCategoria)
            ->where('idEdicion', $idEdicion)
            ->select('id', 'nombre')
            ->get();
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
}
