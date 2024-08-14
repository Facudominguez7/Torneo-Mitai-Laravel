<?php

namespace App\Http\Requests\Goleador;

use Illuminate\Foundation\Http\FormRequest;

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
            'idEdicion' => 'int|required',
            'idEquipo' => 'int|required',
            'idCopa' => 'int|required',
            'idCategoria' => 'int|required',
        ];
    }
}
