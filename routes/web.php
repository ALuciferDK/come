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
Route::get('/admin','Frontend\IndexController@index');
Route::get('/show','Frontend\IndexController@show');

Route::resource('admin','Frontend\IndexController');

Route::get('first/first','Frontend\FirstController@first');

Route::any('user/login','Frontend\UserController@login');
Route::get('user/loginOut','Frontend\userController@loginOut');

Route::any('user/register','Frontend\UserController@register');
Route::post('user/userTel','Frontend\UserController@userTel');
Route::post('user/userEmail','Frontend\UserController@userEmail');

Route::post('user/werAdd', 'Frontend\UserController@werAdd');

Route::get('/message','Frontend\MessageController@message');

Route::any('mail/send','Frontend\MailController@send');
Route::get('user/getIP','Frontend\UserController@getIP');
Route::get('user/getAddress','Frontend\UserController@getAddress');//ssssssssssssssssssssssssss

Route::any('backend/login','Backend\LoginController@login');
Route::any('backend/loginOut','Backend\LoginController@loginOut');
Route::group(['middleware' => ['power']], function () {
    Route::get('backend/home', 'Backend\HomeController@home');
    Route::any('Admin/add','Backend\AdminController@add');
    Route::any('Admin/showList','Backend\AdminController@showList');
    Route::any('Admin/Admin/del','Backend\AdminController@del');
    Route::any('Admin/Admin/upd','Backend\AdminController@upd');

    Route::any('Role/showList','Backend\RoleController@showList');
    Route::any('Role/add','Backend\RoleController@add');
    Route::any('Role/Role/del','Backend\RoleController@del');
    Route::any('Role/Role/upd','Backend\RoleController@upd');
    Route::any('Role/roleName','Backend\RoleController@roleName');

    Route::any('Power/showList','Backend\MenuController@showList');
    Route::any('Power/add','Backend\MenuController@add');
    Route::any('Power/Menu/del','Backend\MenuController@del');
    Route::any('Power/Menu/upd','Backend\MenuController@upd');
    Route::any('Power/menuName','Backend\MenuController@menuName');
    Route::any('Power/menuUrl','Backend\MenuController@menuUrl');
});
//Route::any('Admin/upd','Backend\AdminController@upd');
Auth::routes();


