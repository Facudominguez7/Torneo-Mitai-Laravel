<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Edicion;
use App\Models\EquipoEdicion;
use App\Models\Jugador;
use App\Models\Partido;
use App\Models\InstanciaFinal;
use App\Models\PlanillaJugador;
use App\Models\TablaGoleador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorPlanillaJugador extends Controller
{
    public function mostrarPlanilla(Request $request, $partidoId, $idEdicion, $tipoPartido)
    {
        $ediciones = Edicion::all();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;

        // Obtener el partido o instancia final
        if ($tipoPartido === 'instanciaFinal') {
            $partido = InstanciaFinal::findOrFail($partidoId);
        } else {
            $partido = Partido::findOrFail($partidoId);
        }

        // Obtener jugadores locales que ya están en la planilla del partido actual
        $jugadoresLocalExistentes = PlanillaJugador::where('partido_id', $partidoId)
            ->where('idEquipo', $partido->idEquipoLocal)
            ->where('idEdicion', $idEdicion)
            ->pluck('dni_jugador')
            ->toArray();

        // Obtener todos los jugadores del equipo local desde equipo_ediciones
        $jugadoresLocal = Jugador::join('planilla_jugadores', 'jugadores.dni', '=', 'planilla_jugadores.dni_jugador')
            ->join('equipo_ediciones', 'planilla_jugadores.idEquipo', '=', 'equipo_ediciones.idEquipo')
            ->where('equipo_ediciones.idEquipo', $partido->idEquipoLocal)
            ->where('planilla_jugadores.idEdicion', $idEdicion)
            ->select('jugadores.*', 'planilla_jugadores.fecha_nacimiento')
            ->get();

        // Agregar los jugadores faltantes a la planilla del equipo local
        foreach ($jugadoresLocal as $jugador) {
            if (!in_array($jugador->dni, $jugadoresLocalExistentes)) {
                PlanillaJugador::firstOrCreate([
                    'partido_id' => $partidoId,
                    'partido_type' => $tipoPartido === 'instanciaFinal' ? InstanciaFinal::class : Partido::class,
                    'dni_jugador' => $jugador->dni,
                    'fecha_nacimiento' => $jugador->fecha_nacimiento,
                    'idEquipo' => $partido->idEquipoLocal,
                    'idEdicion' => $idEdicion,
                ], [
                    'numero_camiseta' => 0, // Inicializamos en 0
                    'goles' => 0,
                    'asistio' => false,
                ]);
            }
        }

        // Obtener jugadores visitantes que ya están en la planilla del partido actual
        $jugadoresVisitanteExistentes = PlanillaJugador::where('partido_id', $partidoId)
            ->where('idEquipo', $partido->idEquipoVisitante)
            ->where('idEdicion', $idEdicion)
            ->pluck('dni_jugador')
            ->toArray();

        // Obtener todos los jugadores del equipo visitante desde equipo_ediciones
        $jugadoresVisitante = Jugador::join('planilla_jugadores', 'jugadores.dni', '=', 'planilla_jugadores.dni_jugador')
            ->join('equipo_ediciones', 'planilla_jugadores.idEquipo', '=', 'equipo_ediciones.idEquipo')
            ->where('equipo_ediciones.idEquipo', $partido->idEquipoVisitante)
            ->where('planilla_jugadores.idEdicion', $idEdicion)
            ->select('jugadores.*', 'planilla_jugadores.fecha_nacimiento', 'planilla_jugadores.partido_type')
            ->get();

        // Agregar los jugadores faltantes a la planilla del equipo visitante
        foreach ($jugadoresVisitante as $jugador) {
            if (!in_array($jugador->dni, $jugadoresVisitanteExistentes)) {
                PlanillaJugador::firstOrCreate([
                    'partido_id' => $partidoId,
                    'partido_type' => $tipoPartido === 'instanciaFinal' ? InstanciaFinal::class : Partido::class,
                    'dni_jugador' => $jugador->dni,
                    'fecha_nacimiento' => $jugador->fecha_nacimiento,
                    'idEquipo' => $partido->idEquipoVisitante,
                    'idEdicion' => $idEdicion,
                ], [
                    'numero_camiseta' => 0, // Inicializamos en 0
                    'goles' => 0,
                    'asistio' => false,
                ]);
            }
        }

        // Obtener la planilla para mostrar los jugadores locales
        $jugadoresLocalPlanilla = PlanillaJugador::where('partido_id', $partidoId)
            ->where('idEquipo', $partido->idEquipoLocal)
            ->where('idEdicion', $idEdicion)
            ->join('jugadores', 'planilla_jugadores.dni_jugador', '=', 'jugadores.dni')
            ->select('planilla_jugadores.*', 'jugadores.nombre', 'jugadores.apellido')
            ->get();

        // Obtener la planilla para mostrar los jugadores visitantes
        $jugadoresVisitantePlanilla = PlanillaJugador::where('partido_id', $partidoId)
            ->where('idEquipo', $partido->idEquipoVisitante)
            ->where('idEdicion', $idEdicion)
            ->join('jugadores', 'planilla_jugadores.dni_jugador', '=', 'jugadores.dni')
            ->select('planilla_jugadores.*', 'jugadores.nombre', 'jugadores.apellido')
            ->get();

        return view('Panel.planilla.show', compact('partido', 'jugadoresLocalPlanilla', 'jugadoresVisitantePlanilla', 'ediciones', 'EdicionSeleccionada', 'tipoPartido'));
    }



    // Agregar un jugador a la planilla del partido, especificando si es equipo local o visitante
    public function agregarJugador(Request $request)
    {
        $idEdicion = $request->idEdicion;
        $tipoPartido = $request->tipoPartido;
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
            ->where('planilla_jugadores.idEquipo', '!=', $equipo->idEquipo)  // Verificar que no esté en el mismo equipo
            ->where('equipo_ediciones.idEdicion', $idEdicion)  // Verificar que sea la misma edición
            ->exists();

        if ($existeJugadorEnElMismoEquipo) {
            return redirect()->back()->with('status', 'El jugador ya está asignado a otro equipo en la misma edición.');
        }

        // Verificar si el jugador ya está en la planilla del mismo equipo y edición
        $existeJugadorEnPlanilla = PlanillaJugador::where('partido_id', $request->partido_id)
            ->where('dni_jugador', $jugador->dni)
            ->where('idEquipo', $equipo->idEquipo)
            ->where('idEdicion', $idEdicion)
            ->exists();

        if ($existeJugadorEnPlanilla) {
            return redirect()->back()->with('status', 'El jugador ya está en la planilla de este equipo y edición.');
        }

        // Agregar el jugador a la planilla
        $planilla = new PlanillaJugador();
        $planilla->partido_id = $request->partido_id;
        $planilla->partido_type = $tipoPartido === 'instancia_final' ? InstanciaFinal::class : Partido::class;
        $planilla->dni_jugador = $jugador->dni;
        $planilla->idEquipo = $equipo->idEquipo; // Usamos el equipo (local o visitante)
        $planilla->idEdicion = $idEdicion; // Asignar la edición
        $planilla->numero_camiseta = $request->numero_camiseta;
        $planilla->fecha_nacimiento = $request->fecha_nacimiento;
        $planilla->goles = 0;  // Inicializamos los goles a 0
        $planilla->asistio = false;  // Inicializamos asistencia como false
        $planilla->save();

        return redirect()->route('planilla.show', ['partidoId' => $request->partido_id, 'idEdicion' => $idEdicion, 'tipoPartido' => $tipoPartido])
            ->with('status', 'Jugador agregado a la planilla con éxito.');
    }

    // Actualizar los goles y asistencia de un jugador en la planilla
    public function actualizarJugador(Request $request)
    {
        $tipoPartido = $request->tipoPartido;
        $planilla = PlanillaJugador::where('partido_id', $request->partido_id)
            ->where('dni_jugador', $request->dni_jugador)
            ->where('idEquipo', $request->equipo_id) // Asegurarse que se actualice en el equipo correcto
            ->first();

        if (!$planilla) {
            return redirect()->back()->with('status', 'Jugador no encontrado en la planilla.');
        }

        // Guardar los valores actuales antes de actualizar
        $golesAnteriores = $planilla->goles;
        $asistioAnteriormente = $planilla->asistio;

        // Actualizar goles y asistencia
        $planilla->goles = $request->goles;
        $planilla->asistio = $request->has('asistencia');
        $planilla->numero_camiseta = $request->numero_camiseta;
        $planilla->save();

        // Actualizar goles del jugador en la tabla jugadores
        $jugador = Jugador::where('dni', $request->dni_jugador)->first();
        if ($jugador) {
            // Ajustar los goles totales del jugador
            $jugador->goles_totales += ($request->goles - $golesAnteriores);
            // Ajustar los partidos totales del jugador
            if ($request->goles > 0 || $request->has('asistencia')) {
                if (!$asistioAnteriormente) {
                    $jugador->partidos_totales += 1;
                }
            } else {
                if ($asistioAnteriormente) {
                    $jugador->partidos_totales -= 1;
                }
            }
            $jugador->save();
        }

        // Actualizar goles en la tabla de goleadores
        $goleador = TablaGoleador::where('dni_jugador', $request->dni_jugador)->first();
        if ($goleador) {
            // Ajustar los goles totales del goleador
            $goleador->cantidadGoles += ($request->goles - $golesAnteriores);
            $goleador->save();
        } else {
            // Crear un nuevo registro en la tabla de goleadores si no existe
            TablaGoleador::create([
                'dni_jugador' => $request->dni_jugador,
                'cantidadGoles' => $request->goles,
                'idEquipo' => $request->equipo_id,
                'idEdicion' => $request->idEdicion,
                'idCategoria' => $request->idCategoria,
                'nombre' => $request->apellido . ' ' . $request->nombre,
            ]);
        }

        return redirect()->route('planilla.show', ['partidoId' => $request->partido_id, 'idEdicion' => $request->idEdicion, 'tipoPartido' => $tipoPartido])
            ->with('status', 'Datos de jugador actualizados correctamente.');
    }
}
