<?php
namespace App\Http\Requests\Jugador;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Si tienes alguna lógica de autorización, puedes agregarla aquí
        // Por ejemplo, puedes verificar si el usuario está autenticado o tiene permisos
        return true;  // Asegúrate de cambiar esto si necesitas restricciones
    }

    /**
     * Obtiene las reglas de validación para la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'dni' => 'required|digits:8|unique:jugadores,dni',  // Asegura que el DNI sea único
            'numeroCamiseta' => 'required|integer|min:1|max:99', // Número de camiseta entre 1 y 99
            'idEquipo' => 'required|exists:equipos,id',  // Validar que el equipo exista en la base de datos
            'idCategoria' => 'required|exists:categorias,id',  // Validar que la categoría exista en la base de datos
            'idEdicion' => 'required|exists:ediciones,id',  // Validar que la edición exista en la base de datos
        ];
    }

    /**
     * Mensajes personalizados de validación.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del jugador es obligatorio.',
            'dni.required' => 'El DNI del jugador es obligatorio.',
            'dni.digits' => 'El DNI debe tener 8 dígitos.',
            'dni.unique' => 'El DNI ya está registrado en la base de datos.',
            'numeroCamiseta.required' => 'El número de camiseta es obligatorio.',
            'numeroCamiseta.integer' => 'El número de camiseta debe ser un número entero.',
            'numeroCamiseta.min' => 'El número de camiseta debe ser al menos 1.',
            'numeroCamiseta.max' => 'El número de camiseta no puede ser mayor a 99.',
            'idEquipo.required' => 'El equipo es obligatorio.',
            'idEquipo.exists' => 'El equipo seleccionado no existe.',
            'idCategoria.required' => 'La categoría es obligatoria.',
            'idCategoria.exists' => 'La categoría seleccionada no existe.',
            'idEdicion.required' => 'La edición es obligatoria.',
            'idEdicion.exists' => 'La edición seleccionada no existe.',
        ];
    }
}
