<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/20
 * Time: 9:15
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PowerServices;

class MenuController extends Controller
{
    public function showList()
    {
        $powerServices = new PowerServices();
        $data = $powerServices->getAll();
        if($data)
        {
            return view('backend.menu.showList',['menuData'=>$data]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
        }
    }
    public function add(Request $request)
    {
        $powerServices = new PowerServices();
        if($request->isMethod('post'))
        {
            $where = 'menu_id';
            $id = $powerServices->getLastId($where);
            $menu_id = $id->menu_id+1;
            if($request->input()['p_id'] == 0)
            {
                $data = [
                    'menu_name'=>$request->input()['menu_name'],
                    'url'=>$request->input()['url'],
                    'p_id'=>$request->input()['p_id'],
                    'path'=>$menu_id
                    ];
                $result = $powerServices->insertOne($data);
                if($result)
                {
                    return redirect('/message')->
                    with(['message'=>'添加成功!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'服务器错误!','url' =>'/Power/add', 'jumpTime'=>3,'status'=>false]);
                }
            }
            else
            {
                $path = $request->input()['p_id'].'-'.$menu_id;
                $data = [
                    'menu_name'=>$request->input()['menu_name'],
                    'url'=>$request->input()['url'],
                    'p_id'=>$request->input()['p_id'],
                    'path'=>$path
                ];
                $result = $powerServices->insertOne($data);
                if($result)
                {
                    return redirect('/message')->
                    with(['message'=>'添加成功!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'服务器错误!','url' =>'/Power/add', 'jumpTime'=>3,'status'=>false]);
                }
            }
        }
        else
        {
            $data = $powerServices->getAll();
            if($data)
            {
                return view('backend.menu.add',['menuData'=>$data]);
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
        $data['menu_id'] = $request->input('m_id');
        $powerServices = new PowerServices();
        $data = $powerServices->getOne($data);
        $where['menu_id']=$data->menu_id;
        $p_id['p_id'] = $data->menu_id;
        //dd($data);
        if($data->p_id == 0)
        {
            $result = $powerServices->delSonAndFather($where,$p_id);
            if($result)
            {
                return redirect('/message')->
                with(['message'=>'删除成功!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>true]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'删除失败!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else
        {
            $result = $powerServices->deleteOne($where);
            if($result)
            {
                return redirect('/message')->
                with(['message'=>'删除成功!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>true]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'删除失败!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>false]);
            }
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
                $powerServices = new PowerServices();
                $result = $powerServices->upd($data,$data['menu_id']);
                //dd($result);
                if($result)
                {
                    return redirect('/message')->
                    with(['message'=>'修改成功!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else if($result == 0)
                {
                    return redirect('/message')->
                    with(['message'=>'您并未修改!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>true]);
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'修改失败!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>false]);
                }
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/Power/Menu/upd', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else
        {
            $m['menu_id'] = $request->input('m_id');
            $powerServices = new PowerServices();
            $data = $powerServices->getOne($m);
            if($data)
            {
                $data = get_object_vars($data);
                return view('backend.menu.upd',['menuData'=>$data,'m_id'=>$m['menu_id']]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/Power/showList', 'jumpTime'=>3,'status'=>false]);
            }
        }
    }

    public function menuName(Request $request)
    {
        $powerServices = new PowerServices();
        $data = $request->input('menuname');
        $result = $powerServices->getMenuName($data);
        echo $result;
    }

    public function menuUrl(Request $request)
    {
        $powerServices = new PowerServices();
        $data = $request->input('url');
        $result = $powerServices->getUrl($data);
        echo $result;
    }
}