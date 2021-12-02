<?php

namespace Future\LaraAdmin\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		return $this->user()->hasPermissionTo('roles@create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'name' => ['required', 'unique:roles,name', 'alpha', 'regex:/^[a-zA-Z]+$/u'],
            'permissions' => ['array']
        ];
    }
}
