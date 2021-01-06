<?php

namespace App\Http\Requests\v1_0;

use Anik\Form\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'between:4,64'],
        ];
    }
}
