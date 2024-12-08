<?php

namespace App\Services;

use App\Models\Equipo;
use App\Models\EquipoEdicion;
use App\Models\InstanciaFinal;
use App\Models\Partido;
use App\Models\TablaPosicion;

class PartidoService
{
    public function actualizarResultado(Partido $partido, $golesEquipoLocal, $golesEquipoVisitante)
    {
        $partido->update([
            'golesEquipoLocal' => $golesEquipoLocal,
            'golesEquipoVisitante' => $golesEquipoVisitante,
            'jugado' => 1,
        ]);

        $this->actualizarTablaPosiciones($partido, $golesEquipoLocal, $golesEquipoVisitante);
        $this->actualizarHistorialEquipos($partido, $golesEquipoLocal, $golesEquipoVisitante);
    }

    protected function actualizarTablaPosiciones(Partido $partido, $golesEquipoLocal, $golesEquipoVisitante)
    {
        // Lógica para actualizar la tabla de posiciones
        $equipoLocal = $partido->equipoLocal;
        $equipoVisitante = $partido->equipoVisitante;

        // Verificar si la combinación ya existe para el equipo local
        $tablaLocal = TablaPosicion::where([
            ['idGrupo', '=', $partido->idGrupo],
            ['idEquipo', '=', $equipoLocal->id],
        ])->first();

        if (!$tablaLocal) {
            // Si no existe, se crea un nuevo registro
            $tablaLocal = TablaPosicion::create([
                'idGrupo' => $partido->idGrupo,
                'idEquipo' => $equipoLocal->id,
                'idEdicion' => $partido->idEdicion,
                'golesFavor' => 0,
                'golesContra' => 0,
                'diferenciaGoles' => 0,
                'jugado' => 0,
                'ganado' => 0,
                'empatado' => 0,
                'perdido' => 0,
                'puntos' => 0,
            ]);
        }

        // Verificar si la combinación ya existe para el equipo visitante
        $tablaVisitante = TablaPosicion::where([
            ['idGrupo', '=', $partido->idGrupo],
            ['idEquipo', '=', $equipoVisitante->id],
        ])->first();

        if (!$tablaVisitante) {
            // Si no existe, se crea un nuevo registro
            $tablaVisitante = TablaPosicion::create([
                'idGrupo' => $partido->idGrupo,
                'idEquipo' => $equipoVisitante->id,
                'idEdicion' => $partido->idEdicion,
                'golesFavor' => 0,
                'golesContra' => 0,
                'diferenciaGoles' => 0,
                'jugado' => 0,
                'ganado' => 0,
                'empatado' => 0,
                'perdido' => 0,
                'puntos' => 0,
            ]);
        }

        // Actualizar estadísticas de cada equipo
        $this->actualizarEstadisticasEquipo($tablaLocal, $golesEquipoLocal, $golesEquipoVisitante);
        $this->actualizarEstadisticasEquipo($tablaVisitante, $golesEquipoVisitante, $golesEquipoLocal);
    }


    protected function actualizarEstadisticasEquipo($tablaPosicion, $golesAFavor, $golesEnContra)
    {
        $tablaPosicion->golesFavor += $golesAFavor;
        $tablaPosicion->golesContra += $golesEnContra;
        $tablaPosicion->diferenciaGoles = $tablaPosicion->golesFavor - $tablaPosicion->golesContra;
        $tablaPosicion->jugado += 1;

        if ($golesAFavor > $golesEnContra) {
            $tablaPosicion->ganado += 1;
            $tablaPosicion->puntos += 3;
        } elseif ($golesAFavor == $golesEnContra) {
            $tablaPosicion->empatado += 1;
            $tablaPosicion->puntos += 1;
        } else {
            $tablaPosicion->perdido += 1;
        }

        $tablaPosicion->save();
    }

    public function actualizarHistorialEquipos(Partido $partido, $golesEquipoLocal, $golesEquipoVisitante)
    {
        $equipoLocal = $partido->equipoLocal;
        $equipoVisitante = $partido->equipoVisitante;

        // Incrementar partidos jugados
        $equipoLocal->increment('partidos_jugados');
        $equipoVisitante->increment('partidos_jugados');

        // Actualizar victorias, derrotas y empates
        if ($golesEquipoLocal > $golesEquipoVisitante) {
            $equipoLocal->increment('victorias');
            $equipoLocal->increment('puntos', 3); // 3 puntos por victoria
            $equipoVisitante->increment('derrotas');
        } elseif ($golesEquipoLocal < $golesEquipoVisitante) {
            $equipoLocal->increment('derrotas');
            $equipoVisitante->increment('victorias');
            $equipoVisitante->increment('puntos', 3); // 3 puntos por victoria
        } else {
            $equipoLocal->increment('empates');
            $equipoLocal->increment('puntos', 1); // 1 punto por empate
            $equipoVisitante->increment('empates');
            $equipoVisitante->increment('puntos', 1); // 1 punto por empate
        }

        // Actualizar goles a favor y en contra
        $equipoLocal->increment('golesFavor', $golesEquipoLocal);
        $equipoLocal->increment('golesContra', $golesEquipoVisitante);
        $equipoVisitante->increment('golesFavor', $golesEquipoVisitante);
        $equipoVisitante->increment('golesContra', $golesEquipoLocal);

        // Actualizar diferencia de goles
        $equipoLocal->diferenciaGoles = $equipoLocal->golesFavor - $equipoLocal->golesContra;
        $equipoVisitante->diferenciaGoles = $equipoVisitante->golesFavor - $equipoVisitante->golesContra;

        // Guardar cambios
        $equipoLocal->save();
        $equipoVisitante->save();
    }

    public function actualizarHistorialInstanciasFinales(InstanciaFinal $partido, $golesEquipoLocal, $golesEquipoVisitante)
    {
        // Obtener los equipos involucrados en el partido
        $equipoLocal = $partido->equipoLocal;
        $equipoVisitante = $partido->equipoVisitante;

        // Incrementar partidos jugados en la tabla histórica de instancias finales
        $equipoLocal->increment('partidos_jugados');
        $equipoVisitante->increment('partidos_jugados');

        // Actualizar victorias, derrotas y empates según el resultado
        if ($golesEquipoLocal > $golesEquipoVisitante) {
            // Si el equipo local gana
            $equipoLocal->increment('victorias');
            $equipoVisitante->increment('derrotas');
        } elseif ($golesEquipoLocal < $golesEquipoVisitante) {
            // Si el equipo visitante gana
            $equipoVisitante->increment('victorias');
            $equipoLocal->increment('derrotas');
        } else {
            // Si hay empate
            $equipoLocal->increment('empates');
            $equipoVisitante->increment('empates');
        }

        // Actualizar goles a favor y en contra en el historial de instancias finales
        $equipoLocal->increment('golesFavor', $golesEquipoLocal);
        $equipoLocal->increment('golesContra', $golesEquipoVisitante);
        $equipoVisitante->increment('golesFavor', $golesEquipoVisitante);
        $equipoVisitante->increment('golesContra', $golesEquipoLocal);

        // Actualizar diferencia de goles en el historial de instancias finales
        $equipoLocal->diferenciaGoles = $equipoLocal->golesFavor - $equipoLocal->golesContra;
        $equipoVisitante->diferenciaGoles = $equipoVisitante->golesFavor - $equipoVisitante->golesContra;

        // Guardar cambios
        $equipoLocal->save();
        $equipoVisitante->save();
    }

    public function actualizarGolesContraEquipoEdicion($equipoId, $idEdicion, $idGrupo)
    {
        // Obtener la instancia de equipo_edicion correspondiente
        $equipoEdicion = EquipoEdicion::where('idEquipo', $equipoId)
            ->where('idEdicion', $idEdicion)
            ->first();
    
        if (!$equipoEdicion) {
            // Manejar el caso en que no se encuentre el equipo_edicion
            throw new \Exception("EquipoEdicion no encontrado para el equipo $equipoId en la edición $idEdicion");
        }
    
        // Obtener goles en contra de la tabla de posiciones
        $golesContraFaseGrupos = TablaPosicion::where([
            ['idGrupo', '=', $idGrupo],
            ['idEquipo', '=', $equipoId],
            ['idEdicion', '=', $idEdicion]
        ])->sum('golesContra');
    
        // Obtener goles en contra de las instancias finales
        $partidosInstanciasFinales = InstanciaFinal::where('idEdicion', $idEdicion)
            ->where(function ($query) use ($equipoId) {
                $query->where('idEquipoLocal', $equipoId)
                      ->orWhere('idEquipoVisitante', $equipoId);
            })
            ->get();
    
        $golesContraInstanciasFinales = 0;
        if ($partidosInstanciasFinales->isNotEmpty()) {
            $golesContraInstanciasFinales = $partidosInstanciasFinales->sum(function ($partido) use ($equipoId) {
                return $partido->idEquipoLocal == $equipoId ? $partido->golesEquipoVisitante : $partido->golesEquipoLocal;
            });
        }
    
        // Sumar ambos valores y actualizar en equipo_ediciones
        $equipoEdicion->golesContra = $golesContraFaseGrupos + $golesContraInstanciasFinales;
        $equipoEdicion->save();
    }
    
}
