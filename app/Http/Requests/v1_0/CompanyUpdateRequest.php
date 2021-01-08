<?php

namespace App\Http\Requests\v1_0;

use Anik\Form\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'between:4,64'],
        ];
    }
}
