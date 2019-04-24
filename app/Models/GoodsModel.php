<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 8:41
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsModel extends Model
{
    public $table;

    public function __construct($table)
    {
        $this->table = $table;
    }
    /*
     * 获取所有的分类类型
     * */
    public function getTypeAll()
    {
        $data  = DB::table($this->table)->get();
        return $data;
    }

    /*
     * 获取商品表商品单条信息，单条件查询
     * */
    public function getOne($where)
    {
        $result = DB::table($this->table)->where($where)->first();
        return $result;
    }

    /*
     * 商品添加数据，数据要求要和表字段对上
     * */
    public function insert($data)
    {
        $result = DB::table($this->table)->insert($data);
        return $result;
    }
    /*
     * 获取所有商品信息
     * */
    public function getGoodsAll()
    {
        $data = DB::table($this->table)->leftJoin('goods_type','goods.type_id','=','goods_type.type_id')->paginate();
        return $data;
    }

    public function getAllWhere($where,$info)
    {
        $data = DB::table($this->table)->where($where)->select($info)->get();
        return $data;
    }

    public function whereAll($where)
    {
        $data = DB::table($this->table)->where($where)->get();
        return $data;
    }

    public function getWhereIn($where,$num)
    {
        $data = DB::table($this->table)->whereIn($num,$where)->get();
        return $data;
    }

    public function groupWhereIn($id,$where,$info)
    {
        $result = Db::table($this->table)->whereIn($id,$where)->get()->groupBy($info);
        return $result = json_decode($result,true);
    }
    public function lastInsertId($data)
    {
        $result = DB::table($this->table)->insertGetId($data);
        return $result;
    }
}