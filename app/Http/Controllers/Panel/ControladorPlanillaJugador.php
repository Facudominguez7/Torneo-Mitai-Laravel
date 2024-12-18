<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Edicion;
use App\Models\EquipoEdicion;
use App\Models\Jugador;
use App\Models\Partido;
use App\Models\PlanillaJugador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorPlanillaJugador extends Controller
{
    // Mostrar la planilla de jugadores para un partido, diferenciando los equipos local y visitante
    public function mostrarPlanilla(Request $request, $partidoId)
    {
        $ediciones = Edicion::all();
        $idEdicion = $request->idEdicion;
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        // Obtener el partido
        $partido = Partido::findOrFail($partidoId);

        // Obtener jugadores del equipo local
        $jugadoresLocal = PlanillaJugador::where('partido_id', $partidoId)
            ->where('idEquipo', $partido->idEquipoLocal) // Asegúrate de que `equipo_local_id` sea el ID correcto
            ->join('jugadores', 'planilla_jugadores.dni_jugador', '=', 'jugadores.dni')
            ->select('planilla_jugadores.*', 'jugadores.nombre', 'jugadores.apellido')
            ->get();


        // Obtener jugadores del equipo visitante
        $jugadoresVisitante = PlanillaJugador::where('partido_id', $partidoId)
            ->where('idEquipo', $partido->idEquipoVisitante) // Asegúrate de que `equipo_visitante_id` sea el ID correcto
            ->join('jugadores', 'planilla_jugadores.dni_jugador', '=', 'jugadores.dni')
            ->select('planilla_jugadores.*', 'jugadores.nombre', 'jugadores.apellido')
            ->get();

        return view('Panel.planilla.show', compact('partido', 'jugadoresLocal', 'jugadoresVisitante', 'ediciones', 'EdicionSeleccionada'));
    }

    // Agregar un jugador a la planilla del partido, especificando si es equipo local o visitante
    public function agregarJugador(Request $request)
    {
        $idEdicion = $request->idEdicion;
        // Validar que el jugador exista o si es necesario actualizar el dni
        $jugador = Jugador::where('dni', $request->dni_jugador)->first();

        // Si el jugador no existe, se puede crear o actualizar el jugador con el nuevo dni y datos
        if (!$jugador) {
            $jugador = new Jugador();
            $jugador->dni = $request->dni_jugador;  // Asignar el DNI si el jugador no existe
            $jugador->nombre = $request->nombre_jugador;
            $jugador->apellido = $request->apellido_jugador;
            // Guardar los cambios del jugador (o crear el jugador si no existía)
            $jugador->save();
        }

        // Obtener el equipo (local o visitante) al que se va a agregar el jugador
        $equipo = EquipoEdicion::where('idEquipo', $request->equipo_id)
            ->where('idEdicion', $idEdicion)
            ->first();
        if (!$equipo) {
            return redirect()->back()->with('status', 'Equipo no encontrado.');
        }

        // Verificar si el jugador ya está asignado a otro equipo de la misma categoría y edición
        $existeJugadorEnElMismoEquipo = PlanillaJugador::join('equipo_ediciones', 'equipo_ediciones.idEquipo', '=', 'planilla_jugadores.idEquipo')
            ->where('planilla_jugadores.dni_jugador', $jugador->dni)  // Verificar si el jugador ya está en la planilla
            ->where('planilla_jugadores.idEquipo', '!=', $equipo->id)  // Verificar que no esté en el mismo equipo
            ->exists();


        if ($existeJugadorEnElMismoEquipo) {
            return redirect()->back()->with('status', 'El jugador ya está asignado a otro equipo.');
        }

        // Agregar el jugador a la planilla
        $planilla = new PlanillaJugador();
        $planilla->partido_id = $request->partido_id;
        $planilla->dni_jugador = $jugador->dni;
        $planilla->idEquipo = $equipo->idEquipo; // Usamos el equipo (local o visitante)
        $planilla->numero_camiseta = $request->numero_camiseta;
        $planilla->goles = 0;  // Inicializamos los goles a 0
        $planilla->asistio = false;  // Inicializamos asistencia como false
        $planilla->save();

        return redirect()->route('planilla.show', ['partidoId' => $request->partido_id, 'idEdicion' => $idEdicion])
            ->with('status', 'Jugador agregado a la planilla con éxito.');
    }





    // Actualizar los goles y asistencia de un jugador en la planilla
    public function actualizarJugador(Request $request)
    {
        $planilla = PlanillaJugador::where('partido_id', $request->partido_id)
            ->where('dni_jugador', $request->dni_jugador)
            ->where('idEquipo', $request->equipo_id) // Asegurarse que se actualice en el equipo correcto
            ->first();

        if (!$planilla) {
            return redirect()->back()->with('error', 'Jugador no encontrado en la planilla.');
        }

        // Actualizar goles y asistencia
        $planilla->goles = $request->goles;
        $planilla->asistio = $request->has('asistencia');
        $planilla->save();

        // Actualizar goles del jugador en la tabla jugadores
        $jugador = Jugador::where('dni', $request->dni_jugador)->first();
        if ($jugador) {
            $jugador->goles_totales += $request->goles;
            if ($request->goles > 0) {
                $jugador->partidos_totales += 1;
            }
            $jugador->save();
        }

        return redirect()->route('planilla.show', ['partidoId' => $request->partido_id, 'idEdicion' => $request->idEdicion])
            ->with('success', 'Datos de jugador actualizados correctamente.');
    }
}
