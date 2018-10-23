<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 15:08
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class AdminModel extends Model
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
    public function insertId($data)
    {
        $result = DB::table($this->table)->insertGetId($data);
        return $result;
    }

    public function getAll()
    {
        $data = DB::table($this->table)->paginate(5);
        return $data;
    }
    public function del($data)
    {
        $data = DB::table($this->table)->where($data)->delete();
        return $data;
    }
    public function getOne($where)
    {
        $data = DB::table($this->table)->where($where)->first();
        return $data;
    }
}