<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
    //*Se crea un filtrado en el request enviado al intentar modificar el perfil
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)], //se filtra que el email se unico exceptuando el mismo email que ya tiene asignado, por si envía exactamente el mismo email que ya tenia anteriormente
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],//se pone nullable porque puede ser que no envie otra contraseña para cambiar
            'image' => ['nullable', 'image'],//se pone nullable porque puede ser que no envie otra foto para cambiar
        ];
    }
}
