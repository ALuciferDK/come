<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 15:09
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    public $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function get($where,$info,$num,$whereTwo)
    {
        $data = DB::table($this->table)->whereIn($num,$where)->where($whereTwo)->select($info)->get();
        return $data;
    }

    public function getAll()
    {
        $data = DB::table($this->table)->get();
        return $data;
    }

    public function getAllPage()
    {
        $data = DB::table($this->table)->paginate();
        return $data;
    }

    public function insertRole($data)
    {
        $result = DB::table($this->table)->insert($data);
        return $result;
    }
    public function insertRoleId($data)
    {
        $result = DB::table($this->table)->insertGetId($data);
        return $result;
    }
    public function delRoleResource($data)
    {
        $result = DB::table($this->table)->where($data)->delete();
        return $result;
    }
    public function delRole($data)
    {
        $result = DB::table($this->table)->where($data)->delete();
        return $result;
    }
    public function getOne($where)
    {
        $result = DB::table($this->table)->where($where)->first();
        return $result;
    }
    public function upd($data,$where)
    {
        $result = DB::table($this->table)->where($where)->update($data);
        return $result;
    }
}