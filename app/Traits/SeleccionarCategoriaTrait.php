<?php
namespace App\Traits;

use App\Models\Edicion;
use App\Models\Categoria;
use Illuminate\Http\Request;

trait SeleccionarCategoriaTrait
{
    public function seleccionarCategoria(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $categorias = Categoria::where('idEdicion', $idEdicion)
                ->orderBy('nombreCategoria', 'desc')
                ->get();
        return view('panel.seleccionar-categoria', compact('tipo', 'categorias', 'ediciones', 'EdicionSeleccionada'));
    }
}
