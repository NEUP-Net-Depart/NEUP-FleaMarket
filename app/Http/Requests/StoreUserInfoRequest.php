<?php

namespace App\Http\Requests;

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
        if ($this->method() == 'GET') {
            return [];
        }

        return [
            'tel_num' => 'required_without_all:QQ,wechat',
            'QQ' => 'required_without_all:tel_num,wechat',
            'wechat' => 'required_without_all:tel_num,QQ',
        ];
    }

    public function messages()
    {
        return [
            'tel_num.required_without_all' => '微信、QQ和手机号至少要填写一项！',
            'QQ.required_without_all' => '微信、QQ和手机号至少要填写一项！',
            'wechat.required_without_all' => '微信、QQ和手机号至少要填写一项！',
        ];
    }
}
