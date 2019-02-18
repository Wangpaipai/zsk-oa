<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Admin extends Model
{
	use SoftDeletes;

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'admin';

	protected $dateFormat = 'U';

	const STATUS_TRUE = 1;//启用
	const STATUS_FALSE = 0;//禁用

	/**
	 * 新增用户
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 15:36
	 * @param $data
	 * @return mixed
	 */
	public function userInsert($data)
	{
		$user = [
			'user' => $data['name'],
			'password' => md5($data['password']),
			'status' => isset($data['status']) && $data['status'] ? 1 : 0,
			'realname' => $data['realname'],
			'phone' => $data['phone'],
			'email' => $data['email'],
		];
		return $this->create($user);
	}

	/**
	 * 管理员列表查询
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 16:18
	 * @param $data
	 * @return mixed
	 */
	public function userList($data)
	{
		$field = [
			'id','user','status','last_login_time','last_login_ip','realname','phone','email'
		];
		return $this->when(isset($data['phone']) && $data['phone'],function($query)use($data){
				return $query->where('phone',$data['phone']);
			})
			->when(isset($data['user']) && $data['user'],function($query)use($data){
				return $query->where('user',$data['user']);
			})
			->when(isset($data['email']) && $data['email'],function($query)use($data){
				return $query->where('email',$data['email']);
			})
			->when(isset($data['realname']) && $data['realname'],function($query)use($data){
				return $query->where('realname',$data['realname']);
			})
			->select($field)
			->paginate(15);
	}

	/**
	 * 删除用户
	 * Created by：Mp_Lxj
	 * @date 2019/1/22 16:44
	 * @param $id
	 * @return mixed
	 */
	public function delUser($id)
	{
		userStatus($id,0);
		return $this->where('id',$id)->delete();
	}

	/**
	 * 获取用户信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 8:59
	 * @param $id
	 * @return mixed
	 */
	public function getUserFind($id)
	{
		$field = [
			'id','user','status','realname','phone','email'
		];
		return $this->where('id',$id)->select($field)->first();
	}

	/**
	 * 根据用户名获取用户信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 15:26
	 * @param $user
	 * @return mixed
	 */
	public function getUserFirst($user)
	{
		return $this->where('user',$user)->first();
	}

	/**
	 * 修改用户信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/23 9:06
	 * @param $data
	 * @return mixed
	 */
	public function userUpdate($data,$user)
	{
		userStatus($data['id'],$user['status']);
		return $this->where('id',$data['id'])->update($user);
	}

	/**
	 * 获取用户长度
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 14:54
	 * @param $id
	 * @return mixed
	 */
	public function getUserCount($user)
	{
		return $this->where('user',$user)->count();
	}
}