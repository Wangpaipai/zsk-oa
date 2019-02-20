<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/2/18
 * Time: 13:52
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\SalaryDetail;
use App\Model\Summary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SummaryController extends Controller
{
	/**
	 * 首页
	 * Created by：Mp_Lxj
	 * @date 2019/2/18 13:56
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$SummaryModel = new Summary();
		$param = $request->all();
		$letter = config('summary');
		$summary = $SummaryModel->getSummaryPage($param);
		return view('admin.summary.index',['letter' => $letter,'param' => $param,'summary'=>$summary]);
	}

	/**
	 * 新增生产资料汇总信息
	 * Created by：Mp_Lxj
	 * @date 2019/2/19 16:39
	 * @param Request $request
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(Request $request)
	{
		if($request->ajax()){
			$param = $request->all();
			$SummaryModel = new Summary();
			$SalaryDetailModel = new SalaryDetail();
			DB::beginTransaction();
			try{
				$summary = $SummaryModel->createSummary($param);
				$salary = config('letter.salary_type');
				foreach($salary as $value){
					$data['summary_id'] = $summary->id;
					$data['type'] = $value['name'];
					$SalaryDetailModel->createSalary($data);
				}
				DB::commit();
				return trueAjax('新增成功');
			}catch(\Exception $e){
				DB::rollBack();
				return falseAjax($e->getMessage());
			}
		}else{
			return view('admin.summary.create');
		}
	}

	/**
	 * 更新汇总表数据
	 * Created by：Mp_Lxj
	 * @date 2019/2/19 17:23
	 * @param Request $request
	 * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function update(Request $request)
	{
		$param = $request->all();
		$SummaryModel = new Summary();
		if($request->ajax()){
			if(!$param['id']){
				return falseAjax('参数错误');
			}
			DB::beginTransaction();
			try{
				$SummaryModel->summaryUpdate($param);
				DB::commit();
				return trueAjax('提交成功');
			}catch(\Exception $e){
				DB::rollBack();
				return falseAjax($e->getMessage());
			}
		}else{
			$summary = $SummaryModel->getSummaryData($param['id']);
			return view('admin.summary.update',['summary' => $summary,'param' => $param]);
		}
	}

	/**
	 * 设置参数
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 9:21
	 * @param Request $request
	 * @return array
	 */
	public function setData(Request $request)
	{
		$param = $request->all();
		$SummaryModel = new Summary();
		if($param['type'] == 'time'){
			$param['val'] = strtotime($param['val']);
		}
		$arr[$param['key']] = $param['val'];
		DB::beginTransaction();
		try{
			$SummaryModel->setData($arr,$param['id']);
			DB::commit();
			return trueAjax('提交成功');
		}catch(\Exception $e){
			DB::rollBack();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * Excel下载
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 10:07
	 * @param Request $request
	 */
	public function excelDown(Request $request)
	{
		$SummaryModel = new Summary();
		$param = $request->all();
		$letter = config('summary');
		$summary = $SummaryModel->getSummaryPage($param);

		$title = $this->getExcelTitle($param,$letter);
		$data[0] = $title['title'];
		foreach($summary as $item){
			$item->receipt_time = $item->receipt_time ? date('n/j',$item->order_time) : '未';
			$item->order_time = $item->order_time ? date('n/j',$item->order_time) : '未';
			$item->order_inside_outside = $item->order_inside_outside == 1 ? '内' : '外';
			$item->pack_time = $item->pack_time ? date('n/j',$item->pack_time) : '未';
			$item->deliver_time = $item->deliver_time ? date('n/j',$item->deliver_time) : '未';

			$arr = [];
			foreach($title['letter'] as $value){
				$arr[] = $item->$value;
			}
			$data[] = $arr;
		}
		Excel::create(iconv('UTF-8', 'GBK', '生产资料汇总表' . date('Y-m-d')),function($excel) use ($data){
			$excel->sheet('score', function($sheet) use ($data){
				$sheet->rows($data);
			});
		})->export('xls');
	}

	/**
	 * 获取excel导出标题和字段栏
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 9:37
	 * @param $param
	 * @param $letter
	 * @return array
	 */
	public function getExcelTitle($param,$letter)
	{
		$res = [];
		if(!isset($param['hide']) || !$param['hide']){
			foreach($letter as $value){
				$res['title'][] = $value['title'];
				$res['letter'][] = $value['name'];
			}
		}else{
			$res['letter'] = $param['hide'];
			foreach($param['hide'] as $value){
				foreach($letter as $item){
					if($item['name'] == $value){
						$res['title'][] = $item['title'];
					}
				}
			}
		}
		return $res;
	}
}