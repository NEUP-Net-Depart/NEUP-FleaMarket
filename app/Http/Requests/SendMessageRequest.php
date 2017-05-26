<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
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
        return [
            'title'=>'required|max:128',
            'content'=>'max:65535',
            'receiver'=>'required|integer',
        ];
    }

    public function messages() {
        return [
            'title.required' => '标题不能为空！',
            'title.max' => '标题长度不能超过128个字符！',
            'content.max' => '内容长度不能超过65535个字符',
            'receiver.required' => '收件人不可为空',
            'receiver.integer' => '收件人格式不正确！'
        ];
    }
}
