<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\GoodInfo;

class ContentController extends Controller
{
    public function Mainpage()
    {
        $data = [];
        $data['hotgoods'] = GoodInfo::orderby('sold_month', 'asc')->limit(5)->get();
        $data['newgoods'] = GoodInfo::orderby('id', 'dsc')->limit(6)->get();
        return View::make('welcome')->with($data);
    }
}
