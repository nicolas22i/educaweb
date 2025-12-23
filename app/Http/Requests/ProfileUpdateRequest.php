<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'max:255',
            'email:rfc,dns',
            Rule::unique(User::class)->ignore($this->user()->id),
        ],
    ];
}



    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.regex' => 'El email no tiene un formato válido.',
            'email.unique' => 'Este email ya está en uso.',
            'name.required' => 'El nombre es obligatorio.',
        ];
    }
}
