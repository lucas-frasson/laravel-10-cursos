<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:1',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            // 'tipo' => [
            //     'required'
            // ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

     public function messages(): array
     {
         return [
             'name.required' => 'Nome é obrigatório',
             'name.min' => 'Nome deve ter pelo menos 1 caractere',
             'name.max' => 'Nome deve ter no máximo 255 caractere',
             'email.required' => 'Email é obrigatório',
             'email.email' => 'Email não é válido',
             'email.max' => 'Email deve ter no máximo 255 carácteres',
             // 'tipo.required' => 'Tipo é obrigatório'
         ];
     }
}
