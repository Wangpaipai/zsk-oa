<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class RoleNode extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'role_node';

	protected $dateFormat = 'U';

	const STATUS_TRUE = 1;//启用
	const STATUS_FALSE = 0;//禁用

	/**
	 * 获取角色所拥有的权限
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 11:03
	 * @param $role
	 * @return mixed
	 */
	public function getRoleNode($role)
	{
		$field = [
			'node_id'
		];
		return $this->where('role_id',$role)->select($field)->get();
	}

	/**
	 * 写入数据
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 14:02
	 * @param $data
	 * @return mixed
	 */
	public function insertRoleNode($data)
	{
		delCache();
		return $this->create($data);
	}

	/**
	 * 删除权限
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 14:13
	 * @param $role_id
	 * @return mixed
	 */
	public function delRoleNode($role_id)
	{
		delCache();
		return $this->where('role_id',$role_id)->delete();
	}

	/**
	 * 获取权限ID
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 10:15
	 * @param $role
	 * @return mixed
	 */
	public function getJurisdiction($role)
	{
		$node =  $this
			->leftJoin('node','role_node.node_id','=','node.id')
			->whereIn('role_node.role_id',$role)
			->where('node.status',self::STATUS_TRUE)
			->orderBy('node.sort')
			->orderBy('node.created_at')
			->get(['role_node.node_id'])
			->pluck('node_id')
			->all();
		return $node;
	}
}