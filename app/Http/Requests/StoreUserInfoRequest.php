<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUserInfoRequest extends Request
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
            'tel_num'=>'required',
        ];
    }

    public function messages(){
        return [
            'tel_num.required' => '手机号不可为空！',
        ];
    }
}
