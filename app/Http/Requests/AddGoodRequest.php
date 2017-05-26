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
        return [
			'good_name'=>'required|max:128',
			'description'=>'max:2048',
			'price'=>'numeric|required|max:9223372036854775807',
			'count'=>'integer|required|max:2147483647',
            //'good_tag'=>'required',
            //'other_tag'=>'max:128',
			'goodTitlePic'=>'required',
            'crop_width'=>'required',
            'crop_height'=>'required',
            'crop_x'=>'required',
            'crop_y'=>'required',
        ];
    }

    public function messages(){
        return [
			'good_name.required' => '商品名不能为空！',
			'good_name.max' => '商品名不能多于128个字符！',
			'description.max' => '商品描述不能多于2048个字符！',
			'price.required' => '商品价格不能为空！',
            'price.numeric' => '商品价格必须为数值！',
			'price.max' => '商品价格不能超过9223372036854775807！',
			'count.required' => '库存数不能为空！',
            'count.integer' => '库存数必须是整数！',
			'count.max' => '库存数不能超过2147483647！',
            //'good_tag.required' => '商品标签不能为空！',
            //'other_tag.max' => '自定义标签不能多于2048个字符！',
			'goodTitlePic.required' => '必须为商品上传一张图片！',
            'crop_width.required' => '请按要求裁剪图片',
            'crop_height.required' => '请按要求裁剪图片',
            'crop_x.required' => '请按要求裁剪图片',
            'crop_y.required' => '请按要求裁剪图片',
        ];
    }
}
