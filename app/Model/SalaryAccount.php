<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class SalaryAccount extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'salary_account';

	protected $dateFormat = 'U';

	/**
	 * 新增工资流水明细
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 10:35
	 * @param $data
	 * @return mixed
	 */
	public function createAccount($data)
	{
		return $this->create($data);
	}

	/**
	 * 删除所有记录
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 15:23
	 * @param $id
	 * @return mixed
	 */
	public function delAccount($id)
	{
		return $this->where('salary_id',$id)->delete();
	}

	/**
	 * 获取当前编号下所有流水
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 15:26
	 * @param $id
	 * @return mixed
	 */
	public function getAccountAll($id)
	{
		$field = ['number','price','total'];

		return $this->where('salary_id',$id)->get($field);
	}
}