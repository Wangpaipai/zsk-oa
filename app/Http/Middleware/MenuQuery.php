<?php

namespace App\Http\Middleware;

use App\Model\RoleAdmin;
use Closure;

class MenuQuery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->getMenu();
        return $next($request);
    }

    /**
     * 获取当前用户所能执行的菜单
     * Created by：Mp_Lxj
     * @date 2019/1/28 11:02
     */
    public function getMenu()
    {
        $RoleAdmin = new RoleAdmin();
        $user = session('admin_user');
        $menu = $RoleAdmin->getMenu($user);
        view()->share('admin_menu',$menu);
    }
}
