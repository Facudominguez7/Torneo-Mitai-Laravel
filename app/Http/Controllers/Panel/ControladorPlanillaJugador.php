<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
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
    public function mostrarPlanilla(Request $request, $partidoId, $idEdicion, $tipoPartido, $horario)
    {
        $ediciones = Edicion::all();
        $EdicionSeleccionada = $idEdicion ? Edicion::find($idEdicion) : null;
        $horarioSeleccionado = $horario;

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
            ->select('jugadores.*', 'planilla_jugadores.fecha_nacimiento', 'planilla_jugadores.idCategoria', 'planilla_jugadores.partido_type')
            ->selectSub(function ($query) {
                $query->from('planilla_jugadores')
                    ->select('numero_camiseta')
                    ->whereColumn('dni_jugador', 'jugadores.dni')
                    ->orderByDesc('updated_at') // Ordenar por la última actualización
                    ->limit(1);
            }, 'numero_camiseta') // Alias para que se use como número de camiseta final
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
                    'idCategoria' => $jugador->idCategoria,
                    'numero_camiseta' => $jugador->numero_camiseta,
                ], [
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
            ->select('jugadores.*', 'planilla_jugadores.fecha_nacimiento', 'planilla_jugadores.idCategoria', 'planilla_jugadores.partido_type')
            ->selectSub(function ($query) {
                $query->from('planilla_jugadores')
                    ->select('numero_camiseta')
                    ->whereColumn('dni_jugador', 'jugadores.dni')
                    ->orderByDesc('updated_at') // Ordenar por última actualización
                    ->limit(1);
            }, 'numero_camiseta') // Alias para que se use como número de camiseta final
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
                    'idCategoria' => $jugador->idCategoria,
                    'numero_camiseta' => $jugador->numero_camiseta,
                ], [
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

        return view('Panel.planilla.show', compact('partido', 'jugadoresLocalPlanilla', 'jugadoresVisitantePlanilla', 'ediciones', 'EdicionSeleccionada', 'tipoPartido', 'horarioSeleccionado'));
    }



    public function agregarJugador(Request $request)
    {
        $idEdicion = $request->idEdicion;
        $tipoPartido = $request->tipoPartido;
        $horarioSeleccionado = $request->horario;
        $fecha_nacimiento = $request->fecha_nacimiento;
        $partidoId = $request->partido_id;

        // Validar si ya existe un jugador con el mismo DNI
        $jugador = Jugador::where('dni', $request->dni_jugador)->first();

        if ($jugador) {
            // Validar si el nombre o apellido no coincide
            if ($jugador->nombre !== $request->nombre_jugador || $jugador->apellido !== $request->apellido_jugador) {
                return redirect()->back()->with('status', 'Ya existe un jugador con este DNI, pero con un nombre o apellido diferente.');
            }

            // Verificar si el jugador ya está asignado al equipo actual
            if (PlanillaJugador::where('dni_jugador', $request->dni_jugador)
                ->where('idEquipo', $request->equipo_id)
                ->where('idEdicion', $idEdicion)
                ->exists()
            ) {
                return redirect()->back()->with('status', 'El jugador ya pertenece a este equipo.');
            }

            // Verificar si el jugador pertenece a otro equipo de la misma categoría y edición
            $jugadorEnOtroEquipo = PlanillaJugador::where('dni_jugador', $request->dni_jugador)
                ->where('idEquipo', '!=', $request->equipo_id)
                ->where('idEdicion', $idEdicion)
                ->where('idCategoria', $request->idCategoria)
                ->first();

            if ($jugadorEnOtroEquipo) {
                // Realizar un join desde EquipoEdicion para obtener el nombre del equipo
                $equipoAsignado = EquipoEdicion::join('equipos', 'equipo_ediciones.idEquipo', '=', 'equipos.id')
                    ->where('equipo_ediciones.idEquipo', $jugadorEnOtroEquipo->idEquipo)
                    ->select('equipos.nombre')
                    ->first();
                $mensaje = 'El jugador ya está asignado al equipo ' . $equipoAsignado->nombre . ' en la misma categoría y edición.';
                return redirect()->back()->with('status', $mensaje);
            }

            // Obtener las categorías del jugador y del equipo actual
            $categoriasJugador = PlanillaJugador::join('equipo_ediciones', 'planilla_jugadores.idEquipo', '=', 'equipo_ediciones.idEquipo')
                ->join('categorias', 'equipo_ediciones.idCategoria', '=', 'categorias.id')
                ->join('equipos', 'equipo_ediciones.idEquipo', '=', 'equipos.id')
                ->where('planilla_jugadores.dni_jugador', $request->dni_jugador)
                ->where('categorias.idEdicion', $idEdicion)
                ->where('equipos.nombre', '!=', function ($query) use ($request) {
                    $query->select('equipos.nombre')
                        ->from('equipos')
                        ->join('equipo_ediciones', 'equipos.id', '=', 'equipo_ediciones.idEquipo')
                        ->where('equipo_ediciones.idEquipo', $request->equipo_id)
                        ->limit(1);
                }) // Comparar nombres de equipos
                ->select('categorias.nombreCategoria', 'equipos.nombre as nombreEquipo')
                ->get();


            // Extraer el año de la categoría del equipo actual
            $categoriaEquipoActual = Categoria::find($request->idCategoria);

            $anioEquipoActual = (int) filter_var($categoriaEquipoActual->nombreCategoria, FILTER_SANITIZE_NUMBER_INT);

            // Verificar si el jugador pertenece a una categoría más chica en otro equipo
            foreach ($categoriasJugador as $categoriaJugador) {
                $anioCategoriaJugador = (int) filter_var($categoriaJugador->nombreCategoria, FILTER_SANITIZE_NUMBER_INT);

                if ($anioCategoriaJugador > $anioEquipoActual) {
                    $mensaje = 'El jugador ya pertenece al equipo "' . $categoriaJugador->nombreEquipo . '" en la"' . $categoriaJugador->nombreCategoria . '". No puede jugar en una categoría más grande para un equipo diferente.';
                    return redirect()->back()->with('status', $mensaje);
                }
            }
        } else {
            // Crear un nuevo jugador si no existe
            $jugador = Jugador::create([
                'dni' => $request->dni_jugador,
                'nombre' => $request->nombre_jugador,
                'apellido' => $request->apellido_jugador,
                'fecha_nacimiento' => $fecha_nacimiento,
            ]);
        }

        // Obtener el equipo al que se va a agregar el jugador
        $equipo = EquipoEdicion::where('idEquipo', $request->equipo_id)
            ->where('idEdicion', $idEdicion)
            ->first();

        if (!$equipo) {
            return redirect()->back()->with('status', 'Equipo no encontrado.');
        }

        // Obtener la categoría del equipo
        $categoriaEquipo = Categoria::find($equipo->idCategoria);

        if (!$categoriaEquipo) {
            return redirect()->back()->with('status', 'Categoría del equipo no encontrada.');
        }

        // Calcular la edad del jugador basándote solo en el año actual
        $edadJugador = now()->year - \Carbon\Carbon::parse($fecha_nacimiento)->year;


        // Definir la edad máxima permitida para la categoría del equipo
        $edadMaximaCategoria = $this->obtenerEdadMaximaPorCategoria(strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú'], ['a', 'e', 'i', 'o', 'u'], $categoriaEquipo->nombreCategoria)));


        // Regla especial para Femenino Sub 13
        if ($categoriaEquipo->nombreCategoria === 'Femenino Sub 13' && $edadJugador === 14) {
            $jugadoras14 = PlanillaJugador::where('idEquipo', $equipo->idEquipo)
                ->where('idCategoria', $equipo->idCategoria)
                ->where('idEdicion', $idEdicion)
                ->whereYear('fecha_nacimiento', 2011)
                ->count();

            if ($jugadoras14 >= 2) {
                return redirect()->back()->with('status', 'Ya hay dos chicas nacidas en 2011 (14 años) en esta categoría. No se puede agregar otra.');
            }
        } elseif ($edadJugador > $edadMaximaCategoria) {
            return redirect()->back()->with('status', 'El jugador es demasiado mayor para esta categoría.');
        }

        // Agregar el jugador a la planilla
        PlanillaJugador::create([
            'partido_id' => $partidoId,
            'partido_type' => $tipoPartido === 'instancia_final' ? InstanciaFinal::class : Partido::class,
            'dni_jugador' => $jugador->dni,
            'idEquipo' => $equipo->idEquipo,
            'idEdicion' => $idEdicion,
            'numero_camiseta' => $request->numero_camiseta,
            'fecha_nacimiento' => $fecha_nacimiento,
            'idCategoria' => $equipo->idCategoria,
            'goles' => 0,
            'asistio' => false,
        ]);

        return redirect()->route('planilla.show', [
            'partidoId' => $partidoId,
            'idEdicion' => $idEdicion,
            'tipoPartido' => $tipoPartido,
            'horario' => $horarioSeleccionado,
        ])->with('status', 'Jugador agregado a la planilla con éxito.');
    }

    /**
     * Obtener la edad máxima permitida para una categoría específica.
     */
    private function obtenerEdadMaximaPorCategoria($nombreCategoria)
    {
        // Define las edades máximas para cada categoría
        $edadesMaximas = [
            'categoria 2018' => 7,
            'categoria 2017' => 8,
            'categoria 2016' => 9,
            'categoria 2015' => 10,
            'categoria 2014' => 11,
            'categoria 2013' => 12,
            'femenino sub 13' => 13,
        ];

        return $edadesMaximas[$nombreCategoria] ?? 0; // Retorna 0 si la categoría no está definida
    }
    public function actualizarJugadores(Request $request)
    {
        $tipoPartido = $request->tipoPartido;
        $horarioSeleccionado = $request->horario;
        $idEdicion = $request->idEdicion;

        // Recorrer todos los jugadores enviados en el formulario
        foreach ($request->jugadores as $dni => $datos) {
            // Buscar la planilla del jugador
            $planilla = PlanillaJugador::where('partido_id', $request->partido_id)
                ->where('dni_jugador', $dni)
                ->first();

            if (!$planilla) {
                continue; // Si no se encuentra la planilla, pasar al siguiente jugador
            }

            // Guardar los valores actuales antes de actualizar
            $golesAnteriores = $planilla->goles;
            $asistioAnteriormente = $planilla->asistio;

            // Actualizar los datos de la planilla
            $planilla->goles = $datos['goles'] ?? $planilla->goles;
            $planilla->asistio = isset($datos['asistencia']);
            $planilla->numero_camiseta = $datos['numero_camiseta'] ?? $planilla->numero_camiseta;
            $planilla->save();

            // Actualizar los datos del jugador en la tabla jugadores
            $jugador = Jugador::where('dni', $dni)->first();
            if ($jugador) {
                // Ajustar los goles totales del jugador
                $jugador->goles_totales += ($planilla->goles - $golesAnteriores);

                // Ajustar los partidos totales del jugador
                if ($planilla->goles > 0 || $planilla->asistio) {
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

            // Actualizar los datos en la tabla de goleadores
            $goleador = TablaGoleador::where('dni_jugador', $dni)
                ->where('idEdicion', $idEdicion)
                ->first();
            if ($goleador) {
                // Ajustar los goles totales del goleador
                $goleador->cantidadGoles += ($planilla->goles - $golesAnteriores);
                $goleador->save();
            } else {
                // Crear un nuevo registro en la tabla de goleadores si no existe y si tiene 1 gol o más
                if ($planilla->goles > 0) {
                    TablaGoleador::create([
                        'dni_jugador' => $dni,
                        'cantidadGoles' => $planilla->goles,
                        'idEquipo' => $planilla->idEquipo,
                        'idEdicion' => $idEdicion,
                        'idCategoria' => $planilla->idCategoria,
                        'nombre' => $jugador->apellido . ' ' . $jugador->nombre,
                    ]);
                }
            }
        }

        // Redirigir de vuelta a la vista con un mensaje de éxito
        return redirect()->route('planilla.show', [
            'partidoId' => $request->partido_id,
            'idEdicion' => $idEdicion,
            'tipoPartido' => $tipoPartido,
            'horario' => $horarioSeleccionado,
        ])->with('status', 'Jugadores actualizados correctamente.');
    }
}
