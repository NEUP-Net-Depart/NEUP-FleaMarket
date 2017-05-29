<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditAccountRequest extends FormRequest
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
                'nullable',
                'alpha_dash',
                'between:3,64',
                Rule::unique('users')->ignore($this->session()->get('user_id'))
            ],
            'stuid' => [
                'nullable',
                'alpha_dash',
                Rule::unique('users')->ignore($this->session()->get('user_id'))
            ],
            'email' => [
                'required',
                'email',
                'max:64',
                Rule::unique('users')->ignore($this->session()->get('user_id'))
            ],
            'password' => 'required',
            'newPassword' => 'nullable|confirmed|between:6,128',
        ];
    }

    public function messages()
    {
        return [
            'username.between' => '用户名长度必须为3-64个字符！',
            'username.alpha_dash' => '用户名只能为字母、数字、减号和下划线！',
            'username.unique' => '该用户名已被注册！',
            'stuid.alpha_dash' => '学号只能为字母、数字、减号和下划线！',
            'stuid.unique' => '该学号已被注册！',
            'password.required' => '当前密码不能为空！',
            'newPassword.confirmed' => '两次输入的密码不一致！',
            'newPassword.between' => '密码长度必须为6-128个字符',
            'email.required' => '邮箱不能为空！',
            'email.max' => '邮箱长度不能超过64个字符！',
            'email.email' => '邮箱格式不正确！',
            'email.unique' => '已有用户使用该邮箱注册！'
        ];
    }
}
