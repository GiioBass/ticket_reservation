<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer',
            'description' => 'string',
            'ticket_id' => 'required|exists:tickets,id',
            'customer_id' => 'required|exists:customers,id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'quantity.required' => 'La cantidad es requerida',
            'quantity.integer' => 'La cantidad debe ser númerica',
            'description.string' => 'La description debe ser de tipo texto',
            'ticket_id.required' => 'El ticket es requerido',
            'ticket_id.exists' => 'El ticket no existe en nuestros registros',
            'customer_id.required' => 'El adquiriente es requerido',
            'customer_id.exists' => 'El adquiriente no se encuentra en nuestro registros'
        ];
    }
}
