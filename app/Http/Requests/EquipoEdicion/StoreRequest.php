<?php

namespace App\Http\Requests\EquipoEdicion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Equipo;
use App\Models\EquipoEdicion;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'idEquipo' => ['required','integer','exists:equipos,id'],
            'idEdicion' => ['required','integer','exists:ediciones,id'], // destino
            'edicionfiltro' => ['nullable','integer','exists:ediciones,id'], // origen
            'idCategoria' => ['nullable','integer','exists:categorias,id'],
            'golesContra' => ['nullable','integer'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($v){
            $idEquipo = $this->input('idEquipo');
            $idEdicionDestino = $this->input('idEdicion');
            if(!$idEquipo || !$idEdicionDestino) return;
            $equipo = Equipo::find($idEquipo);
            if(!$equipo){
                $v->errors()->add('idEquipo','Equipo no encontrado.');
                return;
            }
            // Evitar duplicado en pivot destino
            $existe = EquipoEdicion::where('idEdicion',$idEdicionDestino)->where('idEquipo',$idEquipo)->exists();
            if($existe){
                $v->errors()->add('idEquipo','Este equipo ya está asociado a la edición destino.');
            }
            // Si se envía idCategoria validar correspondencia
            if($this->filled('idCategoria') && (int)$equipo->idCategoria !== (int)$this->input('idCategoria')){
                $v->errors()->add('idCategoria','El equipo no pertenece a la categoría seleccionada.');
            }
            if($this->filled('edicionfiltro') && (int)$equipo->idEdicion !== (int)$this->input('edicionfiltro')){
                $v->errors()->add('edicionfiltro','El equipo no pertenece a la edición origen indicada.');
            }
        });
    }
}
