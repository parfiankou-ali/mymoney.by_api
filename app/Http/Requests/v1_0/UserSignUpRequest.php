<?php

namespace App\Http\Requests\v1_0;

use Anik\Form\FormRequest;

use App\Http\Enums\Gender;
use App\Http\Enums\ImageSize;

use Illuminate\Validation\Rule;

class UserSignUpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'between:2,32'],
            'last_name' => ['required', 'string', 'between:2,32'],
            'middle_name' => ['string', 'between:2,32'],
            'gender' => [
                'required',
                Rule::in(Gender::values()),
            ],
            'birth_date' => ['required', 'date', 'before:-2 years'],
            'phone_number' => ['required', 'string', 'phone_number'],
            'image' => [
                'required',
                'file',
                'mimes:jpeg,png,jpg,gif',
                Rule::dimensions()
                    ->maxWidth(ImageSize::MAX_8192)
                    ->maxHeight(ImageSize::MAX_8192)
                    ->minWidth(ImageSize::min())
                    ->minHeight(ImageSize::min()),
                'max:4096', // 4mb
            ],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'string', 'min:6'],
            'password_confirmation' => ['required'],
        ];
    }
}
