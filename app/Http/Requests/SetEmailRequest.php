<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetEmailRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:64',
                Rule::unique('users')->ignore($this->session()->get('user_id')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '邮箱不能为空！',
            'email.max' => '邮箱长度不能超过64个字符！',
            'email.email' => '邮箱格式不正确！',
            'email.unique' => '已有用户使用该邮箱注册！',
        ];
    }
}
