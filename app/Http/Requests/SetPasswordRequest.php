<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetPasswordRequest extends FormRequest
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
            'newPassword' => 'required|confirmed|between:6,128',
        ];
    }

    public function messages()
    {
        return [
            'newPassword.required' => '密码不能为空！',
            'newPassword.confirmed' => '两次输入的密码不一致！',
            'newPassword.between' => '密码长度必须为6-128个字符',
        ];
    }
}
