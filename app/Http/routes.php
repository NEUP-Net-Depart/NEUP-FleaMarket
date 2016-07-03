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

Route::group(['middleware' => ['web']], function () {
    //
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

Route::get('/good', [
    "uses" => "GoodController@getList",
    "middleware" => "web"
]);

Route::match(['post', 'get'], '/good/add', [
    "uses" => "GoodController@addGood",
    "middleware" => "web"
]);

Route::match(['post', 'get'], '/good/{good_id}/edit', [
    "uses" => "GoodController@editGood",
    "middleware" => "web"
]);

Route::get('/good/{good_id}/delete', [
    "uses" => "GoodController@deleteGood",
    "middleware" => "web"
]);

Route::get('/good/{good_id}', [
    "uses" => "GoodController@getInfo",
    "middleware" => "web"
]);
Route::get('/good/quick_access', [
	"uses" => "GoodController@quickAccess"
]);
