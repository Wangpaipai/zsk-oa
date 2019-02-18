<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 13:31
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Role;
use App\Model\RoleAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
	/**
	 * 管理员列表页
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 15:44
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$param = $request->only('user','email','realname','phone');
		$AdminModel = new Admin($param);
		$user = $AdminModel->userList($param);

		return view('admin.admin.index',['user' => $user,'param' => $param]);
	}

	/**
	 * 新增管理员页面
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 15:43
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createAdmin(Request $request)
	{
		if($request->ajax()){
			$param = $request->all();
			$AdminModel = new Admin();
			$RoleAdmin = new RoleAdmin();

			$userCount = $AdminModel->getUserCount($param['name']);
			if($userCount){
				return falseAjax('帐号已存在');
			}
			DB::beginTransaction();
			try{
				$res = $AdminModel->userInsert($param);
				foreach($param['role'] as $value){
					$arr['admin_id'] = $res->id;
					$arr['role_id'] = $value;
					$RoleAdmin->insertRoleAdmin($arr);
				}
				DB::commit();
				return trueAjax('新增成功');
			}catch(\Exception $e){
				DB::rollBack();
				return falseAjax($e->getMessage());
			}
		}else{
			$RoleModel = new Role();
			$role = $RoleModel->getRoleTrue();

			return view('admin.admin.create',['role' => $role]);
		}
	}

	/**
	 * 修改用户信息页面
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 16:41
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updateAdmin(Request $request)
	{
		$AdminModel = new Admin();
		$RoleAdmin = new RoleAdmin();
		$param = $request->all();
		if($request->ajax()){
			if(!$param['id']){
				return falseAjax('参数错误');
			}

			$user = [
				'status' => isset($param['status']) && $param['status'] ? 1 : 0,
				'realname' => $param['realname'],
				'phone' => $param['phone'],
				'email' => $param['email'],
			];
			if($param['password']){
				$user['password'] = md5($param['password']);
			}
			DB::beginTransaction();
			try{
				$AdminModel->userUpdate($param,$user);
				$RoleAdmin->delRoleAdmin($param['id']);
				foreach($param['role'] as $value){
					$arr['admin_id'] = $param['id'];
					$arr['role_id'] = $value;
					$RoleAdmin->insertRoleAdmin($arr);
				}
				DB::commit();
				return trueAjax('修改成功');
			}catch(\Exception $e){
				DB::rollBack();
				return falseAjax($e->getMessage());
			}
		}else{
			if(!$param['u']){
				abort(404);
			}
			$user = $AdminModel->getUserFind($param['u']);

			$RoleModel = new Role();
			$role = $RoleModel->getRoleTrue();

			$role_id = $RoleAdmin->getRoleAdmin($param['u'])->pluck('role_id')->all();
			return view('admin.admin.update',['user' => $user,'role' => $role,'role_id' => $role_id]);
		}
	}

	/**
	 * 删除用户
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 16:50
	 * @param Request $request
	 * @return array
	 */
	public function delUser(Request $request)
	{
		$param = $request->all();
		if(!$param['user']){
			return falseAjax('参数错误');
		}
		$AdminModel = new Admin();
		$res = $AdminModel->delUser($param['user']);
		if($res){
			return trueAjax('删除成功');
		}else{
			return falseAjax('删除失败');
		}
	}

	/**
	 * 设置帐号启用状态
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 9:43
	 * @param Request $request
	 * @return array
	 */
	public function setStatus(Request $request)
	{
		$param = $request->all();
		$AdminModel = new Admin();
		if(!$param['user']){
			return falseAjax('参数错误');
		}
		$user = $AdminModel->getUserFind($param['user']);
		if($user->status == $param['status']){
			return falseAjax('参数错误');
		}
		$user->status = $param['status'];
		userStatus($user->id,$user->status);
		$res = $user->save();
		if($res){
			return trueAjax('设置成功');
		}else{
			return falseAjax('设置失败');
		}
	}

	/**
	 * 修改个人资料
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 17:00
	 * @param Request $request
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function dataUpdate(Request $request)
	{
		if($request->ajax()){
			$param = $request->all();
			$user = session('admin_user');
			if($param['pwd_copy'] && $param['password']){
				if($user['password'] != md5($param['pwd'])){
					return falseAjax('原密码错误');
				}
				if($param['pwd_copy'] == $param['password']){
					$user->password = md5($param['password']);
				}
			}
			$user->phone = $param['phone'];
			$user->email = $param['email'];
			$res = $user->save();
			session(['admin_user' => $user]);
			if($res){
				return trueAjax('更新成功');
			}else{
				return falseAjax('更新失败');
			}
		}else{
			return view('admin.admin.data');
		}
	}
}