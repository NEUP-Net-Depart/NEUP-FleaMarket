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

Route::get('/', function () {
    return view('welcome');
});

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

    Route::get('/good', [
        "uses" => "GoodController@getList",
        "middleware" => "auth"
    ]);

    Route::match(['post', 'get'], '/good/add', [
        "uses" => "GoodController@addGood",
        "middleware" => "auth"
    ]);

    Route::match(['post', 'get'], '/good/{good_id}/edit', [
        "uses" => "GoodController@editGood",
        "middleware" => "auth"
    ]);

    Route::get('/good/{good_id}/delete', [
        "uses" => "GoodController@deleteGood",
        "middleware" => "auth"
    ]);

    Route::get('/good/{good_id}', [
        "uses" => "GoodController@getInfo",
        "middleware" => "auth"
    ]);

    Route::get('/user/{user_id}', [
        "uses" => "UserController@getList",
        "middleware" => "auth"
    ]);

    Route::get('/user/{user_id}/edit', [
        "uses" => "UserController@showeditpage",
        "middleware" => "auth"
    ]);

    Route::post('/user/{user_id}/edit/middle', [
        "uses" => "UserController@editList",
        "middleware" => "auth"
    ]);

    Route::get('/good/quick_access', [
        "uses" => "GoodController@quickAccess",
        "middleware" => "auth"
    ]);

    Route::get('/good/{good_id}/check', [
        "uses" => "AdminController@checkGood",
        "middleware" => "auth"
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

});
Route::post('/adduser', [
    "uses" => "UserController@adduser",
    "middleware" => "web"
]);

Route::get('/show', [
    "uses" => "UserController@show",
    "middleware" => "web"
]);

Route::get('/register', [
    "uses" => "UserController@register",
    "middleware" => "web"
]);

Route::post('/login', [
    "uses" => "UserController@login",
    "middleware" => "web"
]);

