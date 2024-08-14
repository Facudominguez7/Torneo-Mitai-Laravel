<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dia\StoreRequest;
use App\Models\Dia;
use App\Models\Edicion;
use Illuminate\Http\Request;

class ControladorDias extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $dias = Dia::where('idEdicion', $idEdicion)->orderBy('id', 'desc')->paginate(7);
        $dias->appends(['idEdicion' => $idEdicion]);
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('panel.dia.index', compact('ediciones', 'EdicionSeleccionada', 'dias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ediciones = Edicion::all();
        $dia = new Dia();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('panel.dia.create', compact('ediciones', 'dia', 'EdicionSeleccionada'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Dia::create($data);
        return to_route('dia.index',['idEdicion' => $request->idEdicion])->with('status', 'Dia Creado');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Dia $dium)
    {
        $ediciones = Edicion::all();
        $dia = $dium;
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('panel.dia.edit', compact('ediciones', 'dia', 'EdicionSeleccionada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Dia $dium)
    {
        $data = $request->validated();
        $dia = $dium;
        $dia->update($data);
        return to_route('dia.index', ['idEdicion' => $dia->idEdicion])->with('status', 'Dia Editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dia $dium)
    {
        $dia = $dium;
        $dia->delete();
        return to_route('dia.index', ['idEdicion' => $dia->idEdicion])->with('status', 'Dia Eliminado');
    }
}
