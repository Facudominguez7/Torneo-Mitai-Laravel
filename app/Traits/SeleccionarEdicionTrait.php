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

        $categorias = Categoria::where(function ($query) use ($idEdicion) {
            $query->where('idEdicion', $idEdicion)
            ->orWhereNull('idEdicion')
            ->orWhere('idEdicion', 3)
            ->orWhere('idEdicion', 2);
        })
        ->orderBy('nombreCategoria', 'desc')
        ->get();

        return view('Panel.seleccionar-edicion', compact('ediciones', 'EdicionSeleccionada', 'tipo' , 'categorias'));
    }
}