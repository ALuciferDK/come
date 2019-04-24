<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26
 * Time: 10:49
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AttrServices;
class AttrController extends Controller
{
    public function add(Request $request)
    {
        $attrService = new AttrServices();
        if($request->isMethod('post'))
        {
            /*$this->validate($request,[
                'attr_name' 	=> ["regex:/^[\u4e00-\u9fa5]{1,10}$/"],
            ]);*/
            $data = $request->input();
            $result = $attrService->getAdd($data);
            if($result)
            {
                return redirect('/message')->
                with(['message'=>'属性添加成功!','url' =>'/Attr/showList', 'jumpTime'=>3,'status'=>true]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'属性添加有误，服务器错误!','url' =>'/Attr/add', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else
        {
            return view('backend.attr.add');
        }
    }

    public function showList()
    {
        $attrService = new AttrServices();
        $data = $attrService->getAllPage();
        if($data)
        {
            return view('backend.attr.showList',['attrData'=>$data]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
        }
    }

    public function attrName(Request $request)
    {
        $data['attr_name'] = $request->input('attr_name');
        $attrServices = new AttrServices();
        $result = $attrServices->getOne($data);
        echo $result;
    }
}