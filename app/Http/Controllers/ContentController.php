<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\GoodInfo;
use App\GoodCat;
use App\Announcement;

class ContentController extends Controller
{
    public function Mainpage()
    {
        $data = [];
        $data['cats'] = GoodCat::orderby('cat_index', 'asc')->get();
        $data['stargoods'] = GoodInfo::where('baned', '0')->where('stared', '1')->orderby('id', 'asc')->limit(5)->get();
        $data['newgoods'] = GoodInfo::where('baned', '0')->orderby('id', 'dsc')->limit(12)->get();
        $data['cats'] = GoodCat::orderby('cat_index', 'asc')->get();
        foreach($data['cats'] as $cat){
            $data['catgoods'][$cat->cat_name] = GoodInfo::where('cat_id', $cat->id)->where('baned', '0')->inRandomOrder()->limit(6)->get();
        }
        $data['announces'] = Announcement::orderby('id', 'dsc')->limit(5)->get();
        return View::make('welcome')->with($data);
    }

    public function announcementPage(Request $request, $announcement_id){
        $data = [];
        $data['announcement'] = Announcement::find($announcement_id);
        return View::make('layout.announcement')->with($data);
    }
}
