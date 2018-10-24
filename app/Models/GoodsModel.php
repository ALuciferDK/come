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
    public function getTypeAll()
    {
        $data  = DB::table($this->table)->get();
        return $data;
    }
}