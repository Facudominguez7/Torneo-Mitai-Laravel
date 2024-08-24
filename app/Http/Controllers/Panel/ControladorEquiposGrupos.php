<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipoGrupo\StoreRequest;
use App\Models\Categoria;
use App\Models\Edicion;
use App\Models\Equipo;
use App\Models\EquipoGrupo;
use App\Models\Grupo;
use App\Traits\SeleccionarCategoriaTrait;
use Illuminate\Http\Request;

class ControladorEquiposGrupos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use SeleccionarCategoriaTrait;
    public function index(Request $request)
    {
       //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $idGrupo = $request->idGrupo;
        $idCategoria = $request->idCategoria;
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $equipos = Equipo::where('idCategoria', $idCategoria)->select('id', 'nombre')->get();
        $CategoriaSeleccionada = $idCategoria ? Categoria::find($idCategoria) : null;
        $GrupoSeleccionado = $idGrupo ? Grupo::find($idGrupo) : null;
        $equipogrupo = new EquipoGrupo();
        return view('panel.equipogrupo.create', compact('equipos', 'equipogrupo', 'ediciones', 'EdicionSeleccionada', 'CategoriaSeleccionada', 'GrupoSeleccionado'));    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        EquipoGrupo::create($request->validated());
        return redirect()->action([ControladorGrupos::class, 'index'], ['idEdicion' => $request->idEdicion])->with('status', 'Equipo agregado al grupo correctamente');
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
    public function edit(Request $request, EquipoGrupo $equipogrupo)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $idCategoria = $request->idCategoria;
        $idGrupo = $request->idGrupo;
        $equipos = Equipo::where('idCategoria', $idCategoria)->get();
        $CategoriaSeleccionada = $idCategoria ? Categoria::find($idCategoria) : null;
        return view('panel.equipogrupo.edit', compact('equipos', 'equipogrupo', 'ediciones', 'EdicionSeleccionada', 'CategoriaSeleccionada', 'idGrupo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, EquipoGrupo $equipogrupo)
    {
        $equipogrupo->update($request->validated());
        $grupo = $equipogrupo->idGrupo;
        return redirect()->action([ControladorGrupos::class, 'show'], ['idEdicion' => $request->idEdicion, 'grupo' => $grupo])->with('status', 'Equipo actualizado correctamente');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, EquipoGrupo $equipogrupo)
    {
        $equipogrupo->delete();
        $grupo = $equipogrupo->idGrupo;
        return redirect()->action([ControladorGrupos::class, 'show'], ['idEdicion' => $request->idEdicion, 'grupo' => $grupo])->with('status', 'Equipo eliminado correctamente');
    }
}
