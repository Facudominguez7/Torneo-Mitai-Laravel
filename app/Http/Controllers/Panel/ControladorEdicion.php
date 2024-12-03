<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Edicion\StoreRequest;
use App\Models\Categoria;
use App\Models\Edicion;
use App\Models\Equipo;
use Illuminate\Http\Request;


class ControladorEdicion extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('Panel.edicion.index', compact('ediciones', 'EdicionSeleccionada'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ediciones = Edicion::all();
        $edicion = new Edicion();

        // Obtén las categorías disponibles
        $categorias = Categoria::all();
        $categorias = Categoria::where('idEdicion', 3)->get();

        // Si se seleccionó una categoría, filtrar los equipos por esa categoría
        $equipos = Equipo::when($request->idCategoria, function ($query) use ($request) {
            return $query->where('idCategoria', $request->idCategoria); // Filtrar por categoría seleccionada
        })->get();

        $idCategoria = $request->idCategoria; // Obtener la categoría seleccionada para pasarla a la vista

        // Crear una nueva instancia de Edicion
        $edicion = new Edicion();

        // Retornar la vista con las variables necesarias
        return view('Panel.edicion.create', compact('ediciones', 'edicion', 'equipos', 'categorias', 'idCategoria'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        // Crear la nueva edición
        $edicion = Edicion::create([
            'nombre' => $data['nombre'],
        ]);

        // Asignar los equipos seleccionados a la edición
        $edicion->equipos()->sync($data['equipos']); // Esto sincroniza los equipos seleccionados en la tabla pivot equipo_ediciones

        return to_route('edicion.index')->with('status', 'Edición creada con éxito.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, Edicion $edicion)
    {
        $ediciones = Edicion::all();
        return view('Panel.edicion.show', compact('ediciones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Edicion $edicion)
    {
        $ediciones = Edicion::all();
        return view('Panel.edicion.edit', compact('ediciones', 'edicion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Edicion $edicion)
    {
        $data = $request->validated();

        $edicion->update($data);
        return to_route('edicion.index', ['idEdicion' => $request->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Edicion $edicion)
    {
        $edicion->delete();
        return to_route('edicion.index', ['idEdicion' => $request->id]);
    }
}
