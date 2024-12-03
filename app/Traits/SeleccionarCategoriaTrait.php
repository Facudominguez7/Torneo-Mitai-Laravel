<?php

namespace App\Traits;

use App\Models\Edicion;
use App\Models\Categoria;
use App\Models\Grupo;
use Illuminate\Http\Request;

trait SeleccionarCategoriaTrait
{
    public function seleccionarCategoria(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $categorias = Categoria::where(function ($query) use ($idEdicion) {
            $query->where('idEdicion', $idEdicion)
            ->orWhereNull('idEdicion')
            ->orWhere('idEdicion', 3);
        })
        ->orderBy('nombreCategoria', 'desc')
        ->get();
        $tipo = $request->tipo;

        if ($tipo === 'equipogrupo' || $tipo === 'partido') {
            $idCategoria = $request->query('idCategoria');
            $grupos = Grupo::where('idEdicion', $idEdicion)
                ->where('idCategoria', $idCategoria)
                ->get();
            return view('Panel.seleccionar-categoria', compact('tipo', 'categorias', 'ediciones', 'EdicionSeleccionada', 'grupos'));
        }
        return view('Panel.seleccionar-categoria', compact('tipo', 'categorias', 'ediciones', 'EdicionSeleccionada'));
    }
}
