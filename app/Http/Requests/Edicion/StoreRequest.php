<?php

namespace App\Http\Requests\Edicion;

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
            'nombre' => 'required|unique:ediciones,nombre|min:5|max:50',
            'equipos' => 'nullable|array',
            'equipos.*' => 'exists:equipos,id',
        ];
    }
}
