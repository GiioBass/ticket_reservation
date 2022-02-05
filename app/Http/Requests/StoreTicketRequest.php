<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'code' => 'required|string|unique:tickets,code',
            'quantity' => 'required|integer',
            'price' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser tipo texto',
            'code.required' => 'El código es requerido',
            'code.string' => 'El código debe ser de tipo texto',
            'code.unique' => 'El código ya se encuentra registrado',
            'quantity.required' => 'La cantidad es requerida',
            'quantity.integer' => 'La cantidad debe ser de tipo númerico',
            'price.required' => 'El precio es requerido'
        ];
    }
}
