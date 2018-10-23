<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/20
 * Time: 9:12
 */
namespace App\Services;

use App\Models\MenuModel;
use Illuminate\Support\Facades\DB;

class PowerServices
{
    public $AdminMenu;

    public function __construct()
    {
        $this->AdminMenu = new MenuModel('admin_menu');
    }

    public function getAll()
    {
        $data = $this->AdminMenu->getAll();
        $data = json_decode($data,true);
        $data = $this->creatTree($data);
        //dd($data);
        return $data;
    }

    public function creatTree($data,$parent_id = 0 ,$level = 0 ,$html = '|--')
    {
        $tree = [];
        foreach ($data as $key => $value)
        {
            if($value['p_id'] == $parent_id)
            {
                $value['level'] = $level;
                $value['html'] = $html;
                $value['son'] = $this->creatTree($data,$value['menu_id'],$level+1,$html.'|--');
                $tree[] = $value;
            }
        }
        return $tree;
    }

    public function getMenuName($data)
    {
        $where = ['menu_name'=>$data];
        $result = $this->AdminMenu->getMenu($where);
        if($result)
        {
            echo 2;
        }
        else
        {
            echo 3;
        }
    }
    public function getUrl($data)
    {
        $where = ['url'=>$data];
        $result = $this->AdminMenu->getUrl($where);
        if($result)
        {
            echo 2;
        }
        else
        {
            echo 3;
        }
    }
    public function getLastId($where)
    {
        $result = $this->AdminMenu->getLastId($where);
        return $result;
    }

    public function insertOne($data)
    {
        $result = $this->AdminMenu->insertOne($data);
        return $result;
    }

    public function getOne($where)
    {
        $data = $this->AdminMenu->getOne($where);
        return $data;
    }
    public function deleteOne($data)
    {
        $result = true;
        DB::beginTransaction();
        try{
            $result = $this->AdminMenu->deleteOne($data);
            DB::commit();
        }catch (\Exception $exception) {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }
    public function delSonAndFather($data,$p_id)
    {
        $result = true;
        DB::beginTransaction();
        try{
            $result = $this->AdminMenu->delSonandFather($data,$p_id);
            DB::commit();
        }catch (\Exception $exception) {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }
    public function upd($data,$id)
    {
        $where = ['menu_id'=>$id];
        $result = $this->AdminMenu->upd($data,$where);
        return $result;
    }
}