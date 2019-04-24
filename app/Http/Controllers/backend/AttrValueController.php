<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26
 * Time: 14:59
 */
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AttrValueServices;

class AttrValueController extends Controller
{
    public function add(Request $request)
    {
        $attrValueService = new AttrValueServices();
        if($request->isMethod('post'))
        {
            $data = $request->input();
            $result = $attrValueService->getAdd($data);
            if($result)
            {
                return redirect('/message')->
                with(['message'=>'属性值添加成功!','url' =>'/AttrValue/showList', 'jumpTime'=>3,'status'=>true]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'属性值添加有误，服务器错误!','url' =>'/AttrValue/add', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else
        {
            $data = $attrValueService->getShow();
            if($data)
            {
                return view('backend.attr_value.add',['attrData'=>$data]);
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
        $attrValueService = new AttrValueServices();
        $data = $attrValueService->getList();
        if($data)
        {
            return view('backend.attr_value.showList',['attrValueData'=>$data]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
        }
    }

    public function attrValueName(Request $request)
    {
        $data['value_name'] = $request->input('value_name');
        $attrValueServices = new AttrValueServices();
        $result = $attrValueServices->getOne($data);
        echo $result;
    }
}