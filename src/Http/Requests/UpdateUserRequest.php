<?php

namespace Future\LaraAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'second_name' => ['nullable', 'string'],
            'login' => ['nullable', 'string'],
            'phone_number' => ['nullable', 'integer'],
            'email' => ['required','email', 'unique:users,email,' . $this->user->id],
            'password' => ['nullable', 'string', 'confirmed'],
            'active' => ['nullable', 'boolean'],
            'birthday' => ['nullable', 'string', 'dateformat:Y-m-d'],
            'roles' => ['array', 'min:1'],
            'roles.*' => ['required', 'string']
        ];
    }
}
