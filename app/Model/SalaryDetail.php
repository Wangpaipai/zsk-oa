<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class SalaryDetail extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'salary_detail';

	protected $dateFormat = 'U';

	const TYPE_BLANK = 'blank';//下料
	const TYPE_CARVE = 'carve';//雕刻
	const TYPE_PRESS_FIT = 'press_fit';//压合
	const TYPE_FEED = 'feed';//团料
	const TYPE_BANDING = 'banding';//封边拉槽
	const TYPE_BUCKLE_LINE = 'buckle_line';//木工异型 钉扣线
	const TYPE_STICK = 'stick';//贴皮
	const TYPE_SCRAPING = 'scraping';//刮灰
	const TYPE_SHAVE = 'shave';//灰磨
	const TYPE_STICKER = 'sticker';//贴纸
	const TYPE_PRIMER = 'primer';//底漆
	const TYPE_LACQUER_MILL = 'lacquer_mill';//漆磨
	const TYPE_TOP_COAT = 'top_coat';//面漆
	const TYPE_PACK = 'pack';//包装

	/**
	 * 新增工资明细
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 10:35
	 * @param $data
	 * @return mixed
	 */
	public function createSalary($data)
	{
		return $this->create($data);
	}

	/**
	 * 分页查询数据
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 14:25
	 * @param $data
	 * @return mixed
	 */
	public function getSalaryPage($data)
	{
		$data['start_time'] = isset($data['start_time']) && $data['start_time'] ? strtotime($data['start_time']) : 0;
		$data['end_time'] = isset($data['end_time']) && $data['end_time'] ? strtotime($data['end_time']) : 0;
		$field = ['t.id','t.summary_id','t.type','t.money','t.produce_time','t1.contract_no','t1.batch','t1.receipt_time'];
		return $this
			->from('salary_detail as t')
			->leftJoin('summary as t1','t.summary_id','=','t1.id')
			->when(isset($data['contract_no']) && $data['contract_no'],function($query)use($data){
				$query->where('t1.contract_no',$data['contract_no']);
			})
			->when(isset($data['batch']) && $data['batch'],function($query)use($data){
				$query->where('t1.batch',$data['batch']);
			})
			->when($data['start_time'] || $data['end_time'],function($query)use($data){
				if($data['start_time'] && !$data['end_time']){
					$query->where('t1.receipt_time','>=',$data['start_time']);
				}else{
					$query->whereBetween('t1.receipt_time',[$data['start_time'],$data['end_time']]);
				}
			})
			->where('t.type',$data['type'])
			->orderBy('t1.receipt_time','desc')
			->select($field)
			->paginate(15);
	}

	/**
	 * 自定义设置参数
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 9:22
	 * @param $data
	 * @param $id
	 * @return mixed
	 */
	public function setData($data,$id)
	{
		return $this->where('id',$id)->update($data);
	}

	/**
	 * 获取所有数据
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 16:07
	 * @param $data
	 * @return mixed
	 */
	public function getSalaryAll($data)
	{
		$data['start_time'] = isset($data['start_time']) && $data['start_time'] ? strtotime($data['start_time']) : 0;
		$data['end_time'] = isset($data['end_time']) && $data['end_time'] ? strtotime($data['end_time']) : 0;
		$field = ['t.id','t.summary_id','t.type','t.money','t.produce_time','t1.contract_no','t1.batch','t1.receipt_time'];
		return $this
			->from('salary_detail as t')
			->leftJoin('summary as t1','t.summary_id','=','t1.id')
			->when(isset($data['contract_no']) && $data['contract_no'],function($query)use($data){
				$query->where('t1.contract_no',$data['contract_no']);
			})
			->when(isset($data['batch']) && $data['batch'],function($query)use($data){
				$query->where('t1.batch',$data['batch']);
			})
			->when($data['start_time'] || $data['end_time'],function($query)use($data){
				if($data['start_time'] && !$data['end_time']){
					$query->where('t1.receipt_time','>=',$data['start_time']);
				}else{
					$query->whereBetween('t1.receipt_time',[$data['start_time'],$data['end_time']]);
				}
			})
			->where('t.type',$data['type'])
			->orderBy('t1.receipt_time','desc')
			->select($field)
			->get();
	}
}