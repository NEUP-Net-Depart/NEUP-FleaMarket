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
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function adduser(Request $request)
    {
        $this->validate($request,[
            'username'=>'required|max:20',
            'email'=>'required|email|max:20',
            'password'=>'required|max:20',
            'stuid'=>'required|max:8',
            'nickname'=>'required|max:20',
        ]);
        $test = User::where('username',$request->username)->first();
        if($test!=NULL)
        {
            return redirect()->back()->withInput()->withErrors('用户名已存在！');
            echo "用户名已存在！";
        }
        $user=new User;
        $user->username=$request->username;
        $user->password=$request->password;
        $user->email=$request->email;
        $user->stuid=$request->stuid;
        $user->nickname=$request->nickname;
        if($user->save())
        {
            return redirect('/show');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors('注册失败！');
        }
    }
    public function login(Request $request)
    {
        $user = User::where('username',$request->username)->first();
        if($user->password==$request->password)
        {
            $request->session()->put('user_id', $user->id);
            $request->session()->put('username', $user->username);
			if($user->privilege == 1)
				$request->session()->put('is_admin', 1);
            return redirect('/good');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors('用户名或者密码错误！');
        }
    }
    public  function register(Request $request)
    {
        return view('User.register');
    }
    public  function show(Request $request)
    {
        return view('User.show');
    }
}
