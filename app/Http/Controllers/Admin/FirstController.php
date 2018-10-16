<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/7 0007
 * Time: 上午 10:39
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FirstService;
class FirstController extends Controller
{
    public function first()
    {
        $FirstService = new FirstService();
        $data = $FirstService->getAllGoodsType();
        if($data)
        {
            $data = json_decode($data,true);
        }
        //dd($data);
        return view('first.details',['data'=>$data]);
    }
}
?>