<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 10:51
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\HomeService;
use Session;
class HomeController extends Controller
{
    public function home()
    {
        if($user_info = Session::get('user_info'))
        {
            /*$homeService = new HomeService();//实例化service
            $role_id = $homeService->getAdminRole($user_info);//通过登陆的管理员ID获取一个二维的管理员所拥有的角色ID
            $role_id = array_column($role_id,'role_id');//把得到的二维数组转换成一维数组

            $resource_id = $homeService->getMenuID($role_id);//通过角色id获取菜单id

            $button = $homeService->getButtonId($role_id);//获取按钮id
            //dd($resource_id);
            $menu_id = array_column($resource_id,'resource_id');//数组转换

            $button_id = array_column($button,'resource_id');//数组转换

            $menu = $homeService->getMenu($menu_id);//通过获取的菜单id得到菜单

            $button = $homeService->getButton($button_id);//获取按钮权限
            //dd($button);
            //dd($menu);
            Session::put('button',$button);
            Session::put('menu',$menu);*/


            return  view('backend.home.home') ;

        }
        else
        {
            return redirect('/message')->
            with(['message'=>'请先登录!','url' =>'/backend/login', 'jumpTime'=>3,'status'=>false]);
        }

    }
}