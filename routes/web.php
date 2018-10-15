<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin','Admin\IndexController@index');
Route::get('/show','Admin\IndexController@show');

Route::resource('admin','Admin\IndexController');

Route::get('first/first','Admin\FirstController@first');

Route::any('user/login','Admin\UserController@login');
Route::get('user/loginOut','Admin\userController@loginOut');

Route::any('user/register','Admin\UserController@register');
Route::post('user/userTel','Admin\UserController@userTel');
Route::post('user/userEmail','Admin\UserController@userEmail');

Route::post('user/werAdd', 'Admin\UserController@werAdd');

Route::get('/message','Admin\MessageController@message');

Route::any('mail/send','Admin\MailController@send');
Route::get('user/getIP','Admin\UserController@getIP');
Route::get('user/getAddress','Admin\UserController@getAddress');//ssssssssssssssssssssssssss
