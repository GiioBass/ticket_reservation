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
            'purchase_reference' => 'required|integer|unique:movements,purchase_reference',
            'quantity' => 'required|integer',
            'description' => 'string',
            'ticket_id' => 'required|exists:tickets,id',
            'customer_id' => 'required|exists:customers,id',
            'status_id' => 'required|exists:statuses,id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'purchase_reference.required' => 'La referencia de compra es requerida',
            'purchase_reference.unique' => 'La referencia de compra se encuentra registrada',
            'purchase_reference.integer' => 'La referencia de compra debe ser de tipo númerico',
            'quantity.required' => 'La cantidad es requerida',
            'quantity.integer' => 'La cantidad debe ser númerica',
            'description.string' => 'La description debe ser de tipo texto',
            'ticket_id.required' => 'El ticket es requerido',
            'ticket_id.exists' => 'El ticket no existe en nuestros registros',
            'customer_id.required' => 'El adquiriente es requerido',
            'customer_id.exists' => 'El adquiriente no se encuentra en nuestro registros',
            'status_id.required' => 'El estado de movimiento es requerido',
            'status_id.exists' => 'El estado de movimiento no se encuentra en nuestro registros'
        ];
    }
}
