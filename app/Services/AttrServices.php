<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26
 * Time: 10:50
 */
namespace App\Services;
use App\Models\AttrModel;
class AttrServices
{
    public $attrModel;
    public function __construct()
    {
        $this->attrModel = new AttrModel('attr');
    }

    public function getAdd($data)
    {
        unset($data['_token']);
        $result = $this->attrModel->insert($data);
        return $result;
    }

    public function getAllPage()
    {
        $data = $this->attrModel->getAllPage();
        return $data;
    }
    /*
     * 通过传递单条件获取单条信息，表是商品表。
     * */
    public function getOne($where)
    {
        $result = $this->attrModel->getOne($where);
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
        $result = $this->attrModel->insert($data);
        return $result;
    }
    /*
     * 获取所有商品信息
     * */

    public function getLastId($where)
    {
        $result = $this->attrModel->getLastId($where);
        return $result;
    }
}