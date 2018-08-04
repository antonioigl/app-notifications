<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageEditRequest extends FormRequest
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
            'recipients_id' => 'required|array',
            'recipients_id.*' => 'exists:messages,id',
        ];
    }

    public function messages()
    {
        return [
            'recipients_id.required' => 'No has seleccionado ninguna :attribute.',
        ];
    }

    public function attributes()
    {
        return [
            'recipients_id' => 'notificación',
        ];
    }
}
