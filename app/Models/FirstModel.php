<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/15
 * Time: 11:32
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FirstModel extends  Model
{
    public $table;
    public $primaryKey;

    /**
     *	定义构造函数
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /*
     *  入库返回
     * */
    public function insert($data)//注册添加入库
    {
        $result = DB::table($this->table)->insert($data);//入库语句

        return $result;//返回成功或失败
    }

    /*
     *  入库返回插入行ID
     * */
    public function insertId($data)//注册添加入库
    {
        $result = DB::table($this->table)->insertGetId($data);//入库语句

        return $result;//返回成功或失败
    }

    /*
     *  查询单条
     * */
    public function getOne($where)
    {
        $data = DB::table($this->table)->where($where)->first();
        return $data;
    }

    /*
     *  查询单条
     * */
    public function getAllWhere($where)
    {
        $data = DB::table($this->table)->where($where)->get();
        return $data;
    }

    public function getAll()
    {
        $data = DB::table($this->table)->get();
        return $data;
    }
}