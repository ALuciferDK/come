<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/7 0007
 * Time: 上午 10:39
 */
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FirstService;
use Illuminate\Support\Facades\Redis;
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
        if($d = Redis::get('list'))
        {
            $d = unserialize($d);
        }
        else
        {
            $data = serialize($data);
            Redis::set('list',$data);
        }
        return view('frontend.first.details',['data'=>$data]);
    }
}
?>