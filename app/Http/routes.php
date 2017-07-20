<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']],function () {

    Route::group(['middleware' => ['authredirect']], function() {
        Route::get('/login', "AuthController@showLogin");
        Route::get('/sso', "AuthController@cas");
        Route::get('/wx', "AuthController@wx");
        Route::post('/login', "AuthController@login");
        Route::get('/register', "AuthController@showRegister");
        Route::post('/register', "AuthController@register");

        Route::get('/iforgotit', "AuthController@showPasswordForget");
        Route::post('/iforgotit', "AuthController@sendPasswordResetMail");
        Route::get('/passwordReset/{token}', "AuthController@showPasswordReset");
        Route::post('/passwordReset/{token}', "AuthController@resetPassword");
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/user',"UserController@getList");
        Route::post('/user',"UserController@editList");
        Route::post('/user/edit/username', "AuthController@setUsername");
        Route::post('/user/edit/stuid', "AuthController@setStuid");
        Route::post('/user/edit/email', "AuthController@setEmail");
        Route::post('/user/edit/password', "AuthController@setPassword");

        Route::get('/user/userinfo/edit/{userinfo_id}', "UserController@editUserInfo");
        Route::put('/user/userinfo/edit', "UserController@updateUserInfo");
        Route::delete('/user/userinfo/delete', "UserController@deleteUserInfo");

        Route::get('/logout', "AuthController@logOut");

        Route::get('/register/2', "UserController@showCompleteUser");
        Route::post('/register/2', "UserController@completeUser");
        Route::get('/register/3', "UserController@regUserInfo");
        Route::get('/register/4', "UserController@completeAccount");

        Route::get('/user/userinfo', "UserController@userInfo");
        Route::get('/user/userinfo/create', "UserController@createUserInfo");
        Route::post('/user/userinfo', "UserController@storeUserInfo");

        Route::get('/user/fav', "UserController@getFavlist");
        Route::get('/user/fav/edit', "UserController@editFavlist");
        Route::delete('/user/fav/del', "UserController@delFavlist");

        Route::get('/message/getHistoryMessageContact', "MessageController@getHistoryMessageContact");
        Route::get('/message/getNewMessageContact', "MessageController@getNewMessageContact");
        Route::get('/message/getHistoryMessage', "MessageController@getHistoryMessage");
        Route::get('/message/getNewMessage', "MessageController@getNewMessage");
		Route::get('/message/startConversation/{receiver}', "MessageController@startConversation");
        Route::get('/message/closeConversation/{receiver}', "MessageController@closeConversation");
	});

	Route::get('/user/{user_id}/banpage', "UserController@banPage")->middleware('admin');
	Route::post('/setBan/{user_id}', "UserController@setBan")->middleware('admin');

    Route::get('/user/sell', "UserController@mygoods")->middleware('auth');
    Route::get('/user/sell/trans', "UserController@sellerTrans")->middleware('auth');
    Route::get('/user/sell/tickets', "UserController@tickets")->middleware('auth');
    Route::get('/user/trans', "UserController@buyer")->middleware('auth');
	Route::get('/comment/{trans_id}', "TransactionController@comment")->middleware('auth');
	Route::post('/sendComment/{trans_id}', "TransactionController@sendComment")->middleware('auth');

    Route::get('/user/checkEmail/{token}', "AuthController@checkEmail");
    Route::get('/user/unbindEmail/{token}', "AuthController@unbindEmail");
    Route::get('/user/{user_id}/sendCheckLetter', "AuthController@sendCheckLetter");

    Route::get('/user/{user_id}',"UserController@userProfile");

    Route::get('/avatar/{user_id}', "UserController@getAvatar");
    Route::get('/avatar/{user_id}/{width}/{height}', "UserController@getAvatar");

	Route::get('/report/{seller_id}', "UserController@reportSeller")->middleware('auth');
	Route::post('/sendRepo/{seller_id}', "UserController@sendRepo");
    Route::post('/repo/{repo_id}/assign', "AdminController@assignReport")->middleware('admin');
	Route::post('/repo/{repo_id}/solve', "AdminController@solveReport")->middleware('admin');

    Route::get('/good', "GoodController@getList");

    Route::get('/good/add', "GoodController@showAddGood")->middleware('regc');
    Route::post('/good/add', "GoodController@addGood")->middleware('auth');

    Route::get('/good/{good_id}', "GoodController@getInfo");
    Route::get('/good/{good_id}/edit', "GoodController@showEditGood")->middleware('auth');
    Route::post('/good/{good_id}/edit', "GoodController@editGood")->middleware('auth');
	Route::post('/good/{good_id}/ban', "GoodController@banGood")->middleware('admin');

    Route::delete('/good/{good_id}/delete', "GoodController@deleteGood")->middleware('auth');

    Route::get('/good/{good_id}/titlepic', "GoodController@getTitlePic");
    Route::get('/good/{good_id}/titlepic/{width}/{height}', "GoodController@getTitlePic");

    Route::post('/good/{good_id}/add_favlist', "GoodController@addFavlist")->middleware('auth');
    Route::delete('/good/{good_id}/del_favlist', "GoodController@delFavList")->middleware('auth');

    Route::post('/good/{good_id}/buy', "TransactionController@add")->middleware('regc');

    Route::get('/message', "MessageController@showMessageView")->middleware('auth');
    Route::get('/test/sendmessagepage', "MessageController@sendMessagepage")->middleware('su');
    Route::post('/message', "MessageController@sendMessage")->middleware('auth');
    Route::get('/message/num', "MessageController@getUnreadMsgNum")->middleware('auth');
    Route::delete('/message/{id}', "MessageController@deleteMessage")->middleware('auth');

    Route::get('/trans/{trans_id}', "TransactionController@showTrans")->middleware('auth');
    Route::delete('/trans/{trans_id}/cancel', "TransactionController@cancel")->middleware('auth');
    Route::post('/trans/{trans_id}/confirm', "TransactionController@go")->middleware('auth');
    Route::put('/trans/{trans_id}/edit', "TransactionController@edit")->middleware('auth');

    Route::get('/', "ContentController@Mainpage");

    Route::get('/notice/{notice_id}', "ContentController@announcementPage");
    Route::post('/cat/add', "AdminController@addCategory")->middleware('admin');
    Route::post('/cat/{cat_id}/edit', "AdminController@editCategory")->middleware('admin');
    Route::delete('/cat/{cat_id}/delete', "AdminController@deleteCategory")->middleware('admin');
    Route::post('/notice', "AdminController@sendAnnouncement")->middleware('admin');
    Route::delete('/notice/{ann_id}', "AdminController@delAnnouncement")->middleware('admin');

    Route::get('/admin', "AdminController@adminIndex")->middleware('admin');
    Route::get('/test/email', "AdminController@testEmail")->middleware('su');

    Route::post('/user/{user_id}/updatePriv', [
        "uses" => "AdminController@updateUserPriv",
        "middleware" => "su"
    ]);

    Route::post('/user/{user_id}/updateRole', [
        "uses" => "AdminController@updateUserRole",
        "middleware" => "admin"
    ]);

    Route::get('/tos', "ContentController@tos");
    Route::get('/pp', "ContentController@pp");
    Route::get('/faq', "ContentController@faq");

});
