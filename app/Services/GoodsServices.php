<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 9:36
 */
namespace App\Services;

use App\Models\GoodsModel;

class GoodsServices
{
    public $goodsModel;
    public $typeModel;
    public function __construct()
    {
        $this->goodsModel = new GoodsModel('goods');
        $this->typeModel = new GoodsModel('goods_type');
    }

    public function getTypeAll()
    {
        $data = $this->typeModel->getTypeAll();
        return $data;
    }
}