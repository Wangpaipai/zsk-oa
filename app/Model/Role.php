<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'role';

	protected $dateFormat = 'U';

	const STATUS_TRUE = 1;//启用
	const STATUS_FALSE = 0;//禁用

	/**
	 * 新增角色
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:09
	 * @param $data
	 * @return mixed
	 */
	public function roleInsert($data)
	{
		$arr = [
			'name' => $data['name'],
			'sort' => $data['sort'],
			'status' => isset($data['status']) && $data['status'] ? 1 : 0,
			'remark' => $data['remark']
		];
		return $this->create($arr);
	}

	/**
	 * 角色列表查询
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:09
	 * @return mixed
	 */
	public function roleList()
	{
		$field = [
			'id','name','sort','status'
		];
		return $this
			->orderBy('sort')
			->orderBy('created_at')
			->select($field)
			->paginate(15);
	}

	/**
	 * 获取角色信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 10:09
	 * @param $id
	 * @return mixed
	 */
	public function getRoleFind($id)
	{
		$field = [
			'id','name','sort','status','remark'
		];
		return $this->where('id',$id)->select($field)->first();
	}

	/**
	 * 修改角色信息
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 14:20
	 * @param $data
	 * @return mixed
	 */
	public function roleUpdate($id,$data)
	{
		delCache();
		return $this->where('id',$id)->update($data);
	}

	/**
	 * 获取所有未禁用的角色
	 * Created by：Mp_Lxj
	 * @date 2019/1/25 14:22
	 * @return mixed
	 */
	public function getRoleTrue()
	{
		$field = ['id','name'];
		return $this->where('status',self::STATUS_TRUE)->select($field)->orderBy('sort')->orderBy('created_at')->get();
	}
}