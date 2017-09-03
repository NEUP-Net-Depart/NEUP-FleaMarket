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
        $data['cats'] = GoodCat::orderby('cat_name', 'asc')->get();
        $data['goods'] = GoodInfo::where('baned', '1')->orderby('id', 'asc')->get();
        $data['users'] = User::orderby('id', 'asc')->get();
		$data['announcements'] = Announcement::orderby('id', 'dsc')->get();
		$data['reports'] = Ticket::where('type', '2')->orWhere('type', '3')->orWhere('type', '4')->orWhere('type', '5')->orderby('id', 'dsc')->paginate(40);
		$data['users'] = User::orderby('id', 'asc')->paginate(40);
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
        return Redirect::to('/admin/classify');
    }

    /**
     * @function AdminController@deleteCategory
     * @input Request $request, $cat_id
     * @return Redirect
     * @description Delete a specify category.
     */
    public function deleteCategory(Request $request, $cat_id)
    {
        $cat = GoodCat::find($cat_id);
        $cat->delete();
        return Redirect::to('/admin/classify');
    }

    /**
     * @function AdminController@editCategory
     * @input Request $request, $cat_id
     * @return Redirect
     * @description Edit a specify category.
     */
    public function editCategory(Request $request, $cat_id)
    {
        $input = $request->all();
        $cat = GoodCat::find($cat_id);
        $cat->cat_name = $input['cat_name'];
        $cat->update();
        return Redirect::to('/admin/classify');
    }

    public function mergeCategory(Request $request)
    {
        $input = $request->all();
        $base = $input['base_cat'];
        $head = $input['head_cat'];
        // Head cat will be terminated and all good of head cat will be catted base cat.
        GoodInfo::where('good_cat', $head)
            ->update(['good_cat' => $base]);
        GoodCat::destroy($head);
        return Redirect::to('/admin/classify');
    }

    public function addTag(Request $request)
    {
        $input = $request->all();
        $tag_name = $input['tag_name'];
        $cat_id = $input['cat_id'];
        Tag::firstOrCreate(['tag_name' => $tag_name, 'good_cat_id' => $cat_id]);
        return Redirect::to('/admin/classify');
    }

    public function editTag(Request $request, $tag_id)
    {
        $input = $request->all();
        $tag = Tag::find($tag_id);
        $tag->tag_name = $input['tag_name'];
        $tag->update();
        return Redirect::to('/admin/classify');
    }

    public function deleteTag(Request $request, $tag_id)
    {
        Tag::destroy($tag_id);
        GoodTag::where('tag_id', $tag_id)->delete();
        return Redirect::to('/admin/classify');
    }

    public function mergeTag(Request $request)
    {
        $input = $request->all();
        $base = $input['base_tag'];
        $head = $input['head_tag'];
        // Head tag will be terminated and all good of head tag will be tagged base tag.
        GoodTag::where('tag_id', $head)
            ->update(['tag_id' => $base]);
        Tag::destroy($head);
        return Redirect::to('/admin/classify');
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
