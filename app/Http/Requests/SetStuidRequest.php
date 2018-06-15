<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetStuidRequest extends FormRequest
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
        if ($this->method() == 'GET') {
            return [];
        }

        return [
            'stuid' => [
                'required',
                'integer',
                Rule::unique('users')->ignore($this->session()->get('user_id')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'stuid.required' => '学号不可为空！',
            'stuid.integer' => '学号只能为数字！',
            'stuid.unique' => '该学号已被注册！',
        ];
    }
}
