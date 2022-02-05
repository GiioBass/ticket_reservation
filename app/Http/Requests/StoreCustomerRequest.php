<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'identification_number' => 'required|string|unique:customers,identification_number',
            'name' => 'required|string',
            'email' => 'required|email:rfc|unique:customers,email',
            'phone' => 'required|string',
            'address' => 'required|string'
        ];
    }

    public function messages(){
        return [
            'identification_number.required' => 'El número de indentificación es requerido',
            'identification_number.unique' => 'El número de indentificación se encuentra registrado',
            'identification_number.string' => 'El número de indentificación debe ser de tipo texto',
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser de tipo texto',
            'email.required' => 'El correo es requerido',
            'email.email' => 'El correo no es un correo valido',
            'email.unique' => 'El correo se encuentra registrado',
            'phone.required' => 'El teléfono es requerido',
            'phone.string' => 'El teléfono debe ser de tipo texto',
            'address.required' => 'La dirección es requerida',
            'address.string' => 'La dirección debe ser de tipo texto',
        ];
    }
}
