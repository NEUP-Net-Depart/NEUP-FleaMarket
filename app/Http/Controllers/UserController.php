<?php
/**
 * Created by PhpStorm.
 * User: koooyf
 * Date: 6/10/16
 * Time: 8:33 PM
 */

namespace App\Http\Controllers;

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
use App\Http\Controllers\Controller;
use Hash;
use Mail;
use Image;

class UserController extends Controller
{
    public function showCompleteInfo(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));
        $data['user'] = $user;
        return View::make('auth.register2')->with($data);
    }

    public function completeInfo(Request $request)
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

    public function getList(Request $request, $user_id)
    {
        $data = [];
        $data['user'] = User::find($user_id);
        return View::make('user.userinfo')->with($data);
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
            return Redirect::to('/user/edit_favlist');
        foreach ($input['del_goods'] as $del_good) {
            $item = FavList::where('user_id', $user_id)->where('good_id', $del_good)->get();
            foreach ($item as $it) {
                $del_id = FavList::find($it->id);
            }
            $del_id->delete();
        }
        return Redirect::to('/user/edit_favlist');
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
}
