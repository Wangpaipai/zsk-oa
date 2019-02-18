<?php

namespace App\Http\Middleware;

use Closure;

class CheckNotLogin
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
        $user = session('admin_user');
        if($user){
            if($request->ajax()){
                exit(json_encode(falseAjax('已登录,请刷新页面！')));
            }else{
                return redirect()->route('admin.index.index');
            }
        }
        return $next($request);
    }
}
