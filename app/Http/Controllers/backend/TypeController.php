<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25
 * Time: 14:29
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TypeServices;
use Storage;
class TypeController extends Controller
{
    public function add(Request $request)
    {
        $typeServices = new TypeServices();
        if($request->isMethod('post'))
        {
            $data = $request->input();
            $fileCharater = $request->file('type_image');
            $type = [0=>'bmp',1=>'jpg',2=>'jpeg',3=>'png',4=>'gif'];
            if ($fileCharater->isValid()) { //括号里面的是必须加的哦
                //如果括号里面的不加上的话，下面的方法也无法调用的

                //获取文件的扩展名
                $ext = $fileCharater->getClientOriginalExtension();
                //dd($ext);
                if(in_array($ext,$type))
                {
                    //获取文件的绝对路径
                    $path = $fileCharater->getRealPath();

                    //定义文件名
                    $filename = date('Y-m-d-h-i-s').'-'.time().'-'.rand(100000,9999999).'.'.$ext;

                    //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
                    $result = Storage::disk('public')->put($filename, file_get_contents($path));
                    if($result)
                    {
                        $lastId = $typeServices->getLastId('type_id');
                        $type_id = $lastId->type_id+1;
                        if($data['p_id'] == 0)
                        {
                            $data['type_image'] = $filename;
                            $data['path'] = $type_id;
                            unset($data['_token']);;
                            $resource = $typeServices->insert($data);
                            if($resource)
                            {
                                return redirect('/message')->
                                with(['message'=>'商品分类添加成功!','url' =>'/Type/showList', 'jumpTime'=>3,'status'=>true]);
                            }
                            else
                            {
                                return redirect('/message')->
                                with(['message'=>'商品分类添加有误，服务器错误!','url' =>'/Type/add', 'jumpTime'=>3,'status'=>false]);
                            }
                        }
                        else
                        {

                            $data['type_image'] = $filename;
                            $data['path'] = $data['p_id'].'-'.$type_id;
                            unset($data['_token']);;
                            $resource = $typeServices->insert($data);
                            if($resource)
                            {
                                return redirect('/message')->
                                with(['message'=>'商品分类添加成功!','url' =>'/Type/showList', 'jumpTime'=>3,'status'=>true]);
                            }
                            else
                            {
                                return redirect('/message')->
                                with(['message'=>'商品分类添加有误，服务器错误!','url' =>'/Type/add', 'jumpTime'=>3,'status'=>false]);
                            }
                        }

                    }
                    else
                    {
                        return redirect('/message')->
                        with(['message'=>'上传路径有误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);
                    }
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'图片格式错误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);
                }
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else
        {
            $data = $typeServices->getTypeAll();
            if($data)
            {
                $data = json_decode($data,true);
                return view('backend.type.add',['typeData'=>$data]);
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
        $goodsServices = new TypeServices();
        $data = $goodsServices->getTypeAllPage();
        if($data)
        {
            //dd($data);
            return view('backend.type.showList',['typeData'=>$data]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
        }
    }

    public function typeName(Request $request)
    {
        $data['type_name'] = $request->input('type_name');
        $typeServices = new TypeServices();
        $result = $typeServices->getOne($data);
        echo $result;
    }

    public function typeUrl(Request $request)
    {
        $data['type_url'] = $request->input('type_url');
        $typeServices = new TypeServices();
        $result = $typeServices->getOne($data);
        echo $result;
    }
}