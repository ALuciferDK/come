<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 9:30
 */
namespace App\Services;

use App\Models\LoginModel;

class LoginService
{
    /**
     *定义模型变量
     */
    public $adminModel;
    public $goodsTypeModel;

    /*
     *      构造函数
     * */
    public function __construct()
    {
        $this->adminModel = new LoginModel('admin');//实例化model类,指定goods表。
    }

    public function getOneWhere($where)
    {
        $where = ['a_email'=>$where['email']];
        $result = $this->adminModel->getOne($where);
        return $result;
    }

}