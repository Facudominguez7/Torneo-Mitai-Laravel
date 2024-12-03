<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Equipo\StoreRequest;
use App\Models\Categoria;
use App\Models\Edicion;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControladorEquipo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        if ($idEdicion) {
            if ($idEdicion > 3) {
            $equipos = Equipo::join('equipo_ediciones', 'equipos.id', '=', 'equipo_ediciones.idEquipo')
                ->join('categorias', 'equipos.idCategoria', '=', 'categorias.id')
                ->where('equipo_ediciones.idEdicion', $idEdicion)
                ->orderBy('categorias.nombreCategoria', 'desc')
                ->select('equipos.*', 'categorias.nombreCategoria')
                ->paginate(7);
            } else {
            $equipos = Equipo::join('categorias', 'equipos.idCategoria', '=', 'categorias.id')
                ->where('equipos.idEdicion', $idEdicion)
                ->orderBy('categorias.nombreCategoria', 'desc')
                ->select('equipos.*')
                ->paginate(7);
            }
        
            $equipos->appends(['idEdicion' => $idEdicion]);
        } else {
            $equipos = collect(); // Si no hay edición seleccionada, no se cargan equipos.
        }
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('Panel.equipo.index', compact('EdicionSeleccionada', 'ediciones', 'equipos', 'idEdicion'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ediciones = Edicion::all();
        $equipo = new Equipo();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $categorias = Categoria::where('idEdicion', $idEdicion)
            ->orderBy('nombreCategoria', 'desc')
            ->pluck('nombreCategoria', 'id');

        return view('Panel.equipo.create', compact('ediciones', 'categorias', 'EdicionSeleccionada',  'equipo', 'idEdicion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('foto')) {
            $data['foto'] = $filename = time().'.'.$data['foto']->extension();
            $request->foto->move(public_path('fotos/equipos'), $filename);
        }
        Equipo::create($data);
        return to_route('equipo.index', ['idEdicion' => $request->idEdicion])->with('status', 'Equipo Creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Equipo $equipo)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('Panel.equipo.show', compact('equipo', 'ediciones', 'idEdicion', 'EdicionSeleccionada'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipo $equipo)
    {
        $ediciones = Edicion::all();
        $idEdicion = $equipo->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $categorias = Categoria::where('idEdicion', $idEdicion)
            ->orderBy('nombreCategoria', 'desc')
            ->pluck('nombreCategoria', 'id');

        return view('Panel.equipo.edit', compact('ediciones', 'categorias', 'equipo', 'EdicionSeleccionada', 'idEdicion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Equipo $equipo)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $filename = time().'.'.$data['foto']->extension();
            $request->foto->move(public_path('fotos/equipos'), $filename);
        } 
        
        $equipo->update($data);
        return to_route('equipo.index', ['idEdicion' => $request->idEdicion])->with('status', 'Equipo Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Equipo $equipo)
    {
        $equipo->delete();
        return to_route('equipo.index', ['idEdicion' => $request->idEdicion])->with('status', 'Equipo Eliminado');
    }
}
