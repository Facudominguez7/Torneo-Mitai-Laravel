<?php

namespace App\Http\Controllers;

use App\Models\Campeon;
use App\Models\Categoria;
use App\Models\Edicion;
use App\Models\Goleador;
use App\Models\Subcampeon;
use App\Models\User;
use App\Models\VallaMenosVencida;
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
    
    public function campeones(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $categorias = Categoria::query();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        if ($EdicionSeleccionada) {
            $categorias = $categorias->where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        }
        $campeonesOro = Campeon::where('campeones.idEdicion', $idEdicion)
            ->join('copas', 'campeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Oro')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'campeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();

        $campeonesPlata = Campeon::where('campeones.idEdicion', $idEdicion)
            ->join('copas', 'campeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Plata')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'campeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();
        return view('layouts.campeones', compact('ediciones', 'EdicionSeleccionada', 'categorias', 'campeonesOro', 'campeonesPlata'));
    }

    public function subcampeones(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $categorias = Categoria::query();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        if ($EdicionSeleccionada) {
            $categorias = $categorias->where('idEdicion', $idEdicion)->orderBy('nombreCategoria', 'desc')->get();
        }
        $subcampeonesOro = Subcampeon::where('subcampeones.idEdicion', $idEdicion)
            ->join('copas', 'subcampeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Oro')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'subcampeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();
        $subcampeonesPlata = Subcampeon::where('subcampeones.idEdicion', $idEdicion)
            ->join('copas', 'subcampeones.idCopa', '=', 'copas.id')
            ->where('copas.nombre', 'Copa de Plata')
            ->with(['equipo', 'categoria'])
            ->join('categorias', 'subcampeones.idCategoria', '=', 'categorias.id')
            ->orderBy('categorias.nombreCategoria', 'desc')
            ->get();
        return view('layouts.subcampeones', compact('ediciones', 'EdicionSeleccionada', 'categorias', 'subcampeonesOro', 'subcampeonesPlata'));
    }
    public function goleadores(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        // Obtener los datos de los goleadores
        $goleadores = Goleador::where('goleadores.idEdicion', $idEdicion)
            ->join('equipos', 'goleadores.idEquipo', '=', 'equipos.id')
            ->join('categorias', 'goleadores.idCategoria', '=', 'categorias.id')
            ->select('goleadores.nombre as nombre_jugador', 'equipos.nombre as nombre_equipo', 'equipos.foto as foto_equipo', 'categorias.nombreCategoria as categoria_nombre')
            ->orderBy('categoria_nombre', 'desc')
            ->get();

        return view('layouts.goleadores', compact('ediciones', 'EdicionSeleccionada', 'goleadores'));
    }
    public function vallas(Request $request)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->query('idEdicion');
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;

        $vallas = VallaMenosVencida::where('vallas_menos_vencidas.idEdicion', $idEdicion)
            ->join('equipos', 'vallas_menos_vencidas.idEquipo', '=', 'equipos.id')
            ->join('categorias', 'vallas_menos_vencidas.idCategoria', '=', 'categorias.id')
            ->select('vallas_menos_vencidas.nombre as nombre_jugador', 'equipos.nombre as nombre_equipo', 'equipos.foto as foto_equipo', 'categorias.nombreCategoria as categoria_nombre')
            ->orderBy('categoria_nombre', 'desc')
            ->get();

        return view('layouts.vallas', compact('ediciones', 'EdicionSeleccionada', 'vallas'));
    }
}
