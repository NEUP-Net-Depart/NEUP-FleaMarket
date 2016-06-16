<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\GoodCat;
use App\GoodInfo;
use App\Http\Controllers\Controller;

class GoodController extends Controller
{
    public function getList(Request $request)
    {
      /**
       * @function GoodController@getList
       * @input Request $request
       * @return Response
       * @description Get the list of all goods.
       */
        $data = [];
        $data['cats'] = GoodCat::orderby('cat_name', 'asc')->get();
        $data['goods'] = GoodInfo::orderby('id', 'asc')->get();
		if($request->session()->has('user_id')) 
		    $data['user_id'] = $request->session()->get('user_id');
		else 
		    $data['user_id'] = NULL;
		if($request->session()->has('is_admin'))
	        $data['is_admin'] = $request->session()->get('is_admin');
		else 
		    $data['is_admin'] = NULL;
        return view::make('good.goodList')->with($data);
    }

    public function getInfo(Request $request, $good_id)
    {
      /**
       * @function GoodController@getInfo
       * @input Request $request, $good_id
       * @return Response
       * @description Get the information of a specify goods.
       */
        $data = [];
        $data['goods'] = GoodInfo::where('id', $good_id)->get();
		if($request->session()->has('user_id')) 
		    $data['user_id'] = $request->session()->get('user_id');
		else 
		    $data['user_id'] = NULL;
		if($request->session()->has('is_admin'))
		    $data['is_admin'] = $request->session()->get('is_admin');
		else 
		    $data['is_admin'] = NULL;
        return view::make('good.goodInfo')->with($data);
    }

    public function addGood(Request $request)
    {
      /**
       * @function GoodController@addGood
       * @input Request $request
       * @return Response
       * @description Add a new good.
       */
        if($request->method()=="GET"){
            $data = [];
			if(!$request->session()->has('user_id')) 
			    return Redirect::back();
            $data['cats'] = GoodCat::orderby('cat_name', 'asc')->get();
            return view::make('good.addPage')->with($data);
        }else{
			if(!$request->session()->has('user_id')) 
		        return Redirect::back();
            $this->validate($request, [
                'good_name' => 'required',
                'description' => 'required',
                'pricemin' => 'required',
                'pricemax' => 'required',
                'counts' => 'required',
            ]);
            $input = $request->all();
            $good = new GoodInfo;
            $good->good_name=$input['good_name'];
            $good->cat_id=$input['cat_id'];
            $good->description=$input['description'];
            $good->pricemin=$input['pricemin'];
            $good->pricemax=$input['pricemax'];
            $good->type=$input['type'];
            $good->counts=$input['counts'];
            $good->good_tag=$input['good_tag'];
            $good->save();
            return redirect('/good/add');
        }
    }

    public function editGood(Request $request, $good_id)
    {
      /**
       * @function GoodController@editGood
       * @input Request $request, $good_id
       * @return Response
       * @description Edit a specify good.
       */
        if($request->method()=="GET"){
            $data = [];
            $data['cats'] = GoodCat::orderby('cat_name', 'asc')->get();
            $data['goods'] = GoodInfo::where('id', $good_id)->get();
            return view::make('good.editPage')->with($data);
        }else{
			if(!$request->session()->has('user_id')) 
			    return Redirect::back();
            $this->validate($request, [
                'good_name' => 'required',
                'cat_id' => 'required',
                'description' => 'required',
                'pricemin' => 'required',
                'pricemax' => 'required',
                'type' => 'required',
                'counts' => 'required',
            ]);
            $input = $request->all();
            $good = GoodInfo::find($good_id);
			if($request->session()->get('user_id')!=$good->user_id && !$request->session()->has('is_admin')) 
		        return Redirect::back();
            $good->good_name=$input['good_name'];
            $good->cat_id=$input['cat_id'];
            $good->description=$input['description'];
            $good->pricemin=$input['pricemin'];
            $good->pricemax=$input['pricemax'];
            $good->type=$input['type'];
            $good->counts=$input['counts'];
            $good->good_tag=$input['good_tag'];
            $good->update();
            return Redirect::to('/good/'.$good_id.'/edit');
        }
    }

    public function deleteGood(Request $request, $good_id)
    {
      /**
       * @function GoodController@deleteGood
       * @input Request $request, $good_id
       * @return Response
       * @description Delete a specify good.
       */
		if(!$request->session()->has('user_id')) 
		    return Redirect::back();
        $good = GoodInfo::find($good_id);
		if($request->session()->get('user_id')!=$good->user_id && !$request->session()->has('is_admin')) 
		    return Redirect::back();
        $good->delete();
        return redirect('/good');
    }
}
