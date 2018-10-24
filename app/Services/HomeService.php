<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 10:53
 */
namespace App\Services;

use App\Models\AdminModel;
use App\Models\MenuModel;
use App\Models\RoleModel;
use Session;
class HomeService
{
    public $adminModel;
    public $roleModel;
    public $menuModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel('admin_user_role');
        $this->roleModel = new RoleModel('admin_role_resource');
        $this->menuModel = new MenuModel('admin_menu');
    }

    public function getAdminRole($data)
    {
        $info = "role_id";
        $where = ['user_id'=>$data['a_id']];
        $data = $this->adminModel->get($where,$info);
        $data = json_decode($data,true);
        return $data;
    }

    public function getMenuID($data)
    {
        $info = 'resource_id';
        $where = $data;
        $num = 'role_id';
        $whereTwo = ['type'=>1];
        $data = $this->roleModel->get($where,$info,$num,$whereTwo);
        $data = json_decode($data,true);
        return $data;
    }

    public function getButtonId($data)
    {
        $info = 'resource_id';
        $where = $data;
        $num = 'role_id';
        $whereTwo = ['type'=>0];
        $data = $this->roleModel->get($where,$info,$num,$whereTwo);
        $data = json_decode($data,true);
        return $data;
    }

    public function getMenu($data)
    {
        $where = $data;
        $info = 'menu_id';
        $data = $this->menuModel->getWhere($where,$info);
        $data = json_decode($data,true);
        return $data;
    }

    public function getMenuOver($data)
    {
        $data = $this->createTree($data);
        $data = $this->createMenus($data);
        return $data;
    }

    public function getButton($where)
    {
        $info = 'menu_id';
        $data = $this->menuModel->getWhere($where,$info);
        $data = json_decode($data,true);
        return $data;
    }

    public function createTree($data,$parent_id = 0 ,$level = 0)
    {
        $tree = [];
        foreach ($data as $key => $value)
        {
            if($value['p_id'] == $parent_id)
            {
                $value['level'] = $level;
                $value['son'] = $this->createTree($data,$value['menu_id'],$level+1);
                $tree[] = $value;
            }
        }
        return $tree;
    }

    public function createMenus($data)
    {
        foreach ($data as $key => $value)
        {
            $menu[$key] = ['text'=>$value['menu_name'],'url'=>$value['url'],'icon'=>'user','level'=>$value['level']];
            foreach ($value['son'] as $k => $item)
            {
                $menu[$key]['submenu'][] =
                    ['text'=>$item['menu_name'],
                        'url'=>$item['url'],'level'=>$item['level']];
            }
        }
        return $menu;
    }

    public function power($path)
    {
        $user_info = Session::get('user_info');
        //$homeService = new HomeService();//实例化service
        $role_id = $this->getAdminRole($user_info);//通过登陆的管理员ID获取一个二维的管理员所拥有的角色ID
        $role_id = array_column($role_id,'role_id');//把得到的二维数组转换成一维数组

        $resource_id = $this->getMenuID($role_id);//通过角色id获取菜单id

        $button = $this->getButtonId($role_id);//获取按钮id
        //dd($resource_id);
        $menu_id = array_column($resource_id,'resource_id');//数组转换

        $button_id = array_column($button,'resource_id');//数组转换

        $menu = $this->getMenu($menu_id);//通过获取的菜单id得到菜单

        $menuData = $this->getMenuOver($menu);

        $button = $this->getButton($button_id);//获取按钮权限

        $button_url = array_column($button,'url');

        $menu_url = array_column($menu,'url');

        $url = array_merge($button_url,$menu_url);
        //dd($button);
        //dd($menu);
        Session::put('button',$button);
        Session::put('menu',$menuData);

        return  in_array($path,$url)?true:false;
    }
}