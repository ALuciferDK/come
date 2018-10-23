<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18
 * Time: 12:02
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminServices;
use App\Services\RoleServices;
use Session;

class AdminController extends Controller
{
    public function add(Request $request)
    {
        $adminServices = new AdminServices();
        if($request->isMethod('post'))
        {
            $this->validate($request,[
                'a_name'=>'required',
                'a_email'=> 'required|email',
                'a_password'=>'required',
                'role'=>'required'
            ]);
            $data = $request->input();
            $role_id = $data['role'];//得到要赋予的权限id
            unset($data['role'],$data['_token']);
            //完善添加数据，加入添加时间和密码加密以及是谁添加
            $data['a_login_time'] = date('Y-m-d H-i-s');
            $data['a_password'] = md5($data['a_password']);
            $data['create_name'] = Session::get('user_info')['a_name'];
            //开始services层操作
            $result = $adminServices->getInsertIdAndInsertRole($data,$role_id);
            if($result)
            {
                $this->showList();
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'添加管理员失败!','url' =>'/Admin/add', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else
        {
            $data = $adminServices->getAll();
            if($data)
            {
                $data = json_decode($data,true);
                return view('backend.admin.add',['data'=>$data]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
            }

        }
    }
    public function showList()
    {
        $adminServices = new AdminServices();
        $adminData = $adminServices->getAllAdmin();
        //dd($adminData);
        return view('backend.admin.showList',['adminData'=>$adminData]);
    }
    public function del(Request $request)
    {
        $data['user_id'] = $request->input('id');
        $admin['a_id'] = $request->input('id');
        $adminServices = new AdminServices();
        $result = $adminServices->delAdmin($data,$admin);
        if($result)
        {
            return redirect('/message')->
            with(['message'=>'删除管理员成功!','url' =>'/Admin/showList', 'jumpTime'=>3,'status'=>true]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'删除管理员失败!','url' =>'/Admin/showList', 'jumpTime'=>3,'status'=>false]);
        }

    }

    public function upd(Request $request)
    {
        if($request->isMethod('post'))
        {
            $adminServices = new AdminServices();
            $role = $request->input();
            $where = isset($role['role'])?$role['role']:0;
            if($where == 0)
            {
                $result = $adminServices->delRoleResource($role['a_id']);
                if($result)
                {
                    return redirect('/message')->
                    with(['message'=>'修改管理员权限成功!','url' =>'/Admin/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'修改管理员权限失败!','url' =>'/Admin/showList', 'jumpTime'=>3,'status'=>false]);
                }
            }
            else
            {
                foreach ($role['role'] as $key => $value) {
                    $updateData[$key] = ['user_id'=>$role['a_id'],'role_id'=>$value];
                }
                $result = $adminServices->updAdminMenu($updateData,$data=['user_id'=>$role['a_id']]);
                if($result)
                {
                    return redirect('/message')->
                    with(['message'=>'修改管理员权限成功!','url' =>'/Admin/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'修改管理员权限失败!','url' =>'/Admin/showList', 'jumpTime'=>3,'status'=>false]);
                }
            }
        }
        else
        {
            $data['a_id'] = $request->input('id');

            $roleServices = new RoleServices();
            //dd($adminData);
            $roleData = $roleServices->getAll();
            if($roleData)
            {
                $roleData = json_decode($roleData,true);
                return view('backend.admin.upd',['roleData'=>$roleData,'a_id'=>$data['a_id']]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/Admin/showList', 'jumpTime'=>3,'status'=>false]);
            }
        }


    }
}