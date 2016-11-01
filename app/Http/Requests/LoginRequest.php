<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'username'=>'required|alpha_dash|between:3,64',
            'password'=>'required|between:6,128',
        ];
    }

    public function messages(){
        return [
            'username.required' => '用户名不能为空！',
            'username.between' => '用户名长度必须为3-64个字符！',
            'username.alpha_dash' => '用户名只能为字母、数字、减号和下划线！',
            'password.required' => '密码不能为空！',
            'password.between' => '密码长度必须为6-128个字符',
        ];
    }
}
