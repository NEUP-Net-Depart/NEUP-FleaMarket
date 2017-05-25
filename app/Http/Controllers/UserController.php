<?php
/**
 * Created by PhpStorm.
 * User: koooyf
 * Date: 6/10/16
 * Time: 8:33 PM
 */

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserInfoRequest;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\User;
use App\UserInfo;
use App\FavList;
use App\GoodInfo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Hash;
use Mail;
use Image;

class UserController extends Controller
{
    public function showCompleteUser(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));
        $data['user'] = $user;
        return View::make('auth.register2')->with($data);
    }

    public function completeUser(Request $request)
    {
        $input = $request->all();
        $user = User::find($request->session()->get('user_id'));
        if (isset($input['nickname']))
            $user->nickname = $input['nickname'];
        $user->update();
        if ($request->hasFile('avatarPic'))
            Storage::put(
                'avatar/' . $user->id,
                Image::make($request->file('avatarPic'))->crop(round($input['crop_width']), round($input['crop_height']), round($input['crop_x']), round($input['crop_y']))->resize(800, 450)->encode('data-url')
            );
        if ($user->registerCompletion() != 0)
            return Redirect::to('/register/' . $user->registerCompletion());
        else
            return Redirect::to('/');
    }

    public function regUserInfo(Request $request)
    {
        $data = [];
        $data['userinfos'] = UserInfo::where('user_id', $request->session()->get('user_id'))->get();
        return View::make('auth.register3')->with($data);
    }

    public function userInfo(Request $request)
    {
        $data = [];
        $data['userinfos'] = UserInfo::where('user_id', $request->session()->get('user_id'))->get();
        return View::make('user.userInfo')->with($data);
    }

    public function createUserInfo()
    {
        return View::make('user.createUserInfo');
    }

    public function storeUserInfo(StoreUserInfoRequest $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user_info = new UserInfo();
        $user_info->user_id = $user_id;
        $user_info->realname = $input['realname'];
        if (isset($input['gender']))
            $user_info->gender = $input['gender'];
        if (isset($input['tel_num']))
            $user_info->tel_num = $input['tel_num'];
        if (isset($input['QQ']))
            $user_info->tel_num = $input['QQ'];
        if (isset($input['wechat']))
            $user_info->tel_num = $input['wechat'];
        if (isset($input['address']))
            $user_info->tel_num = $input['address'];
        $user_info->save();

        return json_encode([
            'result' => 'true',
            'msg' => 'success'
        ]);
    }

    public function getList(Request $request, $user_id)
    {
        $data = [];
        $data['user'] = User::find($user_id);
        $data['userinfos'] = UserInfo::where('user_id', $user_id)->get();
        return View::make('user.user')->with($data);
    }

    public function editList(Request $request, $user_id)
    {
        $input = $request->all();
        $user = User::find($user_id);
        if (isset($input['nickname']))
            $user->nickname = $input['nickname'];
        $user->update();
        if ($request->hasFile('avatarPic'))
            Storage::put(
                'avatar/' . $user_id,
                Image::make($request->file('avatarPic'))->crop(round($input['crop_width']), round($input['crop_height']), round($input['crop_x']), round($input['crop_y']))->resize(800, 450)->encode('data-url')
            );
        return Redirect::to('/user/' . $user_id);
    }

    public function showEditPage(Request $request, $user_id)
    {
        $data = [];
        $data['user'] = User::find($user_id);
        return View::make('user.editinfo')->with($data);
    }

    public function getFavlist(Request $request)
    {
        $data = [];
        $data['user_id'] = $request->session()->get('user_id');
        $data['goods'] = FavList::orderby('id', 'asc')->where('user_id', $data['user_id'])->get();
        $data['good_info'] = GoodInfo::orderBy('id', 'asc')->get()->keyBy('id');
        return view::make('user.favlist')->with($data);
    }

    public function editFavlist(Request $request)
    {
        $data = [];
        $data['user_id'] = $request->session()->get('user_id');
        $data['goods'] = FavList::orderBy('id', 'asc')->where('user_id', $data['user_id'])->get();
        $data['good_info'] = GoodInfo::orderBy('id', 'asc')->get()->keyBy('id');
        return view::make('user.editFavlist')->with($data);
    }

    public function delFavlist(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $input = $request->all();
        if (!isset($input['del_goods']))
            return Redirect::to('/user/fav/edit');
        foreach ($input['del_goods'] as $del_good) {
            FavList::where('user_id', $user_id)->where('good_id', $del_good)->delete();
        }
        return Redirect::to('/user/fav/edit');
    }

    public function getSimpleAvatar(Request $request, $user_id)
    {
        if (!Storage::exists('avatar/' . $user_id))
            $file = Storage::get('public/avatar.jpg');
        else
            $file = Storage::get('avatar/' . $user_id);
        $image = Image::make($file)->resize(600, 600);
        return $image->response('jpg');
    }

    public function getAvatar(Request $request, $user_id, $width, $height)
    {
        if (!Storage::exists('avatar/' . $user_id))
            $file = Storage::get('public/avatar.jpg');
        else
            $file = Storage::get('avatar/' . $user_id);
        $image = Image::make($file)->resize($width, $height);
        return $image->response('jpg');
    }

    public function seller(Request $request)
    {
        $data = [];
        $page = isset($request->page) ? $request->page : 1;
        $user_id = $request->session()->get('user_id');
        $data['goods'] = GoodInfo::where('user_id', $user_id)->get();
        $trans = User::with(['trans' => function ($query) use($page) {
            $query->orderBy('id', 'desc')->offset(($page - 1) * 15)->limit(15);
        }])->find($user_id)->trans;

        $data['trans'] = new Paginator($trans, 15, $page);
        return view::make('user.seller')->with($data);
    }

    public function buyer(Request $request)
    {
        $data = [];
        $user_id = $request->session()->get('user_id');
        $data['trans'] = Transaction::where('buyer_id', $user_id)->get();
        return view::make('user.buyer')->with($data);
    }

}
