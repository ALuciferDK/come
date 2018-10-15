<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/7 0007
 * Time: 上午 10:39
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FirstController extends Controller
{
    public function first()
    {

        return view('first.details');
    }
}
?>