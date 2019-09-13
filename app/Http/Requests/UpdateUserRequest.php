<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Overriden error messages
     */
    public function messages()
    {
        return [
            'name' => ['filled', 'string', 'max:255'],
            'email' => ['filled', 'string', 'email', 'max:255', 'unique:users'],
        ];
    }

    /**
     * Ovveriden validation attribues
     */
    public function attributes()
    {
        return [];
    }
}
