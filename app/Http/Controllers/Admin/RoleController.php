<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 13:31
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Node;
use App\Model\Role;
use App\Model\RoleNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
	/**
	 * 角色列表页
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:07
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$RoleModel = new Role();
		$role = $RoleModel->roleList();
		return view('admin.role.index',['role' => $role]);
	}

	/**
	 * 新增角色页面
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:07
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createRole (Request $request)
	{
		if($request->ajax()){
			$RoleModel = new Role();
			$param = $request->all();
			$RoleModel = new Role();
			$res = $RoleModel->roleInsert($param);
			if($res){
				return trueAjax('新增成功');
			}else{
				return falseAjax('新增失败');
			}
		}else{
			return view('admin.role.create');
		}
	}

	/**
	 * 修改角色信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:07
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updateRole(Request $request)
	{
		$RoleModel = new Role();
		$param = $request->all();
		if($request->ajax()){
			if(!$param['id']){
				return falseAjax('参数错误');
			}

			$role = [
				'name' => $param['name'],
				'sort' => $param['sort'],
				'status' => isset($param['status']) && $param['status'] ? 1 : 0,
				'remark' => $param['remark']
			];
			$res = $RoleModel->roleUpdate($param['id'],$role);
			if($res){
				return trueAjax('修改成功');
			}else{
				return falseAjax('修改失败');
			}
		}else{
			if(!$param['r']){
				abort(404);
			}
			$role = $RoleModel->getRoleFind($param['r']);
			return view('admin.role.update',['role' => $role]);
		}
	}

	/**
	 * 设置角色启用状态
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:07
	 * @param Request $request
	 * @return array
	 */
	public function setStatus(Request $request)
	{
		$param = $request->all();
		$RoleModel = new Role();
		if(!$param['m']){
			return falseAjax('参数错误');
		}
		$role = $RoleModel->getRoleFind($param['m']);
		if($role->status == $param['status']){
			return falseAjax('参数错误');
		}
		$role->status = $param['status'];
		$res = $role->save();
		if($res){
			delCache();
			return trueAjax('设置成功');
		}else{
			return falseAjax('设置失败');
		}
	}

	/**
	 * 更新排序
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:07
	 * @param Request $request
	 * @return array
	 */
	public function setSort(Request $request)
	{
		$RoleModel = new Role();
		$data = $request->input('data',[]);
		if(!$data){
			return falseAjax('暂无数据可更新');
		}
		DB::beginTransaction();
		try{
			foreach($data as $value){
				$arr = [
					'sort' => $value['sort']
				];
				$RoleModel->roleUpdate($value['id'],$arr);
			}
			DB::commit();
			return trueAjax('更新成功');
		}catch(\Exception $e){
			DB::rollBack();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * 分配权限
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 11:25
	 * @param Request $request
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function power(Request $request)
	{
		$RoleNode = new RoleNode();
		$Node = new Node();
		$param = $request->all();
		if($request->ajax()){
			if(!$param['role_id']){
				return falseAjax('参数错误');
			}
			DB::beginTransaction();
			try{
				$RoleNode->delRoleNode($param['role_id']);
				foreach($param['node_id'] as $value){
					$arr['node_id'] = $value;
					$arr['role_id'] = $param['role_id'];
					$RoleNode->insertRoleNode($arr);
				}
				DB::commit();
				return trueAjax('分配成功');
			}catch(\Exception $e){
				DB::rollBack();
				return falseAjax($e->getMessage());
			}
		}else{
			if(!$param['r']){
				abort(404);
			}
			$role_node = $RoleNode->getRoleNode($param['r'])->pluck('node_id')->all();
			$node = $Node->getNodelAll();
			return view('admin.role.power',['param' => $param,'role_node' => $role_node,'node' => $node]);
		}
	}
}