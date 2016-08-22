<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
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
        if($this->method()=='GET') return [];
        return [
            'username'=>'required|alpha_dash|between:3,64|unique:users,username',
            'email'=>'required|email|unique:users,email|max:64',
            'password'=>'required|confirmed|between:6,128',
            'nickname'=>'max:128',
        ];
    }

    public function messages(){
        return [
            'username.required' => '用户名不能为空！',
            'username.alpha_dash' => '用户名只能为字母、数字、减号和下划线！',
            'username.between' => '用户名长度必须为3-64个字符！',
            'username.unique' => '该用户名已被注册！',
            'email.required' => '邮箱不能为空！',
            'email.email' => '邮箱格式不正确！',
            'email.unique' => '已有用户使用该邮箱注册！',
            'email.max' => '邮箱长度不能超过64个字符！',
            'password.required' => '密码不能为空！',
            'password.confirmed' => '两次输入的密码不一致！',
            'password.between' => '密码长度必须为6-128个字符',
            'nickname.max' => '昵称长度不能超过128个字符！'
        ];
    }
}
