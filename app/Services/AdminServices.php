<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18
 * Time: 12:05
 */
namespace App\Services;

use App\Models\AdminModel;
use App\Models\RoleModel;
use Illuminate\Support\Facades\DB;

class AdminServices
{
    public $adminModel;
    public $roleModel;
    public $roleModelUser;
    public function __construct()
    {
        $this->adminModel = new AdminModel('admin');
        $this->roleModel = new RoleModel('admin_role');
        $this->roleModelUser = new RoleModel('admin_user_role');
    }
    public function getAll()
    {
        $data = $this->roleModel->getAll();
        return $data;
    }

    public function getInsertIdAndInsertRole($data,$role_id)
    {
        $result = true;
        DB::beginTransaction();
        try{
            $a_id = $this->adminModel->insertId($data);
            foreach ($role_id as $key => $value)
            {
                $role_data[$key] = ['user_id'=>$a_id,'role_id'=>$value];
            }
            $result = $this->roleModelUser->insertRole($role_data);
            DB::commit();
        }catch (\Exception $exception) {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }

    public function getAllAdmin()
    {
        $data = $this->adminModel->getAll();
        return $data;
    }

    public function delAdmin($data,$admin)
    {
        $result = true;
        DB::beginTransaction();
        try{
            $this->adminModel->del($admin);
            $result = $this->roleModelUser->delRoleResource($data);
            DB::commit();
        }catch (\Exception $exception)
        {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }

    public function getOne($where)
    {
        $data = $this->adminModel->getOne($where);
        return$data;
    }

    public function delRoleResource($id)
    {
        $where = ['user_id'=>$id];
        $result = true;
        DB::beginTransaction();
        try{
            $result = $this->roleModelUser->delRoleResource($where);
            DB::commit();
        }catch (\Exception $exception)
        {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }

    public function updAdminMenu($data,$where)
    {
        $result = true;
        DB::beginTransaction();
        try{
            $result = $this->roleModelUser->delRoleResource($where);
            $result = $this->roleModelUser->insertRole($data);
            DB::commit();
        }catch (\Exception $exception)
        {
            $result = false;
            DB::rollBack();
        }
        return $result;
    }
}