<?php

namespace App\Traits;

use App\Models\Categoria;
use App\Models\Edicion;
use Illuminate\Http\Request;

trait SeleccionarEdicionTrait
{
    public function seleccionarEdicion(Request $request)
    {
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $ediciones = Edicion::select('id', 'nombre')->get();
        $tipo = $request->tipo;

        $categorias = Categoria::where('idEdicion', $idEdicion)
        ->orderBy('nombreCategoria', 'desc')
        ->get();

        return view('Panel.seleccionar-edicion', compact('ediciones', 'EdicionSeleccionada', 'tipo' , 'categorias'));
    }
}