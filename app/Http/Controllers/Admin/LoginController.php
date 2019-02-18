<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/17
 * Time: 15:15
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
	/**
	 * 登录页面
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 15:37
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view('admin.login.index');
	}

	/**
	 * 用户登录
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 15:30
	 * @param Request $request
	 * @return array
	 */
	public function login(Request $request)
	{
		$param = $request->all();

		$loginCount = Cache::get('admin_login_num_' . $param['user']);
		if($loginCount >= 5){
			return falseAjax('您登录次数过多，请5分钟后再试!');
		}

		$Admin = new Admin();
		$user = $Admin->getUserFirst($param['user']);
		if(!$user->status){
			return falseAjax('帐号已被禁用!');
		}
		if(md5($param['password']) === $user->password){
			$user->last_login_ip = $request->getClientIp();
			$user->last_login_time = time();
			session(['admin_user' => $user]);
			$user->save();

			//用户状态缓存
			$userStatus = Cache::get('admin_user_status',[]);
			$userStatus[$user->id] = $user->status;
			Cache::forever('admin_user_status', $userStatus);
			return trueAjax('登录成功');
		}else{
			if(!$loginCount){
				Cache::put('admin_login_num_'. $param['user'],1,5);
			}else{
				Cache::increment('admin_login_num_' . $param['user'],1);
			}
			return falseAjax('帐号/密码错误!');
		}
	}

	/**
	 * 退出登录
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 16:31
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function loginOut(Request $request)
	{
		$request->session()->forget('admin_user');
		return redirect()->route('admin.login.index');
	}
}