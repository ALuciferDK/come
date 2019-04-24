<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25
 * Time: 16:53
 */
namespace App\Services;

use App\Models\TypeModel;
class TypeServices
{
    public $typeModel;
    public $attrModel;
    public function __construct()
    {
        $this->typeModel = new TypeModel('goods_type');
        $this->attrModel = new TypeModel('attr');
    }

    public function getTypeAll()
    {
        $data = $this->typeModel->getTypeAll();
        return $data;
    }

    public function getTypeAllPage()
    {
        $data = $this->typeModel->getTypeAllPage();
        return $data;
    }
    /*
     * 通过传递单条件获取单条信息，表是商品表。
     * */
    public function getOne($where)
    {
        $result = $this->typeModel->getOne($where);
        if($result)
        {
            echo 2;
        }
        else
        {
            echo 3;
        }
    }
    /*
     * 添加商品数据
     * */
    public function insert($data)
    {
        $result = $this->typeModel->insert($data);
        return $result;
    }
    /*
     * 获取所有商品信息
     * */
    public function getGoodsAll()
    {
        $data = $this->typeModel->getGoodsAll();
        return $data;
    }

    public function getLastId($where)
    {
        $result = $this->typeModel->getLastId($where);
        return $result;
    }

}