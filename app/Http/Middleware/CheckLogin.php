<?php

namespace App\Http\Middleware;

use App\Model\Admin;
use Closure;
use Illuminate\Support\Facades\Cache;

class CheckLogin
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
        if(!$user){
            if($request->ajax()){
                return falseAjax('请先登录！');
            }else{
                return redirect()->route('admin.login.index');
            }
        }else{
            $Admin = new Admin();
            $userStatus = Cache::get('admin_user_status',[]);

            //获取当前用户的状态
            if(isset($userStatus[$user->id])){
                $user_status = $userStatus[$user->id];
            }else{
                $user = $Admin->getUserFirst($user->user);

                $userStatus[$user->id] = $user_status = $user->status;
                Cache::forever('admin_user_status', $userStatus);
            }

            //判断用户是否被禁用
            if($user_status == $Admin::STATUS_FALSE){
                session()->forget('admin_user');
                if($request->ajax()){
                    exit(json_encode(falseAjax('帐号已被禁用！')));
                }else{
                    return redirect()->route('admin.login.index');
                }
            }
        }
        view()->share('admin_user',$user);
        return $next($request);
    }
}
