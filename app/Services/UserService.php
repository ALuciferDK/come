<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9 0009
 * Time: 上午 10:00
 */
namespace App\Services;

use App\Models\UserModel;
use App\Jobs\SendEmail;
use DispatchesJobs;

class UserService
{

    /**
     *定义模型变量
     */
    public $userModel;
    public $loginModel;

    /*
     *      构造函数
     * */
    public function __construct()
    {
        $this->userModel = new UserModel('user');//实例化model类,指定user表。
        $this->loginModel = new UserModel('login_log');//实例化model类,指定login_log表。
    }

    /*
     *  手机号用户注册
     * */
    public function saveRegisterTel($data)
    {
        unset($data['csrf'],$data['captcha'],$data['password_confirmation']);//删除多余的字段
        $info = [
            'u_name'=>$data['username'],
            'u_password'=>md5($data['password']),
            'u_mobile'=>$data['tel'],
            'u_email'=>'',
            'u_register_time'=>date('Y-m-d H-i-s'),
        ];//把字段换成表内字段名并赋值，并加入添加时间
        $result = $this->insertId($info);//使用inset方法,并接受返回值
        return $result;//返回给控制器返回值
    }

    /*
     *  邮箱用户注册
     * */
    public function saveRegisterEmail($data)
    {

        unset($data['csrf'],$data['captcha'],$data['password_confirmation'],$data['false']);//删除多余的字段
        $info = [
            'u_name'=>$data['username'],
            'u_password'=>md5($data['password']),
            'u_mobile'=>'',
            'u_email'=>$data['email'],
            'u_register_time'=>date('Y-m-d H-i-s')
        ];//把字段换成表内字段名并赋值，并加入添加时间
        $result = $this->insertId($info);//使用inset方法,并接受返回值
        return $result;//返回给控制器返回值
    }

    /*
     *  手机号唯一查询
     * */
    public function selectTel($data)
    {
        $where = ['u_mobile'=>$data['tel']];//手机号查询条件
        $result = $this->userModel->selectOne($where);//调用model里面的查询电话号码唯一性方法
        return $result;//返回结果给控制器
    }

    /*
     *  邮箱唯一查询
     * */
    public function selectEmail($data)
    {
        $where = ['u_email'=>$data['email']];//邮箱查询条件
        $result = $this->userModel->selectOne($where);//调用model里面的查询邮件唯一性方法
        return $result;//返回结果给控制器
    }

    /*
     *  登录验证
     * */
    public function loginIn($data)
    {
        $where = ['u_mobile'=>$data['username']];//判断手机号是否正确条件
        $orWhere = ['u_email'=>$data['username']];//判断邮箱是否正确条件

        $result = $this->userModel->loginIn($where,$orWhere);//调用登录model方法并传入两个条件
        return $result;//返回结果给控制器
    }

    /*
     *  通过ip查找单条//并且发送邮件
     * */
    public function getOneSendEmail($id)
    {

        $where = ['u_id'=>$id];//把得到id写入条件

        $data = $this->userModel->getOne($where);//使用model类里，查询单条方法

        $data = get_object_vars($data);

        $this->UserSendEmail($data);//发送邮件

        return $data;//返回得到的数据
    }
    /*
     *  通过ip查找单条
     * */
    public function getOne($id)
    {

        $where = ['u_id'=>$id];//把得到id写入条件

        $data = $this->userModel->getOne($where);//使用model类里，查询单条方法

        return $data;//返回得到的数据
    }

    /**
     *	队列发送邮件
     */
    public function UserSendEmail($data)
    {
        return dispatch(new SendEmail($data));
    }

    /**
     *	插入单条返回是否成功
     */
    public function insert($data)
    {
        $result = $this->userModel->insert($data);//使用model方法添加入库
        return $result;//返回给控制器返回值
    }

    /**
     *	插入单条返回最后插入行ID
     */
    public function insertId($data)
    {
        $result = $this->userModel->insertId($data);//使用model方法添加入库
        return $result;//返回给控制器返回值
    }

    public function loginLog($data)
    {
        $login_log = [
            'login_ip'=>$this->getIP(),
            'login_u_id'=>$data['u_id'],
            'login_u_name'=>$data['u_name'],
            'login_time'=>date('Y-m-d H-i-s'),
            'login_address'=>$this->getAddress($this->getIP())
        ];

        $result = $this->loginModel->insert($login_log);

        return $result;

    }

    /*
    * 获取用户真实IP
    * */
    function getIP()
    {
        static $real_ip;

        if(isset($_SERVER)){
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){

                $real_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

            }else if(isset($_SERVER['HTTP_CLIENT_IP'])){

                $real_ip = $_SERVER['HTTP_CLIENT_IP'];

            }else{
                $real_ip = $_SERVER['REMOTE_ADDR'];
            }
        }else{

            if(getenv('HTTP_X_FORWARDED_FOR')){

                $real_ip = getenv('HTTP_X_FORWARDED_FOR');

            }else if(getenv('HTTP_CLIENT_IP')){

                $real_ip = getenv('HTTP_CLIENT_IP');

            }else{

                $real_ip = getenv('REMOTE_ADDR');

            }

        }
        return $real_ip;
    }

    /*
     * 通过IP获取地址
     * */
    function getAddress($ip)
    {

        $url ='http://ip.taobao.com/service/getIpInfo.php?ip=' ;
        if($ip == '127.0.0.1')
        {
            $ip = '110.96.13.134';
        }

        $path = $url . $ip;

        $resource = file_get_contents($path);

        $result = json_decode($resource,true);

        $data = $result['data']['country'].$result['data']['region'].$result['data']['city'];

        return $data;
    }
}