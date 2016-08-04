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
use Illuminate\Support\Facades\Storage;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Hash;

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
        $input = $request->all();
        $test = User::where('username',$request->username)->first();
        if($test!=NULL)
        {
            return redirect()->back()->withInput()->withErrors('用户名已存在！');
            echo "用户名已存在！";
        }
        $user=new User;
        $user->username = $input['username'];
        $user->password = Hash::make($request->password);
        //$user->password = $input['password'];
        $user->email = $input['email'];
        $user->stuid = $input['stuid'];
        $user->nickname = $input['nickname'];
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
        $input = $request->all();
        $user = User::where('username',$request->username)->first();
<<<<<<< Updated upstream
        if($user->password==$request->password&&$user->baned==0)
=======
        if(Hash::check($request->password, $user->password))
>>>>>>> Stashed changes
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
        return View::make('User.register');
    }

    public  function show(Request $request)
    {
        return View::make('User.show');
    }

    public function getList(Request $request, $user_id)
    {
        $data = [];
        $data['user'] = UserInfo::find($user_id);
        return View::make('User.userinfo')->with($data);
    }
    public function editList(Request $request, $user_id)
    {
        $input = $request->all();
        $user = UserInfo::find($user_id);
        $user->gender = $input['gender'];
        $user->realname = $input['realname'];
        $user->tel_num = $input['tel_num'];
        $user->address = $input['address'];
        $user->update();
        return redirect('/user/'.$user_id);
    }

    public function showeditpage(Request $request, $user_id)
    {
        $data = [];
        $data['user'] = UserInfo::find($user_id);
        return View::make('User.editinfo')->with($data);
    }
}
