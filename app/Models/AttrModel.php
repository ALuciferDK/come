<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/26
 * Time: 10:51
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AttrModel extends Model
{
    public $table;

    public function __construct($table)
    {
        $this->table = $table;
    }
    /*
     * 获取所有的分类类型
     * */
    public function getAll()
    {
        $data  = DB::table($this->table)->get();
        return $data;
    }

    public function getAllPage()
    {
        $data  = DB::table($this->table)->paginate(5);
        return $data;
    }

    /*
     * 获取信息，单条件查询
     * */
    public function getOne($where)
    {
        $result = DB::table($this->table)->where($where)->first();
        return $result;
    }

    /*
     * 分类添加数据，数据要求要和表字段对上
     * */
    public function insert($data)
    {
        $result = DB::table($this->table)->insert($data);
        return $result;
    }

    public function getLastId($id)
    {
        $id = DB::table($this->table)
            ->orderBy($id, 'desc')->select($id)
            ->first();
        return $id;
    }
}