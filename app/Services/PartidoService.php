<?php

namespace App\Services;

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
    }

    protected function actualizarTablaPosiciones(Partido $partido, $golesEquipoLocal, $golesEquipoVisitante)
    {
        // Lógica para actualizar la tabla de posiciones
        $equipoLocal = $partido->equipoLocal;
        $equipoVisitante = $partido->equipoVisitante;

        // Actualizar estadísticas del equipo local
        $tablaLocal = TablaPosicion::firstOrCreate(
            [
                'idGrupo' => $partido->idGrupo,
                'idEquipo' => $equipoLocal->id,
            ],
            [
                'golesFavor' => 0,
                'golesContra' => 0,
                'diferenciaGoles' => 0,
                'jugado' => 0,
                'ganado' => 0,
                'empatado' => 0,
                'perdido' => 0,
                'puntos' => 0,
            ]
        );

        // Actualizar estadísticas del equipo visitante
        $tablaVisitante = TablaPosicion::firstOrCreate(
            [
                'idGrupo' => $partido->idGrupo,
                'idEquipo' => $equipoVisitante->id,
            ],
            [
                'golesFavor' => 0,
                'golesContra' => 0,
                'diferenciaGoles' => 0,
                'jugado' => 0,
                'ganado' => 0,
                'empatado' => 0,
                'perdido' => 0,
                'puntos' => 0,
            ]
        );

        // Actualizar lógica de puntos, goles, partidos jugados, etc.
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
}