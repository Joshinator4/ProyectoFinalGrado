<?php
//! Las solicitudes de formulario son clases de solicitud personalizadas que encapsulan su propia lógica de validación y autorización. Para crear una clase de solicitud de formulario, puede utilizar el make:request
//!El metodo authorize es responsable de determinar si el usuario actualmente autenticado puede realizar la acción representada por la solicitud, mientras que el método rules devuelve las reglas de validación que deben aplicarse a los datos de la solicitud:
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //SIEMPRE DEBE DEVOLVER TRUE. Se puede añadir algun condicional para devolver true o false
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //!AQUI SE AÑADEN LAS REGLAS
        return [
            'title'=> ['required', 'max: 255'],
            'description' => ['required','max:1000'],
            'price'=> ['required','min:1'],
            'stock'=> ['required','min:0'],
            'status'=>['required', 'in:available, unavailable'],
            'images.*'=>['nullable', 'image']//images.* indica que cualquier archivo que venga en el array de images, sean imagenes

        ];
    }

    //! este metodo es para validar, en este caso, si el stock esta en 0 que
    public function withValidator($validator){
        $validator->after(function ($validator) {
            if($this->status == 'available' && $this->stock == 0){ //!Se usa this porque ya estamos en la request
                $validator->errors()->add('stock','If the product is available must have stock');
            }
        });
    }
}
