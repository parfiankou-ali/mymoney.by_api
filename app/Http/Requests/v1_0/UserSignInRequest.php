<?php

namespace App\Http\Requests\v1_0;

use Anik\Form\FormRequest;

class UserSignInRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
}
