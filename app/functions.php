<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/22
 * Time: 15:38
 */

if(!function_exists('trueAjax')){
	/**
	 * ajax请求成功返回
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 15:41
	 * @param string $msg
	 * @param array $data
	 * @return array
	 */
	function trueAjax($msg = '',$data = [])
	{
		return [
			'status' => 1,
			'msg' => $msg,
			'data' => $data
		];
	}
}

if(!function_exists('falseAjax')){
	/**
	 * ajax请求错误返回
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 15:42
	 * @param string $msg
	 * @param array $data
	 * @return array
	 */
	function falseAjax($msg = '',$data = [])
	{
		return [
			'status' => 0,
			'msg' => $msg,
			'data' => $data
		];
	}
}

if(!function_exists('delCache')){
	/**
	 * 删除权限缓存
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 11:30
	 */
	function delCache(){
		$key = [
			'admin_jur',
			'admin_menu'
		];

		foreach($key as $value){
			\Illuminate\Support\Facades\Cache::pull($value);
		}
	}
}

if(!function_exists('userStatus')){
	/**
	 * 更新用户状态缓存
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 11:37
	 * @param $uid
	 * @param $status
	 */
	function userStatus($uid,$status){
		$userStatus = \Illuminate\Support\Facades\Cache::get('admin_user_status',[]);
		$userStatus[$uid] = $status;
		\Illuminate\Support\Facades\Cache::forever('admin_user_status', $userStatus);
	}
}