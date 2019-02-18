<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RoleAdmin extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'role_admin';

	protected $dateFormat = 'U';

	const STATUS_TRUE = 1;//启用
	const STATUS_FALSE = 0;//禁用

	/**
	 * 获取用户索拥有的权限
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 11:03
	 * @param $role
	 * @return mixed
	 */
	public function getRoleAdmin($admin)
	{
		$field = [
			'role_id'
		];
		return $this->where('admin_id',$admin)->select($field)->get();
	}

	/**
	 * 写入数据
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 14:02
	 * @param $data
	 * @return mixed
	 */
	public function insertRoleAdmin($data)
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
	public function delRoleAdmin($admin_id)
	{
		delCache();
		return $this->where('admin_id',$admin_id)->delete();
	}

	/**
	 * 获取当前用户所能执行的差菜单
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 10:40
	 * @return mixed
	 */
	public function getMenu($user)
	{
		$admin_menu = Cache::get('admin_menu',[]);
		if(isset($admin_menu[$user->id])){
			$menu = $admin_menu[$user->id];
		}else{
			$role = $this->getMyRole($user);

			$NodeModel = new RoleNode();
			$node = $NodeModel->getJurisdiction($role);

			$Node = new Node();
			$menu = $Node->getMenu($node);
			$admin_menu[$user->id] = $menu;
			Cache::forever('admin_menu',$admin_menu);
		}

		return $menu;
	}

	/**
	 * 获取当前帐号的角色
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 10:04
	 * @param $user
	 * @return mixed
	 */
	public function getMyRole($user)
	{
		$role = $this
			->leftJoin('role','role_admin.role_id','=','role.id')
			->where('role.status',self::STATUS_TRUE)
			->where('role_admin.admin_id',$user->id)
			->get(['role_admin.role_id'])
			->pluck('role_id')
			->all();
		return $role;
	}

	/**
	 * 获取当前用户可执行权限
	 * Created by：Mp_Lxj
	 * @date 2019/1/28 11:14
	 * @param $user
	 * @return mixed
	 */
	public function getJurisdiction($user)
	{
		$jur = Cache::get('admin_jur',[]);
		if(isset($jur[$user->id])){
			$Jurisdiction = $jur[$user->id];
		}else{
			$role = $this->getMyRole($user);

			$NodeModel = new RoleNode();
			$node = $NodeModel->getJurisdiction($role);

			$Node = new Node();
			$Jurisdiction = $Node->getJurisdiction($node);
			$jur[$user->id] = $Jurisdiction;
 			Cache::forever('admin_jur',$jur);
		}
		return $Jurisdiction;
	}
}