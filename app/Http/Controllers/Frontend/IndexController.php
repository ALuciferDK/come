<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/27 0027
 * Time: 下午 3:21
 */
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends  Controller
{
    public function Index()
    {
        echo 123;
    }
    public function show()
    {
        $table = DB::table('test');
        $res = $table->get();
        dd($res);
    }
}