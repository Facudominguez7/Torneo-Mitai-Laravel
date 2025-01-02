<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipoEdicion\StoreRequest;
use App\Models\Categoria;
use App\Models\Edicion;
use App\Models\Equipo;
use App\Models\EquipoEdicion;
use App\Traits\SeleccionarEdicionTrait;
use Illuminate\Http\Request;

class ControladorEquiposEdiciones extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use SeleccionarEdicionTrait;
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $idCategoria = $request->idCategoria;
        $idEdicion = $request->idEdicion;
        $edicionfiltro = $request->edicionfiltro;

        $ediciones = Edicion::all();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $CategoriaSeleccionada = $idCategoria ? Categoria::find($idCategoria) : null;

        if ($idCategoria && $idEdicion) {
            $equipos = Equipo::where('equipos.idCategoria', $idCategoria)
                ->where('equipos.idEdicion', $edicionfiltro)
                ->select('equipos.id', 'equipos.nombre')
                ->get();
        } else {
            $equipos = collect(); // Si no hay categoría o edición seleccionada, devuelve un conjunto vacío.
        }
        $equipoedicion = new EquipoEdicion();
        return view('Panel.equipoedicion.create', compact('equipos', 'equipoedicion', 'ediciones', 'EdicionSeleccionada', 'CategoriaSeleccionada'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        EquipoEdicion::create($request->validated());
        return redirect()->action([ControladorEquipo::class, 'index'], ['idEdicion' => $request->idEdicion])->with('status', 'Equipo asociado a la nueva edicion correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, EquipoEdicion $equipoedicion)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $equipos = Equipo::whereHas('equipoEdiciones', function ($query) use ($idEdicion) {
            $query->where('idEdicion', $idEdicion);
        })->get();
        return view('Panel.equipoedicion.edit', compact('equipos', 'equipoedicion', 'ediciones', 'EdicionSeleccionada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, EquipoEdicion $equipoedicion)
    {
        $equipoedicion->update($request->validated());
        return redirect()->action([ControladorEquipo::class, 'show'], ['idEdicion' => $request->idEdicion])->with('status', 'Equipo actualizado correctamente');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Equipo $equipo)
    {
        return to_route('equipo.index', ['idEdicion' => $request->idEdicion])->with('status', 'Equipo Eliminado');
    }
}
