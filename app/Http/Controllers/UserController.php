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
use App\Http\Requests\SetPasswordRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Hash;
use Mail;
use Image;
use JsonRpcClient;
use App\Ticket;
use App\AdminEvent;

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
        if($user->registerCompletion() == 2)
            return Redirect::to('/register/3');
        else if ($user->registerCompletion() != 0)
            return Redirect::to('/register/' . $user->registerCompletion());
        else
            return Redirect::to('/');
    }

    public function completeAccount(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));
        if($user->registerCompletion() == 0)
            return Redirect::to('/');
        return view('auth.register3')->with(['user' => $user]);
    }

    public function regUserInfo(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $data = [];
        $data['user'] = User::where('id', $user_id)->first();
        $data['userinfos'] = UserInfo::where('user_id', $user_id)->get();
        return View::make('auth.register4')->with($data);
    }

    public function userInfo(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $data = [];
        $data['user'] = User::where('id', $user_id)->first();
        $data['userinfos'] = UserInfo::where('user_id', $user_id)->get();
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
        if (isset($input['gender']))
            $user_info->gender = $input['gender'];
        if (isset($input['tel_num']))
            $user_info->tel_num = $input['tel_num'];
        if (isset($input['QQ']))
            $user_info->QQ = $input['QQ'];
        if (isset($input['wechat']))
            $user_info->wechat = $input['wechat'];
        if (isset($input['address']))
            $user_info->address = $input['address'];
        $user_info->save();

        return json_encode([
            'result' => 'true',
            'msg' => 'success'
        ]);
    }

    public function editUserInfo(Request $request, $userinfo_id)
    {
        $data = [];
        $data['userinfo'] = UserInfo::where('id', $userinfo_id)->get();
        $user_id = $request->session()->get('user_id');
        if ($data['userinfo'][0]->user_id != $user_id) return Redirect::to('/user/' . $user_id)->withErrors('无权限访问');
        return View::make('user.editUserInfo')->with($data);
    }

    public function updateUserInfo(StoreUserInfoRequest $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user_info = UserInfo::find($request->id);
        if ($user_info->user_id != $user_id) return Redirect::to('/user/' . $user_id)->withErrors('无权限访问');
        if (isset($input['gender'])) $user_info->gender = $input['gender'];
        else $user_info->gender = '';
        if (isset($input['tel_num'])) $user_info->tel_num = $input['tel_num'];
        else $user_info->tel_num = '';
        if (isset($input['QQ'])) $user_info->QQ = $input['QQ'];
        else $user_info->QQ = '';
        if (isset($input['wechat'])) $user_info->wechat = $input['wechat'];
        else $user_info->wechat = '';
        if (isset($input['address'])) $user_info->address = $input['address'];
        else $user_info->address = '';
        $user_info->update();
        return json_encode([
            'result' => 'true',
            'msg' => 'success'
        ]);
    }

    public function deleteUserInfo(Request $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user_info = UserInfo::find($input['id']);
        if ($user_info->user_id != $user_id) return Redirect::to('/user/' . $user_id)->withErrors('无权限访问');
        $user_info->delete();
        return json_encode([
            'result' => 'true',
            'msg' => 'success'
        ]);
    }

    public function userProfile(Request $request, $user_id)
    {
        $data = [];
        if($user_id == $request->session()->get('user_id'))
            return Redirect::to('/user');
        $user = User::find($user_id);
        if(!$user)
            return View::make('common.errorPage')->withErrors('用户ID错误！');
        $data['user'] = $user;
        $data['goods'] = GoodInfo::where('user_id', $user_id)->where('count', '>', 0)->where('baned', false)->paginate(15);
        $page = isset($request->page) ? $request->page : 1;
        $tickets = Ticket::where('receiver_id', $user_id)->where('type', 1)
            ->orWhere('receiver_id', $user_id)->where('type', 2)->where('state', 2)
            ->orderBy('id', 'desc')->get();

        $data['tickets'] = $tickets;
        return View::make('user.userProfile')->with($data);
    }

    public function getList(Request $request)
    {
        $data = [];
        $user_id = $request->session()->get('user_id');
        $data['user'] = User::with('wechat')->find($user_id);
        $data['userinfos'] = UserInfo::where('user_id', $user_id)->get();
        $data['tab'] = isset($request->tab) ? $request->tab : "profile";
        return View::make('user.user')->with($data);
    }

    public function editList(Request $request)
    {
        $input = $request->all();
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if (isset($input['nickname']))
            $user->nickname = $input['nickname'];
        $user->update();
        if ($request->hasFile('avatarPic'))
            Storage::put(
                'avatar/' . $user_id,
                Image::make($request->file('avatarPic'))->crop(round($input['crop_width']), round($input['crop_height']), round($input['crop_x']), round($input['crop_y']))->resize(800, 450)->encode('data-url')
            );
        return Redirect::to('/user');
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

    public function getAvatar(Request $request, $user_id, $width = 600, $height = 600)
    {
        if($width > 1920)
            $width = 1920;
        if($height > 1080)
            $height = 1080;
        if (!Storage::exists('avatar/' . $user_id))
            $file = Storage::get('public/avatar.jpg');
        else
            $file = Storage::get('avatar/' . $user_id);
        $image = Image::make($file)->resize($width, $height);
        return $image->response('jpg');
    }

    public function mygoods(Request $request)
    {
        $data = [];
        $user_id = $request->session()->get('user_id');
        $data['goods'] = GoodInfo::where('user_id', $user_id)->orderby('id', 'desc')->paginate(15);

        return view::make('user.seller.mygoods')->with($data);
    }

    public function sellerTrans(Request $request)
    {
        $data = [];
        $page = isset($request->page) ? $request->page : 1;
        $user_id = $request->session()->get('user_id');
        $trans = User::with(['trans' => function ($query) use($page) {
            $query->orderBy('id', 'desc')->offset(($page - 1) * 15)->limit(15);
        }, 'trans.good', 'trans.buyer'])->find($user_id)->trans;

        $data['trans'] = new Paginator($trans, 15, $page);
        return view::make('user.seller.sellerTrans')->with($data);
    }

    public function tickets(Request $request)
    {
        $data = [];
        $page = isset($request->page) ? $request->page : 1;
        $user_id = $request->session()->get('user_id');
        $tickets = Ticket::where('receiver_id', $user_id)->where('type', 1)
            ->orWhere('receiver_id', $user_id)->where('type', 2)->where('state', 2)
            ->orderBy('id', 'desc')->get();

        $data['tickets'] = $tickets;
        return view::make('user.seller.tickets')->with($data);
    }

    public function buyer(Request $request)
    {
        $data = [];
        $user_id = $request->session()->get('user_id');
        $data['trans'] = Transaction::with('feedback', 'good')->where('buyer_id', $user_id)->orderBy('id', 'desc')->paginate(15);
        return view::make('user.buyer')->with($data);
    }

	public function reportSeller(Request $request, $seller_id)
	{
		$data = [];
		$data['seller_id'] = $seller_id;
		return view::make('user.report')->with($data);
	}

	/*
	 * 评价type=1  举报type=2
	 * 发布未领取 assignee = false
	 * 已领取未处理 assignee = true, state=0
	 * 批准（显示在用户页）state=2 驳回 state=1
	 */
	public function sendRepo(Request $request, $seller_id)
	{
		$input = $request->all();
		$ticket = new Ticket;
		$ticket->sender_id = $request->session()->get('user_id');
		$ticket->receiver_id = $seller_id;
		$ticket->type = 2;
		$ticket->message = $input['reason'];
		$ticket->save();
		return view::make('common.errorPage')->withErrors('举报成功！管理员收到后会通过站内消息和您联系。');
	}
	/*type: 3 使用帮助 4 账号申诉 5 bug 反馈*/
	public function sendHelp(Request $request)
    {
        $input = $request->all();
        $ticket = new Ticket;
        $ticket->sender_id = $request->session()->get('user_id');
        $ticket->receiver_id = 0;
        $ticket->type = $input['type'];
        $ticket->message = $input['reason'];
        $ticket->save();
        if($ticket->type == 5) {
            $conn = new JsonRpcClient(env('MAIL_RPC_HOST', "127.0.0.1"), env('MAIL_RPC_PORT', 65525));
            $mailSettings = [];
            $mailSettings["Body"] = $ticket->message;
            $mailSettings["To"] = env("SUPPORT_MAIL_ADDRESS", "support@neup.market");
            $mailSettings["FromName"] = "先锋市场用户";
            $mailSettings["Subject"] = "【Bug/功能意见反馈】";
            $mailSettings["SendID"] = "service";
            $conn->Call("Daemon.SendMail", $mailSettings);
        }
        return view::make('common.errorPage')->withErrors('发送成功！管理员收到后会通过站内消息或您留下的联系方式和您联系。');
    }

	public function banPage(Request $request, $user_id)
	{
		$data = [];
		$data['user_id'] = $user_id;
		return view::make('user.banPage')->with($data);
	}

	public function setBan(Request $request, $user_id)
	{
		$input = $request->all();
		$user = User::find($user_id);
		$user->baned = 1;
		$user->banedtime = $input['count'];
		$user->banedstart = time();
		$user->update();

		$event = new AdminEvent;
		$event->admin_id = $request->session()->get('user_id');
		$event->target_user = $user_id;
		$event->event = "ban";
		$event->message = $input['reason'];
		$event->save();

		return Redirect::to('/user/'.$user_id);
	}

}
