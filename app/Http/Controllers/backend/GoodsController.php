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
class GoodsController extends Controller
{
    public function showList()
    {

    }
    public function add(Request $request)
    {
        $goodsServices = new GoodsServices();

        if($request->isMethod('post'))
        {

        }
        else
        {
            $data = $goodsServices->getTypeAll();
            if($data)
            {
                $data = json_decode($data,true);
                return view('backend.goods.add',['typeData'=>$data]);
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'服务器错误!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>false]);
            }
        }
    }
}