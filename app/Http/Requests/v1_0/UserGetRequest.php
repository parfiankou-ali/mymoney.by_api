<?php

namespace App\Http\Requests\v1_0;

use Anik\Form\FormRequest;

class UserGetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
        ];
    }
}
