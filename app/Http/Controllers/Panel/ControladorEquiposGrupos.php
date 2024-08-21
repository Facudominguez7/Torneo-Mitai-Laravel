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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
