<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/15
 * Time: 11:29
 */

namespace App\Services;

use App\Models\UserModel;

class FirstService
{
    /**
     *定义模型变量
     */
    public $goodsModel;
    public $goodsTypeModel;

    /*
     *      构造函数
     * */
    public function __construct()
    {
        $this->goodsModel = new UserModel('goods');//实例化model类,指定goods表。
        $this->goodsTypeModel = new UserModel('goods_type');//实例化model类,指定goods_type表。
    }


}