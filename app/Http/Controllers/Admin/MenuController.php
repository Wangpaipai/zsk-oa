<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 13:31
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
	/**
	 * 菜单列表页
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:29
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$MenuModel = new Menu();
		$menu = $MenuModel->menuList();
		return view('admin.menu.index',['menu' => $menu]);
	}

	/**
	 * 新增菜单页面
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:29
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createMenu (Request $request)
	{
		if($request->ajax()){
			$param = $request->all();
			$AdminModel = new Menu();
			$res = $AdminModel->menuInsert($param);
			if($res){
				return trueAjax('新增成功');
			}else{
				return falseAjax('新增失败');
			}
		}else{
			return view('admin.menu.create');
		}
	}

	/**
	 * 修改菜单信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:59
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updateMenu(Request $request)
	{
		$MenuModel = new Menu();
		$param = $request->all();
		if($request->ajax()){
			if(!$param['id']){
				return falseAjax('参数错误');
			}

			$menu = [
				'status' => isset($param['status']) && $param['status'] ? 1 : 0,
				'name' => $param['name'],
				'icon' => $param['icon'],
				'sort' => $param['sort'],
			];
			$res = $MenuModel->menuUpdate($param['id'],$menu);
			if($res){
				return trueAjax('修改成功');
			}else{
				return falseAjax('修改失败');
			}
		}else{
			if(!$param['m']){
				abort(404);
			}
			$menu = $MenuModel->getMenuFind($param['m']);
			return view('admin.menu.update',['menu' => $menu]);
		}
	}

	/**
	 * 设置菜单启用状态
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:46
	 * @param Request $request
	 * @return array
	 */
	public function setStatus(Request $request)
	{
		$param = $request->all();
		$MenuModel = new Menu();
		if(!$param['m']){
			return falseAjax('参数错误');
		}
		$menu = $MenuModel->getMenuFind($param['m']);
		if($menu->status == $param['status']){
			return falseAjax('参数错误');
		}
		$menu->status = $param['status'];
		$res = $menu->save();
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
	 * @date 2019/1/23 11:44
	 * @param Request $request
	 * @return array
	 */
	public function setSort(Request $request)
	{
		$MenuModel = new Menu();
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
				$MenuModel->menuUpdate($value['id'],$arr);
			}
			DB::commit();
			return trueAjax('更新成功');
		}catch(\Exception $e){
			DB::rollBack();
			return falseAjax($e->getMessage());
		}
	}
}