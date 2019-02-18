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
use App\Model\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NodeController extends Controller
{
	/**
	 * 节点列表页
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:29
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$param = $request->all();
		$NodeModel = new Node();
		$node = $NodeModel->nodeList($param);
		$node_menu = $NodeModel->getMenuNode();
		return view('admin.node.index',['node' => $node,'node_menu' => $node_menu,'param'=>$param]);
	}

	/**
	 * 新增节点页面
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:29
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function createNode (Request $request)
	{
		$NodeModel = new Node();
		if($request->ajax()){
			$param = $request->all();
			$NodeModel = new Node();
			$res = $NodeModel->nodeInsert($param);
			if($res){
				return trueAjax('新增成功');
			}else{
				return falseAjax('新增失败');
			}
		}else{
			$MenuModel = new Menu();
			$menu = $MenuModel->getMenuAll();

			$node = $NodeModel->getMenuNode();
			return view('admin.node.create',['node_menu' => $node,'menu' => $menu]);
		}
	}

	/**
	 * 修改节点信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:59
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function updateNode(Request $request)
	{
		$NodeModel = new Node();
		$param = $request->all();
		if($request->ajax()){
			if(!$param['id']){
				return falseAjax('参数错误');
			}

			$node = [
				'name' => $param['name'],
				'route' => $param['route'],
				'sort' => $param['sort'],
				'status' => isset($param['status']) && $param['status'] ? 1 : 0,
				'remark' => $param['remark'],
				'level' => $param['level'],
				'pid' => $param['level'] == 1 ? 0 : $param['pid'],
				'is_menu' => $param['is_menu'],
				'menu_id' => $param['is_menu'] == 1 ? $param['menu_id'] : 0,
			];
			$res = $NodeModel->nodeUpdate($param['id'],$node);
			if($res){
				return trueAjax('修改成功');
			}else{
				return falseAjax('修改失败');
			}
		}else{
			if(!$param['n']){
				abort(404);
			}
			$node = $NodeModel->getNodeFind($param['n']);

			$MenuModel = new Menu();
			$menu = $MenuModel->getMenuAll();

			$node_menu = $NodeModel->getMenuNode();
			return view('admin.node.update',['node' => $node,'menu' => $menu,'node_menu' => $node_menu]);
		}
	}

	/**
	 * 设置节点启用状态
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 10:46
	 * @param Request $request
	 * @return array
	 */
	public function setStatus(Request $request)
	{
		$param = $request->all();
		$NodeModel = new Node();
		if(!$param['m']){
			return falseAjax('参数错误');
		}
		$node = $NodeModel->getNodeFind($param['m']);
		if($node->status == $param['status']){
			return falseAjax('参数错误');
		}
		$node->status = $param['status'];
		$res = $node->save();
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
		$NodeModel = new Node();
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
				$NodeModel->nodeUpdate($value['id'],$arr);
			}
			DB::commit();
			return trueAjax('更新成功');
		}catch(\Exception $e){
			DB::rollBack();
			return falseAjax($e->getMessage());
		}
	}
}