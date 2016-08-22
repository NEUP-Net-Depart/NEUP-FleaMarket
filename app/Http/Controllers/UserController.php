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
use App\CheckEmail;
use App\PasswordReset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Hash;
use Mail;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if($request->method()=='GET'){
            return View::make('user.login');
        }else{
            $input = $request->all();
            $user = User::where('username',$input['username'])->first();
            if(sha1($input['password'])==$user->password&&(!$user->baned))
            {
                if(!$user->havecheckedemail) return Redirect::back()->withInput()->withErrors('未验证您的邮箱，请查收您的电子邮箱或<a href\"/user/'.$user->id.'/sendCheckLetter\">重新发送一封</a>'); 
                $request->session()->put('user_id', $user->id);
                $request->session()->put('username', $user->username);
                $request->session()->put('nickname', $user->nickname);
			    if($user->privilege == 2)
				    $request->session()->put('is_admin', 1);
                return Redirect::to('/');
            }
            else
            {
                return Redirect::back()->withInput()->withErrors('用户名或者密码错误！');
            }
        }
    }

    public function register(RegisterRequest $request)
    {
        if($request->method()=='GET'){
            return View::make('user.register');
        }else{
            $input = $request->all();
            $user = new User;
            $user->username = $input['username'];
            $user->password = sha1($input['password']);
            $user->email = $input['email'];
            $user->nickname = $input['nickname'];
            $user->havecheckedemail = false;
            $user->save();
            $userinfo=new UserInfo;
            $userinfo->save();
            $new_user = User::where('username', $user->username)->first();
            return Redirect::to('/user/'.$new_user->id.'/sendCheckLetter');
        }
    }

    public function getList(Request $request, $user_id)
    {
        $data = [];
        $data['user'] = UserInfo::find($user_id);
        return View::make('user.userinfo')->with($data);
    }

    public function logOut(Request $request)
    {
        $request->session()->forget('user_id');
        $request->session()->forget('username');
        $request->session()->forget('nickname');
        $request->session()->forget('is_admin');
        return Redirect::to('/');
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
        return Redirect::to('/user/'.$user_id);
    }

    public function showEditPage(Request $request, $user_id)
    {
        $data = [];
        $data['user'] = UserInfo::find($user_id);
        return View::make('user.editinfo')->with($data);
    }

    public function sendCheckLetter(Request $request, $user_id)
    {
        $data = [];
        $user = User::where('id',$user_id)->first();
        if($user->havecheckedemail) return Redirect::to('/')->withErrors('该用户已经验证过邮箱。');
        $check_email = CheckEmail::where('user_id',$user_id)->first();
        $email = $user->email;
        $token = sha1($email.time());
        if($check_email!=NULL){
            $token = $check_email->token;
        }else{
            $new_check_email = new CheckEmail;
            $new_check_email->user_id = $user_id;
            $new_check_email->token = $token;
            $new_check_email->save();
        }
        $data['token'] = $token;
        $data['host'] = $request->server("HTTP_HOST");
        Mail::send('user.checkLetter', $data, function ($m) use ($user, $email) {
            $m->from('519418441@qq.com', 'Catsworld');
            $m->to($email, $user->username)->subject('');
        });
        return Redirect::to('/login')->withErrors('已向您的邮箱发送一封验证邮件，请查收。验证完成后即可登录先锋市场。');
    }

    public function haveSentCheckLetter(Request $request)
    {
        return View::make('user.haveSentCheckLetter');
    }
    
    public function checkEmail(Request $request, $token)
    {
        $check_email = CheckEmail::where('token', $token)->first();
        if($check_email==NULL) return Redirect::to('/login')->withErrors('未知的Token。');
        $user = User::find($check_email->user_id);
        $user->havecheckedemail = true;
        $user->update();
        $check_email->delete();
        return Redirect::to('/login')->withErrors('已向验证您的邮箱！现在你可以登录并完善更多信息啦！');
    }

    public function passwordReset(Request $request)
    {
        if($request->method() == 'GET'){
            $data['method']='GET';
            return View::make('user.passwordReset')->with($data);
        }else{
            $data['method']='POST';
            $data['sentence']='';
            $input = $request->all();
            $user = User::where('username', $input['username'])->first();
            if($user==NULL||$user->email!=$input['email']){
                $data['sentence']='无法验证你的身份，请检查用户名与邮箱是否有误';
            }else{
                $data['sentence']='已向你的邮箱发送一份包含重置密码的链接的邮件。';
                $password_reset = PasswordReset::where('user_id',$user->id)->first();
                $email = $user->email;
                $token = sha1($email.time());
                if($password_reset!=NULL){
                    $token = $password_reset->token;
                }else{
                    $new_password_reset = new PasswordReset;
                    $new_password_reset->user_id = $user->id;
                    $new_password_reset->token = $token;
                    $new_password_reset->save();
                }
                $data['token'] = $token;
                $data['host'] = $request->server("HTTP_HOST");
                Mail::send('user.resetLetter', $data, function ($m) use ($user, $email) {
                    $m->from('519418441@qq.com', 'Catsworld');
                    $m->to($email, $user->username)->subject('');
                });
            }
            return View::make('user.passwordReset')->with($data);
        }
    }

    public function resetPassword(Request $request, $token)
    {
        if($request->method() == 'GET'){
            $data['method'] = 'GET';
            $data['token'] = $token;
            return view::make('user.resetPassword')->with($data);
        }else{
            $data['method'] = 'POST';
            $data['sentence'] = '';
            $password_reset = PasswordReset::where('token', $token)->first();
            if($password_reset==NULL){
                $data['sentence'] = '未知的Token';
                return View::make('user.resetPassword')->with($data);
            }
            $input = $request->all();
            $user = User::find($password_reset->user_id);
            $user->password = sha1($input['password']);
            $user->update();
            $password_reset->delete();
            $data['sentence'] = '成功重置密码！';
            return View::make('user.resetPassword')->with($data);
        }
    }
}
