<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetUsernameRequest extends FormRequest
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
        if ($this->method() == 'GET') return [];
        return [
            'username' => [
                'required',
                'alpha_dash',
                'between:3,64',
                'non_numeric',
                Rule::unique('users')->ignore($this->session()->get('user_id'))
            ]
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不可为空！',
            'username.between' => '用户名长度必须为3-64个字符！',
            'username.alpha_dash' => '用户名只能为字母、数字、减号和下划线！',
            'non_numeric' => '用户名不可由纯数字组成',
            'username.unique' => '该用户名已被注册！'
        ];
    }
}
