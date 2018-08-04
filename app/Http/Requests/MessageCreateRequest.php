<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageCreateRequest extends FormRequest
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
            'recipient_id' => 'required|exists:users,id|not_in:' . auth()->id(),
            'exists:staff,account_id,1',
            'body' => 'required|max:400',
        ];
    }

    public function messages()
    {
        return [
            'recipient_id.required' => 'El :attribute es obligatorio.',
            'recipient_id.different' => 'El :attribute introducido no es válido.',
            'body.required' => 'El :attribute es obligatorio',
            'body.max' => 'El :attribute debe ser menor a 400 carácteres'
        ];
    }

    public function attributes()
    {
        return [
            'recipient_id' => 'destinatario',
            'body' => 'texto del mensaje',
        ];
    }
}
