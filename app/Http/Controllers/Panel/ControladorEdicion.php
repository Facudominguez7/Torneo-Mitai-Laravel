<?php
namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Edicion\StoreRequest;
use App\Models\Edicion;
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
        return view('Panel.edicion.create', compact('ediciones', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Edicion::create($data);
        return to_route('edicion.index');
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