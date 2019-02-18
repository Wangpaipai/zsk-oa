<?php

namespace App\Http\Middleware;

use App\Model\RoleAdmin;
use Closure;
use Illuminate\Support\Facades\Route;

class Jurisdiction
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
        $RoleAdmin = new RoleAdmin();
        $user = session('admin_user');

        //当前用户所拥有的权限
        $jur = $RoleAdmin->getJurisdiction($user);

        //当前访问的路由名
        $routeName = Route::currentRouteName();

        if(!in_array($routeName,$jur)){
            if($request->ajax()){
                exit(json_encode(falseAjax('无权限操作此项！')));
            }else{
                return redirect()->route('admin.index.index');
            }
        }
        view()->share('jur',$jur);
        return $next($request);
    }
}
