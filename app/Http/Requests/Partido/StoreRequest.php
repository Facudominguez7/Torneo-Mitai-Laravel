<?php

namespace App\Http\Requests\Partido;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cambia a false si necesitas autorización específica
    }

    public function rules()
    {
        return [
            'idFechas' => 'required|exists:fechas,id',
            'idEquipoLocal' => 'required|exists:equipos,id',
            'idEquipoVisitante' => 'required|exists:equipos,id',
            'idGrupo' => 'required|exists:grupos,id',
            'idEdicion' => 'required|exists:ediciones,id',
            'golesEquipoLocal' => 'nullable|integer|min:0',
            'golesEquipoVisitante' => 'nullable|integer|min:0',
            'horario' => 'required|string',
            'cancha' => 'required|string',
            'idDia' => 'required|integer',
            'idCategoria' => 'required|integer',
            'jugado' => 'nullable|integer',
        ];
    }
}
