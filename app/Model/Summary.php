<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/18
 * Time: 16:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{

	protected $guarded = [];//黑名单--不能被批量赋值的属性

	protected $table = 'summary';

	protected $dateFormat = 'U';

	/**
	 * 新增汇总表记录
	 * Created by：Mp_Lxj
	 * @date 2019/2/19 16:32
	 * @param $data
	 * @return mixed
	 */
	public function createSummary($data)
	{
		$data = $this->dataHandle($data);
		return $this->create($data);
	}

	/**
	 * 汇总表数据处理
	 * Created by：Mp_Lxj
	 * @date 2019/2/19 16:32
	 * @param $data
	 * @return mixed
	 */
	public function dataHandle($data)
	{
		$data['receipt_time'] = $data['receipt_time'] ? strtotime($data['receipt_time']) : 0;
		$data['order_time'] = $data['order_time'] ? strtotime($data['order_time']) : 0;
		$data['pack_time'] = $data['pack_time'] ? strtotime($data['pack_time']) : 0;
		$data['deliver_time'] = $data['deliver_time'] ? strtotime($data['deliver_time']) : 0;
		return $data;
	}

	/**
	 * 获取汇总表信息
	 * Created by：Mp_Lxj
	 * @date 2019/2/19 16:44
	 * @param $id
	 * @return mixed
	 */
	public function getSummaryData($id,$field = '*')
	{
		return $this->where('id',$id)->select($field)->first();
	}

	/**
	 * 分页获取数据
	 * Created by：Mp_Lxj
	 * @date 2019/2/19 17:00
	 * @param $data
	 * @return mixed
	 */
	public function getSummaryPage($data)
	{
		$data['start_time'] = isset($data['start_time']) && $data['start_time'] ? strtotime($data['start_time']) : 0;
		$data['end_time'] = isset($data['end_time']) && $data['end_time'] ? strtotime($data['end_time']) : 0;

		return $this
			->when(isset($data['contract_no']) && $data['contract_no'],function($query)use($data){
				$query->where('contract_no',$data['contract_no']);
			})
			->when(isset($data['dealer']) && $data['dealer'],function($query)use($data){
				$query->where('dealer',$data['dealer']);
			})
			->when(isset($data['manager']) && $data['manager'],function($query)use($data){
				$query->where('manager',$data['manager']);
			})
			->when($data['start_time'] || $data['end_time'],function($query)use($data){
				$query->whereBetween('order_time',[$data['start_time'],$data['end_time']]);
			})
			->orderBy('order_time','desc')
			->paginate(15);
	}

	/**
	 * 更新汇总表信息
	 * Created by：Mp_Lxj
	 * @date 2019/2/19 17:23
	 * @param $data
	 * @return mixed
	 */
	public function summaryUpdate($data)
	{
		$data = $this->dataHandle($data);
		return $this->where('id',$data['id'])->update($data);
	}
}