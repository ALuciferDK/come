<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 9:36
 */
namespace App\Services;

use App\Models\GoodsModel;
use Storage;
use Illuminate\Support\Facades\DB;
class GoodsServices 
{
    public $goodsModel;
    public $typeModel;
    public $typeValue;
    public $attrModel;
    public $valueModel;
    public $goodsSkuModel;
    public $goodsValue;
    public function __construct()
    {
        $this->goodsModel = new GoodsModel('goods');
        $this->typeModel = new GoodsModel('goods_type');
        $this->typeValue = new GoodsModel('type_attr');
        $this->attrModel = new GoodsModel('attr');
        $this->valueModel = new GoodsModel('attr_value');
        $this->goodsSkuModel = new GoodsModel('goods_sku');
        $this->goodsValue = new GoodsModel('goods_value');
    }

    public function getTypeAll()
    {
        $data = $this->typeModel->getTypeAll();
        if($data)
        {
            $data = json_decode($data,true);
            $data = $this->createTree($data);
            return $data;
        }
        else
        {
            return $data;
        }

    }
/*
 * 无限极分类
 * */
    public function createTree($data,$parent_id = 0,$level = 0,$html='|--')
    {
        $tree = [];
        foreach ($data as $key => $value) {
            // 	获取的pid == $parent_id
            if ($value['p_id'] == $parent_id) {
                $value['level'] = $level;
                $value['html'] = str_repeat($html,$level);
                $value['son'] = $this->createTree($data,$value['type_id'],$level+1,$html);
                $tree[] = $value;
            }
        }
        return $tree;
    }

    /*
     * 通过传递单条件获取单条信息，表是商品表。
     * */
    public function getOne($where)
    {
        $result = $this->goodsModel->getOne($where);
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
        $result = $this->goodsModel->insert($data);
        return $result;
    }
    /*
     * 获取所有商品信息
     * */
    public function getGoodsAll()
    {
        $data = $this->goodsModel->getGoodsAll();
        return $data;
    }

    public function getTypeValue($where,$info)
    {
        $attr = $this->typeValue->getAllWhere($where,$info);
        $attr = json_decode($attr,true);
        $attr_id = array_column($attr,'attr_id');
        $num = 'attr_id';
        $attrData = $this->attrModel->getWhereIn($attr_id,$num);
        return $attrData;
    }

    public function getAttrValue($request)
    {

        $data = $request->input('attr_id');
        if($data)
        {
            $info = 'attr_id';
            $attrData = $this->valueModel->getWhereIn($data,$info);
            return $attrData;
        }
        else
        {
            return 3;
        }

    }

    public function goodsAdd($request)
    {
        $data = $request->input();
        $fileCharater = $request->file('g_img');
        $type = [0=>'bmp',1=>'jpg',2=>'jpeg',3=>'png',4=>'gif'];
        if ($fileCharater->isValid()) { //括号里面的是必须加的哦
            //如果括号里面的不加上的话，下面的方法也无法调用的

            //获取文件的扩展名
            $ext = $fileCharater->getClientOriginalExtension();
            //dd($ext);
            if(in_array($ext,$type))
            {
                //获取文件的绝对路径
                $path = $fileCharater->getRealPath();

                //定义文件名
                $filename = date('Y-m-d-h-i-s').'-'.time().'-'.rand(100000,9999999).'.'.$ext;

                //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
                $result = Storage::disk('public')->put($filename, file_get_contents($path));
                if($result)
                {
                    //	根据所选择的属性查询所属的所有属性值
                    foreach ($data['attrs'] as $key => $value) {
                        $where = ['attr_id'=>$value];
                        $attr_value[] = json_decode($this->valueModel->whereAll($where),true);
                        foreach ($attr_value as $k => $val) {
                            $value_id = array_column($val,'value_id');
                        }
                        $sku_attr = ['attr_id'=>['attr_id'=>$value],'value_id'=>$value_id,];
                        $goods_attr[] = $this->dikaer($sku_attr);
                    }
                    foreach ($goods_attr as $key => $va) {
                        foreach ($va as $key => $v) {
                            $goods_sku1[] = $v;
                        }
                    }
                    //	根据选择的属性、属性值进行货品匹配
                    $goodsAttrData = ['attr_id'	=>$data['attrs'],'value_id'	=>$data['values']];
                    $goods_sku = $this->dikaer($goodsAttrData);
                    //	判断属性所属属性值是否一致
                    foreach ($goods_sku as $key => $value) {
                        foreach ($goods_sku1 as $key => $val) {
                            if ($value == $val) {
                                $sku[] = $val;
                            }
                        }
                    }
                    //dd($sku);
                    $goodsData = [
                        'type_id'	=>$data['type_id'],
                        'g_name'=>$data['g_name'],
                        'g_info'=>$data['g_info'],
                        'g_price'=>$data['g_price'],
                        'promotion_price'=>$data['promotion_price'],
                        'g_img'=>$filename,
                        'g_number'=>time().substr(md5(rand(10000,9999)),0,6).rand(100000,999999),
                        'g_inventory'=>$data['g_inventory'],
                        'is_sale'=>$data['is_sale'],
                        'is_new'=>$data['is_new'],
                        'create_time'=>time(),
                        'update_time'=>time(),
                    ];
                    $attr_id = $data['attrs'];

                    DB::beginTransaction();
                    try{
                        $goodsID = $this->goodsModel->lastInsertId($goodsData);
                        for ($i = 0 ; $i<count($data['sku_name']);$i++)
                        {
                            $goodsSkuData[$i] = [
                                'sku_name'		=>$data['sku_name'][$i],
                                'goods_id'		=>$goodsID,
                                'sku_price'		=>$data['sku_price'][$i],
                                'sku_number'	=>$data['sku_number'][$i],
                                'sku_attr'		=>$data['sku_attr'][$i],
                                'sku_inventory'	=>$data['sku_inventory'][$i],
                                'create_time'	=>time(),
                                'update_time'	=>time(),
                            ];
                        }
                        $result = $this->goodsSkuModel->insert($goodsSkuData);
                        //	添加商品属性
                        $dikaer = ['goods_id'=>['goods_id'=>$goodsID],'attr_value'=>$sku];
                        $goodsSku = $this->dikaer($dikaer);
                        foreach ($goodsSku as $key => $value) {
                            $Sku[] = ['goods_id'=>$value[0],'attr_id'=>$value[1],'value_id'=>$value[2]];
                        }
                        $result = $this->goodsValue->insert($Sku);
                        DB::commit();
                    }catch (\Exception $exception)
                    {
                        DB::rollBack();
                        $result = false;
                    }
                    if($result)
                    {
                        return 1;
                    }
                    else
                    {
                        return 2;
                    }
                }
                else
                {
                    return 3;
                }
            }
            else
            {
                return 4;
            }
        }
        else
        {
            return 5;
        }
    }

    /**
     *	生成货品
     */
    public function Sku($request)
    {
        $valueID = $request->input('value_id');
        if($valueID)
        {
            $groupValue = $this->valueModel->groupWhereIn('value_id',$valueID,'attr_id');
            $dikaer = $this->dikaer($groupValue);

            return $dikaer;
        }
        else
        {
            return 2;
        }

    }

    /**
     *	笛卡尔积
     */
    public function dikaer($arr)
    {
        $arr1 = array();
        $result = array_shift($arr);		//	取出第一个数组
        while($arr2 = array_shift($arr)){
            $arr1 = $result;
            $result = array();
            foreach($arr1 as $key => $value){
                foreach($arr2 as $k => $val){
                    //	判断 $value 是否是数组
                    if(!is_array($value)){
                        $value = array($value);
                    }
                    if(!is_array($val)){
                        $val = array($val);
                    }
                    $result[] = array_merge_recursive($value,$val);
                }
            }
        }
        return $result;
    }

}