<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Node extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'node';

	protected $dateFormat = 'U';

	const STATUS_TRUE = 1;//启用
	const STATUS_FALSE = 0;//禁用

	const MENU_TRUE = 1;//是菜单
	const MENU_FALSE = 0;//不是菜单

	/**
	 * 新增节点
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 13:22
	 * @param $data
	 * @return mixed
	 */
	public function nodeInsert($data)
	{
		$arr = [
			'name' => $data['name'],
			'route' => $data['route'],
			'sort' => $data['sort'],
			'status' => isset($data['status']) && $data['status'] ? 1 : 0,
			'remark' => $data['remark'],
			'level' => $data['level'],
			'pid' => $data['level'] == 1 ? 0 : $data['pid'],
			'is_menu' => $data['is_menu'],
			'menu_id' => $data['is_menu'] == 1 ? $data['menu_id'] : 0,
		];
		return $this->create($arr);
	}

	/**
	 * 节点列表查询
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 13:22
	 * @return mixed
	 */
	public function nodeList($data)
	{
		$field = [
			't.id','t.name','t.route','t.sort','t.status','t.is_menu','t1.name as p_name'
		];
		return $this
			->from('node as t')
			->leftJoin('node as t1','t.pid','=','t1.id')
			->when(isset($data['name']) && $data['name'],function($query)use($data){
				return $query->where('t.name','like','%'.$data['name'].'%');
			})
			->when(isset($data['route']) && $data['route'],function($query)use($data){
				return $query->where('t.route','like','%'.$data['route'].'%');
			})
			->when(isset($data['pid']) && !is_null($data['pid']),function($query)use($data){
				return $query->where('t.pid',$data['pid'])->orWhere('t.id',$data['pid']);
			})
			->orderBy('t.sort')
			->orderBy('t.created_at')
			->select($field)
			->paginate(15);
	}

	/**
	 * 获取节点信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 13:22
	 * @param $id
	 * @return mixed
	 */
	public function getNodeFind($id)
	{
		$field = [
			'id','name','route','sort','status','is_menu','level','menu_id'
		];
		return $this->where('id',$id)->select($field)->first();
	}

	/**
	 * 修改节点信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 13:22
	 * @param $data
	 * @return mixed
	 */
	public function nodeUpdate($id,$data)
	{
		delCache();
		return $this->where('id',$id)->update($data);
	}

	/**
	 * 获取所有属于菜单的节点
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 14:11
	 * @return mixed
	 */
	public function getMenuNode()
	{
		$field = [
			'id','name'
		];
		return $this->where('is_menu',self::MENU_TRUE)->orderBy('sort')->orderBy('created_at','desc')->select($field)->get();
	}

	/**
	 * 分配权限页面数据
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 11:22
	 * @return mixed
	 */
	public function getNodelAll()
	{
		$node = $this->getTopLevel();
		foreach($node as &$value){
			$value->child = $this->getTrueNode($value->id);
		}
		return $node;
	}

	/**
	 * 获取所有节点
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 11:22
	 * @param $pid
	 * @return mixed
	 */
	public function getTrueNode($pid)
	{
		$field = ['id','name'];
		return $this
			->where('pid',$pid)
			->where('status',self::STATUS_TRUE)
			->orWhere(function($query)use($pid){
				$query->where('id',$pid)->where('status',self::STATUS_TRUE);
			})
			->select($field)
			->orderBy('sort')
			->orderBy('created_at')
			->get();
	}

	/**
	 * 获取所有已启用的顶级节点
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 11:15
	 * @return mixed
	 */
	public function getTopLevel()
	{
		$field = ['id','name'];
		return $this->where('level',1)->where('status',self::STATUS_TRUE)->select($field)->orderBy('sort')->orderBy('created_at')->get();
	}

	/**
	 * 获取当前用户所拥有的菜单列表
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 10:35
	 * @param $node
	 * @return mixed
	 */
	public function getMenu($node)
	{
		$menu = $this->getTopMenu($node);
		foreach($menu as &$value){
			$value->child = $this->getMenuChildNode($value->id,$node);
		}
		return $menu;
	}

	/**
	 * 获取当前菜单下的子菜单
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 10:34
	 * @param $menu_id
	 * @return mixed
	 */
	public function getMenuChildNode($menu_id,$node)
	{
		$field = [
			'name','route'
		];
		return $this->where('menu_id',$menu_id)->whereIn('id',$node)->where('is_menu',self::MENU_TRUE)->orderBy('sort')->orderBy('created_at')->get($field);
	}

	/**
	 * 获取当前用户所能访问的顶级菜单
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 10:23
	 * @param $node
	 * @return mixed
	 */
	public function getTopMenu($node)
	{
		$Menu = new Menu();
		return $this
			->leftJoin('menu','node.menu_id','=','menu.id')
			->whereIn('node.id',$node)
			->where('menu.status',$Menu::STATUS_TRUE)
			->orderBy('menu.sort')
			->orderBy('menu.created_at')
			->groupBy('menu.id')
			->get(['menu.id','menu.icon','menu.name']);
	}

	/**
	 * 获取可操作权限
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 11:14
	 * @param $node
	 * @return mixed
	 */
	public function getJurisdiction($node)
	{
		return $this->whereIn('id',$node)->get(['route'])->pluck('route')->all();
	}
}