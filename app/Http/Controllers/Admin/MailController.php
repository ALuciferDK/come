<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10 0010
 * Time: 下午 6:51
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\Controller;

class MailController extends Controller
{

    public function send() {
        $name = '我发的第一份邮件';
        // Mail::send()的返回值为空，所以可以其他方法进行判断
        Mail::send('mail.send',['name'=>$name],function($message){
            $to = '2856984195@qq.com';
            $message ->to($to)->subject('邮件测试');
        });
        dd(Mail::failures());
    }

}