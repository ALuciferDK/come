<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9 0009
 * Time: 上午 9:55
 */
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
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
     *  邮箱电话号码验证唯一性
     * */
    public function selectOne($where)
    {
        $table = Db::table($this->table);
        $resource = $table->where($where)->get();//通过取出的电话号码查找改号码是否已经存在

        if($resource->isEmpty())
        {
            return 3;//3代表成功，此号码没有被注册过。
        }else
        {
            return 2;//2代表失败，此号码已经被注册过。
        }
    }


    /*
     *  登录验证model
     * */
    public function loginIn($where,$orWhere)
    {
        //$where是第一条件，$orWhere是第二条件
        $table = Db::table($this->table);//实例化表
        $resource = $table->where($where)->orWhere($orWhere)->first();//利用接受条件进行查询
        return $resource;//返回数据
    }

    public function getOne($where)
    {
        $data = DB::table($this->table)->where($where)->first();
        return $data;
    }
}