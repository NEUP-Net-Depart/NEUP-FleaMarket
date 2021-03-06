<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\GoodCat;
use App\GoodInfo;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ContentController extends Controller
{
    public function Mainpage()
    {
        $data = [];
        $data['cats'] = GoodCat::orderby('cat_index', 'asc')->get();
        $data['stargoods'] = GoodInfo::where('baned', false)->where('stared', '1')->orderby('id',
            'asc')->limit(5)->get();
        $data['newgoods'] = GoodInfo::where('baned', false)->where('count', '>', 0)->orderby('id',
            'dsc')->limit(6)->get();
        $data['populargoods'] = GoodInfo::where('baned', false)->where('count', '>', 0)->where('fav_num', '>',
            0)->orderby('fav_num', 'desc')->limit(6)->get();
        foreach ($data['cats'] as $cat) {
            $data['catgoods'][$cat->cat_name] = GoodInfo::where('cat_id', $cat->id)->where('baned',
                false)->where('count', '>', 0)->inRandomOrder()->limit(6)->get();
        }
        $data['announces'] = Announcement::orderby('id', 'dsc')->limit(5)->get();
        $data['trans'] = Transaction::where('status', '>', 3)->orderby('id', 'dsc')->limit(20)->get();
        $data['stargoodfirstid'] = rand(0, count($data['stargoods']) - 1);

        return View::make('welcome')->with($data);
    }

    public function announcementPage(Request $request, $notice_id)
    {
        $data = [];
        $data['announcement'] = Announcement::find($notice_id);

        return View::make('layout.announcement')->with($data);
    }

    public function tos()
    {
        return view('common.tos');
    }

    public function faq()
    {
        return view('common.faq');
    }

    public function pp()
    {
        return view('common.pp');
    }

    public function help()
    {
        return view('help');
    }

}
