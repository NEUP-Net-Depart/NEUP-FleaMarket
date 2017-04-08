<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class addGoodRequest extends Request
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
			'good_name'=>'required|between:3,128',
			'description'=>'max:2048',
			'pricemin'=>'required|max:2147483647',
			'pricemax'=>'required|max:2147483647',
			'counts'=>'required|max:2147483647',
			'good_tag'=>'max:128',
			'goodTitlePic'=>'required',
        ];
    }

    public function messages(){
        return [
			'good_name.required' => '商品名不能为空！',
			'good_name.between' => '商品名必须为3=128个字符！',
			'description.max' => '商品描述不能多于2048个字符！',
			'pricemin.required' => '最低价格不能为空！',
			'pricemin.max' => '最低价格不能超过2147483647！',
			'pricemax.required' => '最高价格不能为空！',
			'pricemax.max' => '最高价格不能超过2147483647！',
			'counts.required' => '库存数不能为空！',
			'counts.max' => '库存数不能超过2147483647！',
			'good_tag.max'=>'TAG不能多于128个字符！',
			'goodTitlePic.required' => '必须为商品上传一张图片！',
        ];
    }
}
