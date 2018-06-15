<?php
namespace App\Http\Controllers;

use App\GoodTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\GoodCat;
use App\GoodInfo;
use App\User;
use App\Announcement;
use App\Http\Controllers\Controller;
use App\Ticket;
use JsonRpcClient;
use App\Transaction;
use App\Tag;
use Mews\Purifier\Purifier;

class AdminController extends Controller
{
    /**
     * @function AdminController@adminIndex
     * @input Request $request
     * @return View
     * @description The Index of administrator.
     */
	public function adminIndex(Request $request, $tab = 'notice')
	{
		$data = [];
		$data['goods'] = GoodInfo::where('baned', '1')->orderby('id', 'asc')->get();
		$data['users'] = User::orderby('id', 'asc')->get();
		$data['announcements'] = Announcement::orderby('id', 'dsc')->get();
		$data['reports'] = Ticket::where('type', '2')->orWhere('type', '3')->orWhere('type', '4')->orWhere('type', '5')->orderby('id', 'dsc')->paginate(40);
		$data['users'] = User::orderby('id', 'asc')->paginate(40);
		$data['trans'] = Transaction::orderby('id', 'asc')->paginate(40);
		return View::make('admin.'.$tab)->with($data);
	}

	public function userSearch(Request $request, $tab = 'userlist')
	{
		$input = $request->all();
		$data = [];
		$data['goods'] = GoodInfo::where('baned', '1')->orderby('id', 'asc')->get();
		$data['users'] = User::orderby('id', 'asc')->get();
		$data['announcements'] = Announcement::orderby('id', 'dsc')->get();
		$data['reports'] = Ticket::where('type', '2')->orWhere('type', '3')->orWhere('type', '4')->orWhere('type', '5')->orderby('id', 'dsc')->paginate(40);
		$data['users'] = User::where('stuid', $input['searchid'])->orderby('id', 'asc')->paginate(40);
		$data['trans'] = Transaction::orderby('id', 'asc')->paginate(40);
		return View::make('admin.'.$tab)->with($data);
    }

    /**
     * @function AdminController@checkGood
     * @input Request $request, $good_id
     * @return Redirect
     * @description Check a specify good.
     */
    public function checkGood(Request $request, $good_id)
    {
        $good = GoodInfo::find($good_id);
        $good->baned = 0;
        $good->update();
        return Redirect::to('/admin');
    }

    /**
     * @function AdminController@updateUserPriv
     * @input Request $request, $user_id
     * @return Redirect
     * @description Update the priviledge of a specify user.
     */
    public function updateUserPriv(Request $request, $user_id)
    {
        $input = $request->all();
        $user = User::find($user_id);
        $user->privilege = $input['privilege'];
        $user->update();
        return Redirect::to('/admin');
    }

    /**
     * @function AdminController@updateUserRole
     * @input Request $request, $user_id
     * @return Redirect
     * @description Update the role id of a specify user.
     */
    public function updateUserRole(Request $request, $user_id)
    {
        $input = $request->all();
        $user = User::find($user_id);
        $user->role_id = $input['role_id'];
        $user->update();
        return Redirect::to('/admin');
    }

    public function getCategory(Request $request)
    {
        $data['cats'] = GoodCat::orderby('cat_name', 'asc')->get();
        return json_encode($data);
    }

    /**
     * @function AdminController@addCategory
     * @input Request $request
     * @return Redirect
     * @description Add a new category.
     */
    public function addCategory(Request $request)
    {
        $input = $request->all();
        $cat = new GoodCat;
        $cat->cat_name = $input['cat_name'];
        $cat->save();
        return json_encode([ 'result' => true, 'data' => $cat ]);
    }

    /**
     * @function AdminController@editCategory
     * @input Request $request, $cat_id
     * @return Redirect
     * @description Edit a specify category.
     */
    public function editCategory(Request $request)
    {
        $input = $request->all();
        if(count($input['cats']) <= 1) {
            foreach ($input['cats'] as $cat_id) {
                $cat = GoodCat::find($cat_id);
                $cat->cat_name = $input['cat_name'];
                $cat->save();
            }
        } else {
            $cat = new GoodCat;
            $cat->cat_name = $input['cat_name'];
            $cat->save();
            $goods = GoodInfo::whereIn('cat_id', $input['cats'])->get();
            foreach ($goods as $good) {
                $good->cat_id = $cat->id;
                $good->save();
            }
            GoodCat::whereIn('id', $input['cats'])->delete();
        }
        return json_encode([ 'result' => true, 'data' => $input['cats'] ]);
    }

    public function getTag(Request $request)
    {
        $input = $request->all();
        $cat_id = $input['good_cat_id'];
        $data['tags'] = Tag::where('good_cat_id', $cat_id)->get();
        return json_encode($data);
    }

    public function addTag(Request $request)
    {
        $input = $request->all();
        $tag_name = $input['tag_name'];
        $cat_id = $input['good_cat_id'];
        $tag = Tag::firstOrCreate(['tag_name' => $tag_name, 'good_cat_id' => $cat_id]);
        return json_encode([ 'result' => true, 'data' => $tag ]);
    }

    public function editTag(Request $request)
    {
        $input = $request->all();
        if(count($input['tags']) <= 1) {
            foreach ($input['tags'] as $tag_id) {
                $tag = Tag::find($tag_id);
                $tag->tag_name = $input['tag_name'];
                $tag->save();
            }
        } else {
            $tag = new Tag();
            $tag->tag_name = $input['tag_name'];
            $tag->good_cat_id = $input['good_cat_id'];
            $tag->save();
            $good_tags = GoodTag::whereIn('tag_id', $input['tags'])->get();
            foreach ($good_tags as $good_tag) {
                $good_tag->tag_id = $tag->id;
                $good_tag->save();
            }
            Tag::whereIn('id', $input['tags'])->delete();
        }
        return json_encode([ 'result' => true, 'data' => $input['tags'] ]);
    }

    /**
     * @function AdminController@sendAnnouncement
     * @input Request $request
     * @return View
     * @description admin send annoucement.
     */

     public function sendAnnouncement(Request $request)
     {
        $input = $request->all();
        $announcement = new Announcement;
        $announcement->title = $input['title'];
        $announcement->content = clean($input['content']);
		$announcement->save();
        return Redirect::to('/admin');
	 }

	public function delAnnouncement(Request $request, $ann_id)
	{
		$ann = Announcement::find($ann_id);
		$ann->delete();
		return Redirect::to('/admin');
	}

	public function assignReport(Request $request, $repo_id)
    {
        $user_id = $request->session()->get('user_id');
        $repo = Ticket::find($repo_id);
        $repo->assignee = $user_id;
        $repo->state = 0;
        $repo->save();
        if($repo->type == 2) {
            $sender = User::find($repo->sender_id);
            $msg = "【系统消息】您好！您的举报（编号：" . $repo_id . "）已由管理员（ID: " . $user_id . "）受理。请协助管理员核实举报具体细节。";
            $result = MessageController::sendMessageHandle($user_id, $repo->sender_id, $msg);

            if ($result['result']) {
                if($sender->wechat_open_id) {
                    XMSHelper::sendSysMessage($sender->wechat_open_id, $result['msg']);
                    $result['msg']->wx_sent = true;
                    $result['msg']->save();
                }
                return Redirect::to('/message');
            }
            else
                return View::make('common.errorPage')->withErrors($result->msg);
        } else {
            return Redirect::to('/message/startConversation/' . $repo->sender_id);
        }
    }

	public function solveReport(Request $request, $repo_id)
	{
		$input = $request->all();
		$repo = Ticket::find($repo_id);
		if($repo->assignee == $request->session()->get('user_id')) {
            $repo->state = $input['setstate'];
            $repo->update();
        }
		return Redirect::to('/admin/report');
	}

	// This part gonna work with https://github.com/NEUP-Net-Depart/email-daemon/
	public function testEmail(Request $request)
    {
        $conn = new JsonRpcClient("127.0.0.1", 65525);
        $mailSettings = [];
        $mailSettings["Body"] = view('auth.checkLetter')->with(['host' => $request->server("HTTP_HOST"), 'token' => "sometesttokenhhhh"])->render();
        $mailSettings["To"] = "wangkule@cool2645.com";
        $mailSettings["FromName"] = "先锋市场";
        $mailSettings["Subject"] = "PHP 邮件测试";
        $mailSettings["SendID"] = "notify";
        $response = $conn->Call("Daemon.SendMail", $mailSettings);
        return $response;
    }

}
