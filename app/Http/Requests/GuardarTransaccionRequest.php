<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GuardarTransaccionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comercio_id' => 'required|exists:comercios,id',
            'cliente_nombre' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0.01',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'cliente_nombre.required' => 'Debes indicar el nombre del cliente.',
            'monto.required' => 'Debes indicar un monto.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto debe ser mayor a cero.',
        ];
    }

    /**
     * Nombres amigables de los campos.
     */
    public function attributes(): array
    {
        return [
            'cliente_nombre' => 'nombre del cliente',
            'monto' => 'monto de la transacción',
            'comercio_id' => 'comercio',
        ];
    }
}