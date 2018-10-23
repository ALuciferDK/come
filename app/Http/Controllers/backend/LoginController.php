<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 7:57
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LoginService;
use Session;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->input();
            //var_dump($data);die;
            $loginService = new LoginService();
            $result = $loginService->getOneWhere($data);
            //var_dump($result);
            if($result)
            {
                $result = get_object_vars($result);
                $data['password'] = md5($data['password']);
                if($data['password'] == $result['a_password'])
                {
                    Session::put('user_info',$result);
                    return redirect('/message')->
                    with(['message'=>'欢迎登陆!','url' =>'/backend/home', 'jumpTime'=>3,'status'=>true]);
                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'密码错误!','url' =>'/backend/login', 'jumpTime'=>3,'status'=>false]);
                }
            }
            else
            {
                return redirect('/message')->
                with(['message'=>'用户名错误!','url' =>'/backend/login', 'jumpTime'=>3,'status'=>false]);
            }

        }
        else
        {
            return view('backend.login.login');
        }
    }
    public function loginOut()
    {
        if(Session::pull('user_info'))
        {
            return redirect('/message')->
            with(['message'=>'退出成功!','url' =>'/backend/login', 'jumpTime'=>3,'status'=>true]);
        }
        else
        {
            return redirect('/message')->
            with(['message'=>'您还没有登录!','url' =>'/backend/login', 'jumpTime'=>3,'status'=>false]);
        }

    }

}