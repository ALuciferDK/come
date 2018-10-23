<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 15:25
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    public $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function get($where,$info)
    {
        $data = DB::table($this->table)->where($where)->select($info)->get();
        return $data;
    }
    public function getWhere($where,$info)
    {
        $data = DB::table($this->table)->whereIn($info,$where)->get();
        return $data;
    }

    public  function getAll()
    {
        $data = DB::table($this->table)->get();
        return $data;
    }
    public function getMenu($where)
    {
        $data = DB::table($this->table)->where($where)->first();
        return $data;
    }
    public function getUrl($where)
    {
        $data = DB::table($this->table)->where($where)->first();
        return $data;
    }
    public function getLastId($id)
    {
        $id = DB::table($this->table)
            ->orderBy($id, 'desc')->select($id)
            ->first();
        return $id;
    }
    public function insertOne($data)
    {
        $result = DB::table($this->table)->insert($data);
        return $result;
    }
    public function deleteOne($data)
    {
        $result = DB::table($this->table)->where($data)->delete();
        return $result;
    }
    public function delSonAndFather($data,$p_id)
    {
        $result = DB::table($this->table)->where($data)->orWhere($p_id)->delete();
        return $result;
    }
    public function getOne($where)
    {
        $data = DB::table($this->table)->where($where)->first();
        return $data;
    }
    public function upd($data,$where)
    {
        $result = DB::table($this->table)->where($where)->update($data);
        return $result;
    }
}