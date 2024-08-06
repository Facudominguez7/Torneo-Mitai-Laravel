<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Edicion;
use App\Models\User;
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
        $roles = User::pluck('rol');
        if ($EdicionSeleccionada) {
            $categorias = $categorias->where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        }
    
        return view('welcome', compact('ediciones', 'EdicionSeleccionada', 'categorias', 'idEdicion', 'idCategoria', 'roles'));
    }

    public function admin(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        return view('Panel.admin', compact('ediciones', 'EdicionSeleccionada'));
    }
}
