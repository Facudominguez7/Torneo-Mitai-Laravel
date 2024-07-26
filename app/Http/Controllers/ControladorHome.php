<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Edicion;
use Illuminate\Http\Request;

class ControladorHome extends Controller
{
    public function index(Request $request)
    {
        // Recuperar todas las ediciones de la base de datos
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $idCategoria = $request->query('idCategoria');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $categorias = Categoria::query();
        if ($EdicionSeleccionada) {
            $categorias = $categorias->where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        }
    
        return view('welcome', compact('ediciones', 'EdicionSeleccionada', 'categorias', 'idEdicion', 'idCategoria'));
    }

    public function admin(Request $request)
    {
        $idEdicion = $request->query('idEdicion');
    
        $ediciones = Edicion::all();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        
    
        return view('Panel.admin', compact('EdicionSeleccionada', 'ediciones', 'idEdicion'));
    }
}
