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

Route::get('frontend/first/first','Frontend\FirstController@first');

Route::any('user/login','Frontend\UserController@login');
Route::get('user/loginOut','Frontend\userController@loginOut');

Route::any('user/register','Frontend\UserController@register');
Route::post('user/userTel','Frontend\UserController@userTel');
Route::post('user/userEmail','Frontend\UserController@userEmail');

Route::post('user/werAdd', 'Frontend\UserController@werAdd');

Route::get('/message','Frontend\MessageController@message');

Route::any('mail/send','Frontend\MailController@send');
Route::get('user/getIP','Frontend\UserController@getIP');
Route::get('user/getAddress','Frontend\UserController@getAddress');

Route::any('Power/menuName','Backend\MenuController@menuName');
Route::any('Power/menuUrl','Backend\MenuController@menuUrl');

Route::any('Role/roleName','Backend\RoleController@roleName');

Route::any('backend/login','Backend\LoginController@login');
Route::any('backend/loginOut','Backend\LoginController@loginOut');

Route::any('Type/typeName','Backend\TypeController@typeName');
Route::any('Type/typeUrl','Backend\TypeController@typeUrl');

Route::any('Goods/goodsName','Backend\GoodsController@goodsName');
Route::any('Goods/goodsType','Backend\GoodsController@goodsType');
Route::any('Goods/goodsValue','Backend\GoodsController@goodsValue');
Route::any('Goods/getValue','Backend\GoodsController@getValue');

Route::any('Attr/attrName','Backend\AttrController@attrName');

Route::any('AttrValue/attrValueName','Backend\AttrValueController@attrValueName');


Route::group(['middleware' => ['power']], function () {
    Route::get('backend/home', 'Backend\HomeController@home');

    Route::any('Admin/add','Backend\AdminController@add');
    Route::any('Admin/showList','Backend\AdminController@showList');
    Route::any('Admin/del','Backend\AdminController@del');
    Route::any('Admin/upd','Backend\AdminController@upd');

    Route::any('Role/showList','Backend\RoleController@showList');
    Route::any('Role/add','Backend\RoleController@add');
    Route::any('Role/del','Backend\RoleController@del');
    Route::any('Role/upd','Backend\RoleController@upd');


    Route::any('Power/showList','Backend\MenuController@showList');
    Route::any('Power/add','Backend\MenuController@add');
    Route::any('Power/del','Backend\MenuController@del');
    Route::any('Power/upd','Backend\MenuController@upd');


    Route::any('Goods/add','Backend\GoodsController@add');
    Route::any('Goods/showList','Backend\GoodsController@showList');


    Route::any('Type/add','Backend\TypeController@add');
    Route::any('Type/showList','Backend\TypeController@showList');

    Route::any('Attr/showList','Backend\AttrController@showList');
    Route::any('Attr/add','Backend\AttrController@add');

    Route::any('AttrValue/add','Backend\AttrValueController@add');
    Route::any('AttrValue/showList','Backend\AttrValueController@showList');
});
//Route::any('Admin/upd','Backend\AdminController@upd');
Auth::routes();


