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
        Route::post('/login', "AuthController@login");
        Route::get('/register', "AuthController@showRegister");
        Route::post('/register', "AuthController@register");

        Route::get('/user/{user_id}/sendCheckLetter', "AuthController@sendCheckLetter");
        Route::get('/user/checkEmail/{token}', "AuthController@checkEmail");

        Route::get('/iforgotit', "AuthController@showPasswordForget");
        Route::post('/iforgotit', "AuthController@sendPasswordResetMail");
        Route::get('/passwordReset/{token}', "AuthController@showPasswordReset");
        Route::post('/passwordReset/{token}', "AuthController@resetPassword");
    });

    Route::get('/logout', "AuthController@logOut")->middleware('auth');

    //------Above are tested function

    Route::get('/register/2', "UserController@showCompleteInfo")->middleware('auth');
    Route::post('/register/2', "UserController@completeInfo")->middleware('auth');

    Route::get('/avatar/{user_id}', [
        "uses" => "UserController@getSimpleAvatar",
    ]);

    Route::get('/avatar/{user_id}/{width}/{height}', [
        "uses" => "UserController@getAvatar",
    ]);

    Route::get('/user/{user_id}/edit', [
        "uses" => "UserController@showEditPage",
        "middleware" => "auth"
    ]);

    Route::post('/user/{user_id}/edit/middle', [
        "uses" => "UserController@editList",
        "middleware" => "auth"
    ]);

    Route::get('/user/get_favlist', [
        "uses" => "UserController@getFavlist",
        "middleware" => "auth"
    ]);

    Route::get('/user/edit_favlist', [
        "uses" => "UserController@editFavlist",
        "middleware" => "auth"
    ]);

    Route::delete('/user/del_favlist', [
        "uses" => "UserController@delFavlist",
        "middleware" => "auth"
    ]);

    Route::get('/user/{user_id}', [
        "uses" => "UserController@getList",
        "middleware" => "auth"
    ]);

    Route::get('/', [
        "uses" => "ContentController@Mainpage",
    ]);

    Route::get('/announcement/{announcement_id}', [
        "uses" => "ContentController@announcementPage",
    ]);

    Route::get('/good', [
        "uses" => "GoodController@getList",
    ]);

    Route::get('/good/{good_id}', [
        "uses" => "GoodController@getInfo",
    ]);

    Route::match(['post', 'get'], '/good/add', [
        "uses" => "GoodController@addGood",
        "middleware" => "auth"
    ]);

    Route::match(['post', 'get'], '/good/my', [
        "uses" => "GoodController@myGood",
        "middleware" => "auth"
    ]);

    Route::match(['post', 'get'], '/good/check', [
        "uses" => "GoodController@check",
        "middleware" => "auth"
    ]);

    Route::match(['post', 'get'], '/good/end', [
        "uses" => "GoodController@end",
        "middleware" => "auth"
    ]);
    
    Route::match(['post', 'get'], '/good/{good_id}/edit', [
        "uses" => "GoodController@editGood",
        "middleware" => "auth"
    ]);

    Route::delete('/good/{good_id}/delete', [
        "uses" => "GoodController@deleteGood",
        "middleware" => "auth"
    ]);

    Route::post('/good/{good_id}/buy', [
        "uses" => "GoodController@getGood",
        "middleware" => "auth"
    ]);

    Route::post('/good/{trans_id}/allow', [
        "uses" => "GoodController@allow",
        "middleware" => "auth"
    ]);

    Route::get('/good/{good_id}/titlepic', [
        "uses" => "GoodController@getSimpleTitlePic",
    ]);

    Route::get('/good/{good_id}/titlepic/{width}/{height}', [
        "uses" => "GoodController@getTitlePic",
    ]);

	Route::get('/good/{good_id}/add_favlist', [
		"uses" => "GoodController@addFavlist",
		"middleware" => "auth"
	]);

	Route::delete('/good/{good_id}/del_favlist', [
		"uses" => "GoodController@delFavList",
		"middleware" => "auth"
	]);

    Route::get('/good/{good_id}/check', [
        "uses" => "AdminController@checkGood",
        "middleware" => "admin"
    ]);

    Route::get('/admin', [
        "uses" => "AdminController@adminIndex",
        "middleware" => "admin"
    ]);

    Route::post('/user/{user_id}/updatePriv', [
        "uses" => "AdminController@updateUserPriv",
        "middleware" => "admin"
    ]);

    Route::post('/user/{user_id}/updateRole', [
        "uses" => "AdminController@updateUserRole",
        "middleware" => "admin"
    ]);

    Route::post('/cat/{cat_id}/edit', [
        "uses" => "AdminController@editCategory",
        "middleware" => "admin"
    ]);

    Route::post('/cat/{cat_id}/edit', [
        "uses" => "AdminController@editCategory",
        "middleware" => "admin"
    ]);

    Route::delete('/cat/{cat_id}/delete', [
        "uses" => "AdminController@deleteCategory",
        "middleware" => "admin"
    ]);

    Route::match(['post','get'],'/message',[
        "uses" => "MessageController@getMessage",
        "middleware" => "auth"
    ]);

    Route::match(['post','get'],'/message/sendmessagepage',[
        "uses" => "MessageController@sendMessagepage",
        "middleware" => "auth"
    ]);

    Route::match(['post','get'],'/message/send',[
        "uses" => "MessageController@sendAllow",
        "middleware" => "auth"
    ]);

    Route::match(['post','get'],'/message/editmessage',[
        "uses" => "MessageController@editMessagepage",
        "middleware" => "auth"
    ]);

    Route::match(['post','get'],'/message/deletemessage/{message_id}',[
        "uses" => "MessageController@deleteMessage",
        "middleware" => "auth"
    ]);

    Route::match(['post','get'],'/sendannouncement',[
        "uses" => "AdminController@sendAnnouncement",
        "middleware" => "admin"
    ]);

    Route::match(['post','get'],'/sendannouncement/send',[
        "uses" => "AdminController@checkAnnouncement",
        "middleware" => "admin"
    ]);

    Route::match(['post','get'],'/announcement',[
        "uses" => "AdminController@getAnnouncement",
        "middleware" => "auth"
    ]);
});
