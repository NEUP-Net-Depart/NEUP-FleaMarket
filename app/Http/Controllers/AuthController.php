<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPassRequest;
use App\User;
use App\CheckEmail;
use App\PasswordReset;
use Mail;
use App\AuthLog;

class AuthController extends Controller
{
    public function showLogin()
    {
        return View::make('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $input = $request->all();

        if (filter_var($input['username'], FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $input['username'])->first();
            if ($user != NULL && !$user->havecheckedemail) {
                // log start
                $log = new AuthLog();
                $log->user_id = $user->id;
                $log->ip = $request->ip();
                $log->event = "login_uncheckedmail";
                $log->save();
                // log end
                return Redirect::back()->withInput()->withErrors('未验证您的邮箱，请查收您的电子邮箱或<a href="/user/' . $user->id . '/sendCheckLetter">重新发送一封</a>');
            }
        } else {
            $user = User::where('username', $input['username'])->first();
        }

        if ($user != NULL && Hash::check($input['password'], $user->password)) {
            if (Hash::needsRehash($user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            if ($user->baned) {
                // log start
                $log = new AuthLog();
                $log->user_id = $user->id;
                $log->ip = $request->ip();
                $log->event = "login_banned";
                $log->save();
                // log end
                //
                return Redirect::back()->withInput()->withErrors('You\'re banned!');
            }

            //Successfully logged in

            // log start
            $log = new AuthLog();
            $log->user_id = $user->id;
            $log->ip = $request->ip();
            $log->event = "login_success";
            $log->save();
            // log end

            $request->session()->put('user_id', $user->id);
            $request->session()->put('username', $user->username);
            $request->session()->put('nickname', $user->nickname);
            if ($user->privilege == 2)
                $request->session()->put('is_admin', 1);

            if ($user->registerCompletion() != 0)
                return Redirect::to('/register/' . $user->registerCompletion());
            else
                return Redirect::to('/');
        } else {
            // log start
            $log = new AuthLog();
            $log->username = $input['username'];
            $log->ip = $request->ip();
            $log->event = "login_authfail";
            $log->save();
            // log end
            return Redirect::back()->withInput()->withErrors('用户名或者密码错误！<a href="/iforgotit">忘记密码？</a>');
        }
    }

    public function showRegister()
    {
        return View::make('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        if (!env('ALLOW_REG', true)) {
            abort(404);
        }
        $input = $request->all();
        $user = new User;
        $user->password = Hash::make($input['password']);
        $user->email = $input['email'];
        $user->havecheckedemail = false;
        $user->save();

        // log start
        $log = new AuthLog();
        $log->user_id = $user->id;
        $log->ip = $request->ip();
        $log->event = "reg_success";
        $log->save();
        // log end
        return Redirect::to('/user/' . $user->id . '/sendCheckLetter');
    }

    public function logOut(Request $request)
    {
        // log start
        $log = new AuthLog();
        $log->user_id = $request->session()->get('user_id');
        $log->ip = $request->ip();
        $log->event = "logout";
        $log->save();
        // log end

        $request->session()->forget('user_id');
        $request->session()->forget('username');
        $request->session()->forget('nickname');
        $request->session()->forget('is_admin');

        return Redirect::to('/');
    }

    public function sendCheckLetter(Request $request, $user_id)
    {
        $data = [];
        $user = User::where('id', $user_id)->first();
        if ($user == NULL)
            abort(404);
        if ($user->havecheckedemail)
            return Redirect::to('/')->withErrors('该用户已经验证过邮箱。');
        $email = $user->email;

        $check_email = CheckEmail::where('user_id', $user_id)->first();

        if ($check_email != NULL) {
            $token = $check_email->token;
        } else {
            $new_check_email = new CheckEmail;
            $new_check_email->user_id = $user_id;
            $token = md5($email . time());
            $new_check_email->token = $token;
            $new_check_email->save();
        }
        $time = time();
        $data['token'] = base64_encode($token . "@" . $time . "@" . substr(sha1($time . env('APP_KEY')), 0, 6));
        $data['host'] = $request->server("HTTP_HOST");
        if (env('APP_ENV') != "testing")
            Mail::send('auth.checkLetter', $data, function ($m) use ($user, $email) {
                $m->from(env('MAIL_USERNAME'), "先锋市场");
                $m->to($email, $user->username)->subject('验证你的邮箱');
            });

        // log start
        $log = new AuthLog();
        $log->user_id = $user_id;
        $log->ip = $request->ip();
        $log->event = "sendcheckletter";
        $log->save();
        // log end
        return Redirect::to('/login')->withErrors('已向您的邮箱发送一封验证邮件，请查收。验证完成后即可登录先锋市场。');
    }

    public function checkEmail(Request $request, $token)
    {
        $token = explode('@', base64_decode($token));
        $check_email = CheckEmail::where('token', $token[0])->first();
        if ($check_email == NULL || substr(sha1($token[1] . env('APP_KEY')), 0, 6) != $token[2])
            return Redirect::to('/login')->withErrors('无效的链接');
        $user = User::find($check_email->user_id);
        $user->havecheckedemail = true;
        $user->update();
        $check_email->delete();

        // log start
        $log = new AuthLog();
        $log->user_id = $user->id;
        $log->ip = $request->ip();
        $log->event = "checkemail";
        $log->save();
        // log end
        return Redirect::to('/login')->withErrors('已验证您的邮箱！现在你可以登录并完善更多信息啦！');
    }

    public function showPasswordForget()
    {
        $data['method'] = 'GET';
        return View::make('auth.passwordForget')->with($data);
    }

    public function sendPasswordResetMail(Request $request)
    {
        $data['method'] = 'POST';
        $data['sentence'] = '';
        $input = $request->all();
        $user = User::where('email', $input['email'])->first();
        if ($user == NULL) {
            $data['sentence'] = '已向你的邮箱发送一份包含重置密码的链接的邮件。';
        } else {
            $data['sentence'] = '已向你的邮箱发送一份包含重置密码的链接的邮件。';
            $password_reset = PasswordReset::where('user_id', $user->id)->first();
            $email = $user->email;
            if ($password_reset != NULL) {
                $token = $password_reset->token;
            } else {
                $new_password_reset = new PasswordReset;
                $new_password_reset->user_id = $user->id;
                $token = md5($email . time());
                $new_password_reset->token = $token;
                $new_password_reset->save();
            }
            $time = time();
            $data['token'] = base64_encode($token . "@" . $time . "@" . substr(sha1($time . env('APP_KEY')), 0, 6));
            $data['host'] = $request->server("HTTP_HOST");
            if (env('APP_ENV') != "testing")
                Mail::send('auth.resetLetter', $data, function ($m) use ($user, $email) {
                    $m->from(env('MAIL_USERNAME'), '先锋市场');
                    $m->to($email, $user->username)->subject('重置密码');
                });
            // log start
            $log = new AuthLog();
            $log->user_id = $user->id;
            $log->ip = $request->ip();
            $log->event = "sendpwdresetletter";
            $log->save();
            // log end
        }
        return View::make('auth.passwordForget')->with($data);
    }

    public function showPasswordReset(Request $request, $token)
    {
        $data['method'] = 'GET';
        $data['token'] = $token;
        return view::make('auth.resetPassword')->with($data);
    }

    public function resetPassword(ResetPassRequest $request, $token)
    {
        $token = explode('@', base64_decode($token));
        $data['method'] = 'POST';
        $data['sentence'] = '';
        $password_reset = PasswordReset::where('token', $token[0])->first();
        if ($password_reset == NULL || substr(sha1($token[1] . env('APP_KEY')), 0, 6) != $token[2]) {
            $data['sentence'] = '无效的链接';
            // log start
            $log = new AuthLog();
            $log->ip = $request->ip();
            $log->event = "resetpwd_invalid";
            $log->save();
            // log end
            return View::make('user.resetPassword')->with($data);
        } else if (time() - $token[1] > 48 * 60 * 60) {
            $data['sentence'] = '此链接已过期';
            // log start
            $log = new AuthLog();
            $log->ip = $request->ip();
            $log->event = "resetpwd_expired";
            $log->save();
            // log end
            return View::make('user.resetPassword')->with($data);
        }
        $input = $request->all();
        $user = User::find($password_reset->user_id);
        $user->password = Hash::make($input['password']);
        $user->update();
        $password_reset->delete();
        $data['sentence'] = '成功重置密码！';

        // log start
        $log = new AuthLog();
        $log->user_id = $user->id;
        $log->ip = $request->ip();
        $log->event = "resetpwd_success";
        $log->save();
        // log end
        return View::make('auth.resetPassword')->with($data);
    }
}
