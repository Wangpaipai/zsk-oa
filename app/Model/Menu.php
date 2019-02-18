<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'menu';

	protected $dateFormat = 'U';

	const STATUS_TRUE = 1;//启用
	const STATUS_FALSE = 0;//禁用

	/**
	 * 新增菜单
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 15:36
	 * @param $data
	 * @return mixed
	 */
	public function menuInsert($data)
	{
		$user = [
			'name' => $data['name'],
			'icon' => $data['icon'],
			'sort' => $data['sort'],
			'status' => isset($data['status']) && $data['status'] ? 1 : 0,
		];
		return $this->create($user);
	}

	/**
	 * 菜单列表查询
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 16:18
	 * @return mixed
	 */
	public function menuList()
	{
		$field = [
			'id','name','sort','status'
		];
		return $this->orderBy('sort')->select($field)->paginate(15);
	}

	/**
	 * 获取菜单信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 9:59
	 * @param $id
	 * @return mixed
	 */
	public function getMenuFind($id)
	{
		$field = [
			'id','name','sort','status'
		];
		return $this->where('id',$id)->select($field)->first();
	}

	/**
	 * 修改菜单信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 9:59
	 * @param $data
	 * @return mixed
	 */
	public function menuUpdate($id,$data)
	{
		delCache();
		return $this->where('id',$id)->update($data);
	}

	/**
	 * 查询所有菜单
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 14:09
	 * @return mixed
	 */
	public function getMenuAll()
	{
		$field = [
			'id','name'
		];
		return $this->orderBy('sort')->orderBy('created_at','desc')->select($field)->get();
	}
}