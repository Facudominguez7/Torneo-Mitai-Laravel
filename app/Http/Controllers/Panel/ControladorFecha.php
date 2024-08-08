<?php

namespace App\Http\Controllers\Panel;

use App\Models\Fecha;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fecha\StoreRequest;
use App\Models\Categoria;
use App\Models\Edicion;
use Illuminate\Http\Request;

class ControladorFecha extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $fechas = Fecha::where('idEdicion', $idEdicion)->orderBy('id', 'desc')->take(2)->paginate(7);
        $fechas->appends(['idEdicion' => $idEdicion]);
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('panel.fecha.index', compact('ediciones', 'EdicionSeleccionada', 'fechas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $fecha = new Fecha();
        return view('panel.fecha.create', compact('ediciones', 'EdicionSeleccionada', 'fecha'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $idEdicion = $data['idEdicion'];
        $nombre = $data['nombre'];
        // Obtén todas las categorías existentes
        $categorias = Categoria::where('idEdicion', $idEdicion)->get();
        foreach ($categorias as $categoria) {
            // Crea un registro en la tabla fechas para cada categoría
            Fecha::create([
                'nombre' => $nombre,
                'idEdicion' => $idEdicion,
                'idCategoria' => $categoria->id
            ]);
        }

        return to_route('fecha.index', ['idEdicion' => $idEdicion])
            ->with('status', 'Fecha creada y asociada a todas las categorías.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fecha $fecha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fecha $fecha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fecha $fecha)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fecha $fecha)
    {
        //
    }
}
