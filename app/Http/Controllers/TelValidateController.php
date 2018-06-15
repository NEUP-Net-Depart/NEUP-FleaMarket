<?php

namespace App\Http\Controllers;

use App\User;
use Germey\Geetest\Geetest;
use Illuminate\Http\Request;
use Mockery\Exception;

class TelValidateController extends Controller
{
    /**
     * @param Request $request
     * @return bool
     */
    public function geetestValidate(Request $request)
    {
        $this->validate($request, [
            'geetest_challenge' => 'geetest',
        ], [
            'geetest' => config('geetest.server_fail_alert'),
        ]);

        return true;
    }

    /**
     * @param Request $request
     * @return string(json)
     */
    public function sendRegTextCaptcha(Request $request)
    {
        //Check if tel exist
        if (User::where('tel', $request->tel)->count() > 0) {
            return json_encode(['rst' => 'false', 'msg' => '手机已存在']);
        }

        return $this->sendTextCaptcha($request);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function sendTextCaptcha(Request $request)
    {
        if (env('APP_ENV') != 'testing') {
            //Check Geetest status
            // $this->geetestValidate($request);
            //Check last sent time
            if ($request->session()->has('captcha.timestamp')) {
                if (time() - intval($request->session()->get('captcha.timestamp')) <= intval(env('MSG_COOLDOWN'))) {
                    return json_encode(['rst' => 'false', 'msg' => '重试间隔过短，请稍等']);
                }
            }
            //Generate random captcha
            $captcha = "";
            for ($i = 0; $i < 6; ++$i) {
                $captcha .= strval(rand(1, 9));
            }
            //Post to Yunpian api
            $ch = curl_init();
            $apikey = env('YUNPIAN_APIKEY');
            $mobile = $request->tel;
            $text = view('auth.textCaptcha')->with([
                'code' => $captcha,
            ])->render();
            $data = ['text' => $text, 'apikey' => $apikey, 'mobile' => $mobile];
            try {
                curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = json_decode(curl_exec($ch), true);
                if ($result['code'] == 0) {
                    //Save info to session
                    $request->session()->put('captcha.tel', $request->tel);
                    $request->session()->put('captcha.text', $captcha);
                    $request->session()->put('captcha.timestamp', time());

                    return json_encode(['rst' => 'true', 'msg' => $result['msg']]);
                } else {
                    return json_encode(['rst' => 'false', 'msg' => $result['msg']]);
                }
            } catch (Exception $exception) {
                return json_encode(['rst' => 'false', 'msg' => '服务器错误']);
            }
        } else {
            $request->session()->put('captcha.tel', $request->tel);

            return json_encode([]);
        }
    }

    /**
     * @param Request $request
     * @return string(json)
     */
    public function sendChangeTextCaptcha(Request $request)
    {
        //Check if tel changed
        $user = User::find($request->session()->get('user_id'));
        if ($user->tel == $request->tel) {
            return json_encode(['rst' => 'false', 'msg' => '新手机与旧手机不能相同']);
        }

        return $this->sendTextCaptcha($request);
    }

    public function saveUserTel(Request $request)
    {
        if (env('APP_ENV') != 'testing') {
            $this->validate($request, [
                'tel' => 'required',
                'captcha' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'tel' => 'required',
            ]);
        }
        //Check if tel distorted
        if ($request->tel != $request->session()->get('captcha.tel')) {
            return json_encode(['rst' => 'false', 'msg' => '前后手机号码不一致，请重新进行验证']);
        }
        if (env('APP_ENV') != 'testing') {
            //Validate text captcha
            if (!$request->session()->has('captcha.text') ||
                $request->captcha != $request->session()->get('captcha.text')
            ) {
                return json_encode(['rst' => 'false', 'msg' => '验证码无效']);
            }
            if (!$request->session()->has('captcha.timestamp') ||
                time() - intval($request->session()->get('captcha.timestamp')) > intval(env('CAPTCHA_VALID_MINUTE')) * 60
            ) {
                return json_encode(['rst' => 'false', 'msg' => '验证码已过期']);
            }
        }
        //Check if tel exist
        if (User::where('tel', $request->tel)->count() > 0) {
            return json_encode(['rst' => 'false', 'msg' => '手机已存在']);
        }
        //Update user's tel
        $user = User::find($request->session()->get('user_id'));
        $user->tel = $request->session()->get('captcha.tel');
        $user->save();

        return json_encode(['rst' => 'true', 'msg' => '手机绑定成功']);
    }
}
