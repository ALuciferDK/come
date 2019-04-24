<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 8:39
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GoodsServices;
use Storage;
class GoodsController extends Controller
{
    public function showList()
    {
        $goodsServices = new GoodsServices();
        $data = $goodsServices->getGoodsAll();
        if($data)
        {
            return view('backend.goods.showList',['goodsData'=>$data]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
        }
    }
    public function add(Request $request)
    {
        $goodsServices = new GoodsServices();

        if($request->isMethod('post'))
        {
            $result = $goodsServices->goodsAdd($request);
            //dd($result);
            switch ($result)
            {
                case 1:return redirect('/message')->
                with(['message'=>'商品添加成功!','url' =>'/Goods/showList', 'jumpTime'=>3,'status'=>true]);break;
                case 2:return redirect('/message')->
                with(['message'=>'商品添加有误，服务器错误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);break;
                case 3:return redirect('/message')->
                with(['message'=>'上传路径有误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);break;
                case 4:return redirect('/message')->
                with(['message'=>'图片格式错误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);break;
                case 5:return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);break;
            }

            /*$fileCharater = $request->file('g_img');
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
                        $data['g_img'] = $filename;
                        unset($data['_token']);
                        $resource = $goodsServices->insert($data);
                        if($resource)
                        {
                            return redirect('/message')->
                            with(['message'=>'商品添加成功!','url' =>'/Goods/showList', 'jumpTime'=>3,'status'=>true]);
                        }
                        else
                        {
                            return redirect('/message')->
                            with(['message'=>'商品添加有误，服务器错误!','url' =>'/Goods/add', 'jumpTime'=>3,'status'=>false]);
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
            }*/
        }
        else
        {
            $data = $goodsServices->getTypeAll();
            if($data)
            {
                return view('backend.goods.add',['typeData'=>$data]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
            }
        }
    }
    /*
     * 查询商品名称是否唯一
     * */
    public function goodsName(Request $request)
    {
        $data['g_name'] = $request->input('g_name');
        $goodsServices = new GoodsServices();
        $result = $goodsServices->getOne($data);
        echo $result;
    }

    public function goodsType(Request $request)
    {
        $data['type_id'] = $request->input('type_id');
        if($data['type_id'])
        {
            $info = 'attr_id';
            $goodsServices = new GoodsServices();
            $result = $goodsServices->getTypeValue($data,$info);
            return $result;
        }
        else
        {
            return 3;
        }
    }

    public function goodsValue(Request $request)
    {
        $goodsServices = new GoodsServices();
        $result = $goodsServices->getAttrValue($request);
        return $result;
    }

    public function getValue(Request $request)
    {
        $goodsServices = new GoodsServices();
        $attr_value = $goodsServices->Sku($request);
        return $attr_value;
    }
}