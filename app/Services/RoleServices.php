<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/20
 * Time: 8:51
 */
namespace App\Services;

use App\Models\RoleModel;
use Illuminate\Support\Facades\DB;

class RoleServices
{
    public $AdminRole;
    public $AdminRoleResource;

    public function __construct()
    {
        $this->AdminRole = new RoleModel('admin_role');
        $this->AdminRoleResource = new RoleModel('admin_role_resource');
    }

    public function getAllPage()
    {
        $data = $this->AdminRole->getAllPage();
        return $data;
    }

    public function getAll()
    {
        $data = $this->AdminRole->getAll();
        return $data;
    }

    public function getOne($data)
    {
        $result = $this->AdminRole->getOne($data);
        if($result)
        {
            echo 2;
        }
        else
        {
            echo 3;
        }
    }

    public function addRole($data)
    {
        $result = true;
        $role = ['role_name'=>$data['rolename']];
        DB::beginTransaction();
        try{
            $id = $this->AdminRole->insertRoleId($role);
            foreach ($data['menus'] as $key => $value) {
                $updateData[$key] = ['role_id'=>$id,'resource_id'=>$value];
            }
            $result = $this->AdminRoleResource->insertRole($updateData);
            DB::commit();
        }catch (\Exception $exception) {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }

    public function delRoleAndResource($data)
    {
        $result = true;
        DB::beginTransaction();
        try{
            $result = $this->AdminRole->delRole($data);
            $result = $this->AdminRoleResource->delRoleResource($data);
            DB::commit();
        }catch (\Exception $exception) {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }

    public function getRole($data)
    {
        $result = $this->AdminRole->getOne($data);
        return $result;
    }

    public function upd($data,$id)
    {
        $where = ['role_id'=>$id];
        $result = $this->AdminRole->upd($data,$where);
        return $result;
    }
}