<?php
namespace App\Http\Controllers;

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

class AdminController extends Controller
{
    /**
     * @function AdminController@adminIndex
     * @input Request $request
     * @return View
     * @description The Index of administrator.
     */
    public function adminIndex(Request $request)
    {
        $data = [];
        $data['goods'] = GoodInfo::where('baned', '1')->orderby('id', 'asc')->get();
        $data['users'] = User::orderby('id', 'asc')->get();
        $data['cats'] = GoodCat::orderby('cat_name', 'asc')->get();
		$data['announcements'] = Announcement::orderby('id', 'dsc')->get();
		$data['reports'] = Ticket::where('type', '2')->orderby('id', 'dsc')->paginate(16);
        return View::make('admin.index')->with($data);
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
        $user->priviledge = $input['priviledge'];
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
        return Redirect::to('/admin');
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
        return Redirect::to('/admin');
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
        return Redirect::to('/admin');
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
        $announcement->content = $input['content'];
		$announcement->save();
        return Redirect::to('/admin');
	 }

	public function delAnnouncement(Request $request, $ann_id)
	{
		$ann = Announcement::find($ann_id);
		$ann->delete();
		return Redirect::to('/admin');
	}

	public function solveReport(Request $request, $repo_id)
	{
		$input = $request->all();
		$repo = Ticket::find($repo_id);
		$repo->state = $input['setstate'];
		$repo->update();
		return Redirect::to('/admin');
	}

    /**
     * @function AdminController@getAnnouncement
     * @input Request $request
     * @return Redirect
     * @description a function get announcement
     */

/*     public function getAnnouncement(Request $request)
     {
        $data = [];
        $data['announcements'] = Announcement::Orderby('id','dsc')->get();
        return View::make('admin.announcement')->with($data);
	} */

}
