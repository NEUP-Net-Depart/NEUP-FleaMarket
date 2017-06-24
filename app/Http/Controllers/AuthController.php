<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetEmailRequest;
use App\Http\Requests\SetPasswordRequest;
use App\Http\Requests\SetStuidRequest;
use App\Http\Requests\SetUsernameRequest;
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
use JsonRpcClient;
use Illuminate\Support\Facades\Storage;
use App\AuthLog;
use phpCAS;
use App\Wechat;

class AuthController extends Controller
{

    static private function log($user_id, $event, $request) {
        $log = new AuthLog();
        $log->user_id = $user_id;
        $log->ip = $request->ip();
        $log->event = $event;
        $log->save();
    }

    function http_get_data($url) {

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        ob_start ();
        curl_exec ( $ch );
        $return_content = ob_get_contents ();
        ob_end_clean ();

        $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        return $return_content;
    }

    private function wechatReg($user, $request) {
        if($request->session()->has('wechat_open_id') && !$user->baned) {
            $user->wechat_open_id = $request->session()->get('wechat_open_id');
            $user->save();

            $wechat = Wechat::where('open_id', $user->wechat_open_id)->first();
            if($wechat && !Storage::exists('avatar/' . $user->id))
                Storage::put('avatar/' . $user->id, $this->http_get_data($wechat->head_img_url));
            if($wechat && !$user->nickname) {
                $user->nickname = $wechat->nick_name;
                $user->save();
            }

            $this->log($user->id, "WechatBind_Success", $request);
        }
    }

    private function afterLogin($user, $request) {
        if ($user->baned) {
            $nowdate = time();
            $banedstart = $user->banedstart;
            $date = $nowdate - $banedstart;
            if ($date > ($user->banedtime) * 86400 && $user->banedtime != -1) {
                $user->baned = 0;
                return Redirect::to('/');
            }

            $this->log($user->id, "AfterLogin_Banned", $request);

            if ($user->banedtime == -1)
                return Redirect::to('/login')->withInput()->withErrors('你已经被永久封禁!');
            return Redirect::to('/login')->withInput()->withErrors('你已经被封禁!' . ceil($user->banedtime - ($date / 86400)) . '天后解禁!');
        }

        $this->log($user->id, "AfterLogin_Success", $request);

        $request->session()->put('user_id', $user->id);
        $request->session()->put('username', $user->username);
        $request->session()->put('nickname', $user->nickname);
        if ($user->privilege)
            $request->session()->put('is_admin', $user->privilege);

        if ($user->registerCompletion() != 0)
            return Redirect::to('/register/' . $user->registerCompletion());
        else
            return Redirect::to('/');
    }

    public function showLogin()
    {
        return View::make('auth.login');
    }

    public function wx(Request $request)
    {
        if(isset($request->data) && $request->sign == substr(md5($request->data . env('WECHAT_KEY')), 8, 16))
        {
            $data['wechat'] = json_decode(base64_decode($request->data));
            $user = User::where('wechat_open_id', $data['wechat']->openId)->first();
            $request->session()->put('wechat_open_id', $data['wechat']->openId);
            if(!$user) {
                $wechat = Wechat::firstOrNew(['open_id' => $data['wechat']->openId]);
                $wechat->head_img_url = $data['wechat']->headImgUrl;
                $wechat->nick_name = $data['wechat']->nickName;
                $wechat->sex = $data['wechat']->sex;
                $wechat->save();

                return view('auth.wechatGuide')->with($data);
            }
            else {
                $this->log($user->id, "Wechat_Login", $request);
                return $this->afterLogin($user, $request);
            }
        }
        return Redirect::to("http://api.xms.rmbz.net/open/oauth?path=" . env("APP_URL") . "/wx");
    }

    public function cas(Request $request)
    {
        phpCAS::client(CAS_VERSION_2_0, "sso.neu.cn", 443, "/cas");
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();
        $stuid = phpCAS::getUser();
        $user = User::where('stuid', $stuid)->first();
        if(!$user)
        {
            $user = new User;
            $user->privilege = 0;
            $user->stuid = $stuid;
            $user->havecheckedemail = false;
            $user->role = 0;
            $user->baned = false;
            $user->realname = phpCAS::getAttribute('name');
            $user->save();

            $this->log($user->id, "Cas_Reg_Success", $request);
            $this->wechatReg($user, $request);

            $request->session()->put('user_id', $user->id);

            return Redirect::to('/register/' . $user->registerCompletion());
        }
        else
        {
            $this->log($user->id, "Cas_Login", $request);
            $this->wechatReg($user, $request);
            return $this->afterLogin($user, $request);
        }
    }

    public function login(LoginRequest $request)
    {
        $input = $request->all();

        if (filter_var($input['username'], FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $input['username'])->first();
            if ($user != NULL && !$user->havecheckedemail) {
                $this->log($user->id, "login_uncheckedmail", $request);
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

            $this->log($user->id, "Normal_Login", $request);
            $this->wechatReg($user, $request);
            return $this->afterLogin($user, $request);

        } else {
            $this->log($user == NULL ? "" : $user->id, "login_authfail", $request);
            return Redirect::back()->withInput()->withErrors('用户名或者密码错误！<a href="/iforgotit">忘记密码？</a>');
        }
    }

    public function showRegister()
    {
        if (!env('ALLOW_REG', false)){
            return View::make('auth.ssoGuide');
        }else{
            return View::make('auth.register');
        }
    }

    public function register(RegisterRequest $request)
    {
        if (!env('ALLOW_REG', false)) {
            abort(404);
        }
        $input = $request->all();
        $user = new User;
        $user->password = Hash::make($input['password']);
        $user->email = $input['email'];
        $user->havecheckedemail = false;
        $user->role = 0;
        $user->baned = false;
        $user->save();

        $this->log($user->id, "reg_success", $request);
        return $this->sendCheckLetter($request, $user->id);
    }

    public function logOut(Request $request)
    {
        $this->log($request->session()->get('user_id'), "logout", $request);

        $request->session()->forget('user_id');
        $request->session()->forget('username');
        $request->session()->forget('nickname');
        $request->session()->forget('is_admin');
        $request->session()->forget('wechat_open_id');

        return Redirect::to('/');
    }

    public function sendCheckLetter(Request $request, $user_id)
    {
        if(self::doSendCheckLetter($request, $user_id))
            return Redirect::to('/login')->withErrors('该用户已经验证过邮箱。');
        return Redirect::to('/login')->withErrors('已向您的邮箱发送一封验证邮件，请查收。验证完成后即可登录先锋市场。');
    }

    static private function doSendCheckLetter(Request $request, $user_id)
    {
        $data = [];
        $user = User::where('id', $user_id)->first();
        if ($user == NULL)
            abort(404);
        if ($user->havecheckedemail)
            return true;
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
        $data['token'] = base64_encode($token . "#" . $time . "#" . $email . "#" . substr(sha1($time . $email . env('APP_KEY')), 0, 6));
        $data['host'] = $request->server("HTTP_HOST");
        if (env('APP_ENV') != "testing") {
            $conn = new JsonRpcClient(env('MAIL_RPC_HOST', "127.0.0.1"), env('MAIL_RPC_PORT', 65525));
            $mailSettings = [];
            $mailSettings["Body"] = view('auth.checkLetter')->with($data)->render();
            $mailSettings["To"] = $email;
            $mailSettings["FromName"] = "先锋市场";
            $mailSettings["Subject"] = "验证你的邮箱";
            $mailSettings["SendID"] = "service";
            $conn->Call("Daemon.SendMail", $mailSettings);
        }

        self::log($user->id, "sendcheckletter", $request);
    }

    static private function doSendUnbindLetter(Request $request, $user_id)
    {
        $data = [];
        $user = User::where('id', $user_id)->first();
        if ($user == NULL)
            abort(404);
        if (!$user->havecheckedemail) {
            $user->email = null;
            $user->save();
            return true;
        }
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
        $data['token'] = base64_encode($token . "#" . $time . "#" . $email . "#" . substr(sha1($time . $email . env('APP_KEY')), 0, 6));
        $data['host'] = $request->server("HTTP_HOST");
        if (env('APP_ENV') != "testing") {
            $conn = new JsonRpcClient(env('MAIL_RPC_HOST', "127.0.0.1"), env('MAIL_RPC_PORT', 65525));
            $mailSettings = [];
            $mailSettings["Body"] = view('auth.unbindLetter')->with($data)->render();
            $mailSettings["To"] = $email;
            $mailSettings["FromName"] = "先锋市场";
            $mailSettings["Subject"] = "邮箱解绑请求";
            $mailSettings["SendID"] = "service";
            $conn->Call("Daemon.SendMail", $mailSettings);
        }

        self::log($user->id, "sendunbindletter", $request);
    }

    public function setUsername(SetUsernameRequest $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if ($user->username == '') {
            $user->username = $input['username'];
            $user->save();
            if(!$user->password)
                return Redirect::to('/user?tab=account')->withInput()->withErrors('设置成功！但是你必须设置密码才可以使用用户名登录。');
            else
                return Redirect::to('/user?tab=account')->withInput()->withErrors('设置成功！');
        }
        else
            return Redirect::to('/user?tab=account')->withInput()->withErrors('用户名不能更改');
    }

    public function setStuid(SetStuidRequest $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if ($user->stuid == '') {
            $user->stuid = $input['stuid'];
            $user->save();
            return Redirect::to('/user?tab=account')->withInput()->withErrors('设置成功！');
        }
        else
            return Redirect::to('/user?tab=account')->withInput()->withErrors('学号一旦设置不能更改，请联系管理员');
    }

    public function setEmail(SetEmailRequest $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if ($user->email == '') {
            $user->email = $input['email'];
            $user->havecheckedemail = false;
            $user->save();
            self::doSendCheckLetter($request, $user_id);
            if(!$user->password)
                return Redirect::to('/user?tab=account')->withErrors('已向您的邮箱发送一封验证邮件，请查收。请注意，你必须先设置密码才可以使用邮箱登录。');
            else
                return Redirect::to('/user?tab=account')->withErrors('已向您的邮箱发送一封验证邮件，请查收。');
        }
        else {
            if(self::doSendUnbindLetter($request, $user_id))
                return Redirect::to('/user?tab=account')->withErrors('解绑成功。');
            return Redirect::to('/user?tab=account')->withInput()->withErrors('已向您的邮箱发送一封验证邮件，请查收。验证完成后即可解绑此邮箱。');
        }
    }

    public function setPassword(SetPasswordRequest $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if ($user->password != '' && !Hash::check($input['password'], $user->password))
            return Redirect::to('/user?tab=account')->withErrors('旧密码错误');
        $user->password = Hash::make($input['newPassword']);
        $user->update();
        return Redirect::to('/user?tab=account')->withErrors('密码已变更。');
    }


    public function checkEmail(Request $request, $token)
    {
        $token = explode('#', base64_decode($token));
        $check_email = CheckEmail::where('token', $token[0])->first();
        if ($check_email == NULL || substr(sha1($token[1] . $token[2] . env('APP_KEY')), 0, 6) != $token[3])
            return Redirect::to('/login')->withErrors('无效的链接');
        $user = User::find($check_email->user_id);
        if($user->email != $token[2])
            return Redirect::to('/login')->withErrors('此链接已失效。');
        $user->havecheckedemail = true;
        $user->update();
        $check_email->delete();

        $this->log($user->id, "checkemail", $request);

        return Redirect::to('/login')->withErrors('已验证您的邮箱！现在你可以用这个邮箱登录啦！');
    }

    public function unbindEmail(Request $request, $token)
    {
        $token = explode('#', base64_decode($token));
        $check_email = CheckEmail::where('token', $token[0])->first();
        if ($check_email == NULL || substr(sha1($token[1] . $token[2] . env('APP_KEY')), 0, 6) != $token[3])
            return Redirect::to('/login')->withErrors('无效的链接');
        $user = User::find($check_email->user_id);
        if($user->email != $token[2])
            return Redirect::to('/login')->withErrors('此链接已失效。');
        $user->email = null;
        $user->update();
        $check_email->delete();

        $this->log($user->id, "unbindemail", $request);

        return Redirect::to('/user?tab=account')->withErrors('已解绑您的邮箱！');
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
        $data['alert'] = '';
        $data['fa'] = '';
        $input = $request->all();
        $user = User::where('email', $input['email'])->first();
        if ($user == NULL) {
            $data['sentence'] = '已向你的邮箱发送一份包含重置密码的链接的邮件。';
            $data['alert'] = 'success';
            $data['fa'] = 'check';
        } else {
            $data['sentence'] = '已向你的邮箱发送一份包含重置密码的链接的邮件。';
            $data['alert'] = 'success';
            $data['fa'] = 'check';
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
            $data['token'] = base64_encode($token . "#" . $time . "#" . substr(sha1($time . env('APP_KEY')), 0, 6));
            $data['host'] = $request->server("HTTP_HOST");
            if (env('APP_ENV') != "testing") {
                $conn = new JsonRpcClient(env('MAIL_RPC_HOST', "127.0.0.1"), env('MAIL_RPC_PORT', 65525));
                $mailSettings = [];
                $mailSettings["Body"] = view('auth.resetLetter')->with($data)->render();
                $mailSettings["To"] = $email;
                $mailSettings["FromName"] = "先锋市场";
                $mailSettings["Subject"] = "重置密码";
                $mailSettings["SendID"] = "service";
                $conn->Call("Daemon.SendMail", $mailSettings);
            }

            $this->log($user->id, "sendpwdresetletter", $request);

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
        $token = explode('#', base64_decode($token));
        $data['method'] = 'POST';
        $data['sentence'] = '';
        $data['alert'] = '';
        $data['fa'] = '';
        $password_reset = PasswordReset::where('token', $token[0])->first();
        if ($password_reset == NULL || substr(sha1($token[1] . env('APP_KEY')), 0, 6) != $token[2]) {
            $data['sentence'] = '无效的链接';
            $data['alert'] = 'danger';
            $data['fa'] = 'exclamation-circle';
            $this->log("", "resetpwd_invalid", $request);
            return View::make('user.resetPassword')->with($data);
        } else if (time() - $token[1] > 48 * 60 * 60) {
            $data['sentence'] = '此链接已过期';
            $data['alert'] = 'danger';
            $data['fa'] = 'exclamation-circle';
            $this->log("", "resetpwd_expired", $request);
            return View::make('user.resetPassword')->with($data);
        }
        $input = $request->all();
        $user = User::find($password_reset->user_id);
        $user->password = Hash::make($input['password']);
        $user->update();
        $password_reset->delete();
        $data['sentence'] = '成功重置密码！';
        $data['alert'] = 'success';
        $data['fa'] = 'check';

        $this->log($user->id, "resetpwd_success", $request);

        return View::make('auth.resetPassword')->with($data);
    }
}
