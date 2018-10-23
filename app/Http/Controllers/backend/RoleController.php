<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/20
 * Time: 8:52
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleServices;
use App\Services\PowerServices;
class RoleController extends Controller
{
    public function showList()
    {
        $roleServices = new RoleServices();
        $data = $roleServices->getAllPage();
        if($data)
        {
            return view('backend.role.showList',['roleData'=>$data]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
        }
    }

    public function add(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();
            $roleServices = new RoleServices();
            $result = $roleServices->addRole($data);
            if($result)
            {
                return redirect('/message')->
                with(['message'=>'添加角色成功!','url' =>'/Role/showList', 'jumpTime'=>3,'status'=>true]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'添加角色失败!','url' =>'/Role/showList', 'jumpTime'=>3,'status'=>false]);
            }


        }
        else
        {
            $powerServices = new PowerServices();
            $data = $powerServices->getAll();
            //dd($data);
            if($data)
            {
                return view('backend.role.add',['menuData'=>$data]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
            }
        }
    }

    public function del(Request $request)
    {
        $data['role_id'] = $request->input('m_id');
        $roleServices = new RoleServices();
        $result = $roleServices->delRoleAndResource($data);
        if($result)
        {
            return redirect('/message')->
            with(['message'=>'删除成功!','url' =>'/Role/showList', 'jumpTime'=>3,'status'=>true]);
        }
        else {
            return redirect('/message')->
            with(['message'=>'删除失败!','url' =>'/Role/showList', 'jumpTime'=>3,'status'=>false]);
        }
    }

    public function upd(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();
            if($data)
            {
                unset($data['_token']);
                $roleServices = new RoleServices();
                $result = $roleServices->upd($data,$data['role_id']);
                //dd($result);
                if($result)
                {
                    return redirect('/message')->
                    with(['message'=>'修改成功!','url' =>'/Role/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else if($result == 0)
                {
                    return redirect('/message')->
                    with(['message'=>'您并未修改!','url' =>'/Role/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'修改失败!','url' =>'/Role/showList', 'jumpTime'=>3,'status'=>false]);
                }
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/Role/Role/upd', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else
        {
            $m['role_id'] = $request->input('m_id');
            $roleServices = new RoleServices();
            $data = $roleServices->getRole($m);
            if($data)
            {
                $data = get_object_vars($data);
                //dd($data);
                return view('backend.role.upd',['roleData'=>$data,'m_id'=>$m['role_id']]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>false]);
            }
        }
    }
    public function roleName(Request $request)
    {
        $data['role_name'] = $request->input('rolename');
        $roleServices = new RoleServices();
        $result = $roleServices->getOne($data);
        return $result;
    }
}