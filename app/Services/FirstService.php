<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/15
 * Time: 11:29
 */

namespace App\Services;

use App\Models\FirstModel;

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
        $this->goodsModel = new FirstModel('goods');//实例化model类,指定goods表。
        $this->goodsTypeModel = new FirstModel('goods_type');//实例化model类,指定goods_type表。
    }

    public function getAllGoodsType()
    {
        $data = $this->goodsTypeModel->getAll();
        return $data;
    }

}