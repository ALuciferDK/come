<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/7 0007
 * Time: 上午 9:59
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /*
	* 登录方法
	*/
    public function login(Request $request)
    {
        if($request->isMethod('post'))//判断是否是post请求，是post请求开始进行登录判断
        {
            $data = $request->input();//接收传输的值
            $userService = new UserService();//实例化类
            $result = $userService->loginIn($data);//使用类里面的登录查询方法
            if($result)
            {
                $result = get_object_vars($result);
                $pwd = md5($data['password']);
                if($pwd == $result['u_password'])
                {

                    $login_log_info = $userService->loginLog($result);
                    if($login_log_info)
                    {
                        $request->session()->put('user_info',$result);
                        return redirect('/message')->
                        with(['message'=>'登录成功!','url' =>'/first/first', 'jumpTime'=>3,'status'=>true]);
                    }
                    else
                    {
                        return redirect('/message')->
                        with(['message'=>'日志错误!','url' =>'/user/login', 'jumpTime'=>3,'status'=>false]);
                    }

                }
                else
                {
                    return redirect('/message')->
                    with(['message'=>'密码错误!','url' =>'/user/login', 'jumpTime'=>3,'status'=>false]);
                }

            }else
            {
                return redirect('/message')->
                with(['message'=>'账号不存在!','url' =>'/user/login', 'jumpTime'=>3,'status'=>false]);
            }
        }
        else//如果不是post请求进入展示登录界面
        {
            return view('user.login');
        }
    }

    /*
	* 退出登录方法
	*/
    public function loginOut(Request $request)
    {
        $request->session()->pull('user_info');//删除session信息
        return redirect('first/first');//返回前台首页
    }

    /*
	* 注册检验
	*/
    public function register(Request $request)
    {
        if($request->isMethod('post'))//判断是否是post请求，是post请求开始走入注册程序
        {
            $data = $request->input();//得到传入的值
            $info = isset($data['tel'])?'tel':'email';//通过值判断是否是电话号码和邮箱注册

            if($info == 'tel')//如果是电话号码注册，走电话号码注册service类里面的电话号码注册方法
            {
                //laravel自带验证，进行验证
                $this->validate($request,[
                    'username'=>['required','regex:/^[A-Za-z0-9]{5,16}$/'],
                    'tel'=>[
                        'required',
                        'regex:/^1[3578]d\{9}$/'
                    ],
                    'password'=>'required|between:6,12',
                    'password_confirmation'=>'required|same:password'
                ]);
                //var_dump($data);die;
                $userService = new UserService();//实例化类
                $result = $userService->saveRegisterTel($data);//调用里面的电话注册方法
                if($result)//判断返回值
                {
                    $data = $userService->getOne($result);
                    $request->session()->put('user_info',$data);
                    return redirect('/message')->with(['message'=>'注册成功!','url' =>'/first/first', 'jumpTime'=>3,'status'=>true]);//返回成功信息并跳转到首页
                }
                else
                {
                    return redirect('/message')->with(['message'=>'注册失败!','url' =>'/user/register', 'jumpTime'=>3,'status'=>false]);//返回错误并跳转到前台
                }
                /*$rules = [
                    'captcha' => 'required|captcha',
                    'tel' => [
                        'required',
                        'regex:/^(1[3578]\d{9}$/'
                    ],
                    'password' => 'required|between:6,12|confirmed',
                    'repassword_confirmation' => 'required',
                    'username'=>'required'
                ];
                $messages = [
                    'captcha.required' => '请输入验证码',
                    'captcha.captcha' => '验证码错误，请重试',
                    'tel.required' => '请输入手机号',
                    'tel.regex' => '请输入正确手机号',
                    'password.required' => '密码不得为空',
                    'password.between' => '密码请输入6位以上12位以下字符',
                    'password.confirmed' => '两次密码不一致',
                    'repassword_confirmation.required' => '确认密码不得为空',
                ];
                $validator = Validator::make($data, $rules,$messages);
                if ($validator->fails()){
                    $errors = $validator->errors();
                    if ($errors->has('captcha')) {
                        return $errors->first('captcha');
                    }
                    if (isset($arr['tel'])&&$errors->has('tel')) {
                        $data['u_tel']=$arr['tel'];
                        return $errors->first('tel');
                    }
                    if (isset($arr['mail'])&&$errors->has('mail')) {
                        $data['u_mail']=$arr['mail'];
                        return $errors->first('mail');
                    }
                    if ($errors->has('password')) {
                        return $errors->first('password');
                    }
                    if ($errors->has('repassword_confirmation')) {
                        return $errors->first('repassword_confirmation');
                    }
                    return '出错了！';
                }*/
            }
            else if($info == 'email')//如果是电话号码注册，走电话号码注册service类里面的电话号码注册方法
            {
                //laravel自带验证，进行验证
                $this->validate($request,[
                    'username'=>['required','regex:/^[A-Za-z0-9]{5,16}$/'],
                    'email'=> 'required|email',
                    'password'=>'required|between:6,12',
                    'password_confirmation'=>'required|same:password'
                ]);
                //var_dump($data);die;
                $userService = new UserService();//实例化类
                $result = $userService->saveRegisterEmail($data);//调用里面的电话注册方法
                //var_dump($result);die;
                if($result)//判断返回值
                {
                    //var_dump($result);die;
                    $data = $userService->getOneSendEmail($result);
                    if($data)
                    {
                        $request->session()->put('user_info',$data);
                        return redirect('/message')->with([
                                'message'=>'注册成功!',
                                'url' =>'/first/first',
                                'jumpTime'=>3,
                                'status'=>true
                        ]);//返回成功信息并跳转到首页
                    }
                    else
                    {
                        return redirect('/message')->with([
                            'message'=>'查找用户失败!',
                            'url' =>'/user/register',
                            'jumpTime'=>3,
                            'status'=>false]);//返回错误并跳转到前台
                    }

                }
                else
                {
                    return redirect('/message')->with([
                        'message'=>'注册失败!',
                        'url' =>'/user/register',
                        'jumpTime'=>3,
                        'status'=>false]);//返回错误并跳转到前台
                }
            }
        }
        else//如果不是post请求进入展示注册界面
        {
            return view('user.register');
        }

    }

    /*
     * 号码验证唯一性
     * */
    public function userTel(Request $request)//验证电话唯一性方法
    {
        $data = $request->input();//得到数据
        $userService = new UserService();//实例化userService
        $result = $userService->selectTel($data);//通过userService对象访问里面的电话号码唯一性方法
        echo $result;//输出返回值
    }

    /*
     * 邮箱验证唯一性
     * */
    public function userEmail(Request $request)//验证邮箱唯一性方法
    {
        $data = $request->input();//得到数据
        //var_dump($data);die;
        $userService = new UserService();//实例化userService
        $result = $userService->selectEmail($data);//通过userService对象访问里面的邮箱唯一性方法
        echo $result;//输出返回值
    }

    /*
     * 验证码失焦验证方法
     * */
    public function werAdd(Request $request){
        //通过laravel验证，验证验证码是否输入正确
        $result = $this->validate($request, [
            'captcha' => 'required|captcha',
        ],[
            'captcha.required' => trans('validation.required'),
            'captcha.captcha' => trans('validation.captcha'),
        ]);
        //var_dump($request);die;
        if($result)//返回值判断
        {
            echo 3;//3代表成功
        }else
        {
            echo 2;//2代表失败
        }
    }


}
?>