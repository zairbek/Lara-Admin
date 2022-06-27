<?php

namespace Future\LaraAdmin\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'second_name' => ['nullable', 'string'],
            'login' => ['nullable', 'string'],
            'phone_number' => ['nullable', 'integer'],
            'email' => ['required','email', 'unique:users,email'],
            'password' => ['string', 'confirmed'],
            'active' => ['nullable', 'boolean'],
            'birthday' => ['nullable', 'string', 'dateformat:Y-m-d'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'string']
        ];
    }
}
