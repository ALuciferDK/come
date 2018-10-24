<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use App\Services\HomeService;

class PowerMiddleware
{
    /**
     * 检测用户是否登陆以及是否有访问管理权限
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $homeService = new HomeService;
        //dd($homeService);
        // 判断用户是否已经登陆

        if (!Session::get('user_info')) {
            return redirect('/backend/login');
        }

        // 判断是否有路由访问权限

        if (!$homeService->power($request->path())) {
            return redirect('/backend/home');
        }
        //dd($request);
        return $next($request);
    }
}