<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function message()
    {
        //验证参数
        if(!empty(session('message')) && !empty(session('url')) && !empty(session('jumpTime'))){
            $data = [
                'message' => session('message'),
                'url' => session('url'),
                'jumpTime' => session('jumpTime'),
                'status' => session('status')
            ];

        } else {
            $data = [
                'message' => '请勿非法访问！',
                'url' => 'Backend/home',
                'jumpTime' => 3,
                'status' => false
            ];
        }

        return view('message.message',['data' => $data]);
    }

}