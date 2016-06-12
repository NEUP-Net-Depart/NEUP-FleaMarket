<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\GoodCat;
use App\GoodInfo;
use App\Http\Controllers\Controller;

class GoodController extends Controller
{
    public function getList(Request $request)
    {
        $cats = GoodCat::orderby('cat_name', 'asc')->get();
        $goods = GoodInfo::orderby('id', 'asc')->get();
        if($request->session()->has('userid')) $userid = $request->session()->get('userid'); else $userid = NULL;
        return view('good.goodList', [
            'cats' => $cats,
            'goods' => $goods,
            'userid' => $userid,
        ]);
    }
    public function getInfo(Request $request, $good_id)
    {
        $goods = GoodInfo::where('id', $good_id)->get();
        if($request->session()->has('userid')) $userid = $request->session()->get('userid'); else $userid = NULL;
        return view('good.goodInfo', [
            'goods' => $goods,
            'userid' => $userid,
        ]);
    }
    public function addPage(Request $request)
    {
        if(!$request->session()->has('userid')) return redirect()->back();
        $cats = GoodCat::orderby('cat_name', 'asc')->get();
        return view('good.addPage', [
            'cats' => $cats,
        ]);
    }
    public function addGood(Request $request)
    {
        if(!$request->session()->has('userid')) return redirect()->back();
        $validator = Validator::make($request->all(), [
            'good_name' => 'required',
            'description' => 'required',
            'pricemin' => 'required',
            'pricemax' => 'required',
            'counts' => 'required',
        ]);
        if($validator->fails()) return redirect('/good/addPage')->withInput()->withErrors($validator);
        $good = new GoodInfo;
        $good->good_name=$request->good_name;
        $good->cat_id=$request->cat_id;
        $good->description=$request->description;
        $good->pricemin=$request->pricemin;
        $good->pricemax=$request->pricemax;
        $good->type=$request->type;
        $good->counts=$request->counts;
        $good->good_tag=$request->good_tag;
        $good->user_id=$request->session()->get('userid');
        $good->save();
        return redirect('/good/addPage');
    }
    public function editPage(Request $request, $good_id)
    {
        $cats = GoodCat::orderby('cat_name', 'asc')->get();
        $goods = GoodInfo::where('id', $good_id)->get();
        return view('good.editPage', [
            'goods' => $goods,
            'cats' => $cats,
        ]);
    }
    public function editGood(Request $request, $good_id)
    {
        if(!$request->session()->has('userid')) return redirect()->back();
        $validator = Validator::make($request->all(), [
            'good_name' => 'required',
            'cat_id' => 'required',
            'description' => 'required',
            'pricemin' => 'required',
            'pricemax' => 'required',
            'type' => 'required',
            'counts' => 'required',
        ]);
        if($validator->fails()) return redirect('/good/'.$good_id.'/editPage')->withInput()->withErrors($validator);
        $good = GoodInfo::find($good_id);
        if($request->session()->get('user_id')!=$good->user_id) return redirect()->back();
        $good->good_name=$request->good_name;
        $good->cat_id=$request->cat_id;
        $good->description=$request->description;
        $good->pricemin=$request->pricemin;
        $good->pricemax=$request->pricemax;
        $good->type=$request->type;
        $good->counts=$request->counts;
        $good->good_tag=$request->good_tag;
        $good->update();
        return redirect('/good/'.$good_id.'/editPage');
    }
    public function deleteGood(Request $request, $good_id)
    {
        if(!$request->session()->has('userid')) return redirect()->back();
        $good = GoodInfo::find($good_id);
        if($request->session()->get('user_id')!=$good->user_id) return redirect()->back();
        $good->delete();
        return redirect('/good');
    }
}