<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/2/20
 * Time: 11:01
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\SalaryAccount;
use App\Model\SalaryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalaryDetailController extends Controller
{
	/**
	 * 工资明细首页
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 14:48
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$SalaryDetailModel = new SalaryDetail();
		$param = $request->all();
		if(!isset($param['type']) || !$param['type']){
			$param['type'] = 'blank';
		}
		$letter = config('letter.salary_type');

		$salary = $SalaryDetailModel->getSalaryPage($param);
		return view('admin.salary.index',['letter' => $letter,'param' => $param,'salary' => $salary]);
	}

	/**
	 * 设置参数
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 14:48
	 * @param Request $request
	 * @return array
	 */
	public function setData(Request $request)
	{
		$param = $request->all();
		$SalaryDetailModel = new SalaryDetail();
		if($param['type'] == 'time'){
			$param['val'] = strtotime($param['val']);
		}
		$arr[$param['key']] = $param['val'];
		DB::beginTransaction();
		try{
			$SalaryDetailModel->setData($arr,$param['id']);
			DB::commit();
			return trueAjax('提交成功');
		}catch(\Exception $e){
			DB::rollBack();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * 获取当前明细下流水
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 15:29
	 * @param Request $request
	 * @return array
	 */
	public function getAccount(Request $request)
	{
		$param = $request->all();
		$SalaryAccountModel = new SalaryAccount();
		$account = $SalaryAccountModel->getAccountAll($param['id']);
		if($account){
			return trueAjax('',$account);
		}else{
			return falseAjax();
		}
	}

	/**
	 * 写入流水
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 15:58
	 * @param Request $request
	 * @return array
	 */
	public function createDetail(Request $request)
	{
		$param = $request->all();
		$SalaryAccountModel = new SalaryAccount();
		$SalaryDetailModel = new SalaryDetail();
		DB::beginTransaction();
		try{
			//删除以前的记录
			$SalaryAccountModel->delAccount($param['id']);
			$total = 0;
			//循环写入新纪录
			foreach($param['data'] as $value){
				$total += $value['total'];
				$arr = $value;
				$arr['salary_id'] = $param['id'];
				$SalaryAccountModel->createAccount($arr);
			}
			//更新工序总价
			$SalaryDetailModel->setData(['money' => $total],$param['id']);
			DB::commit();
			return trueAjax('提交成功');
		}catch(\Exception $e){
			DB::rollBack();
			return falseAjax($e->getMessage());
		}
	}

	/**
	 * 工资明细excel下载
	 * Created by：Mp_Lxj
	 * @date 2019/2/20 16:16
	 * @param Request $request
	 */
	public function excelDown(Request $request)
	{
		$param = $request->all();
		$SalaryDetailModel = new SalaryDetail();
		unset($param['type']);
		$letter = config('letter.salary_type');

		$data = [];
		foreach($letter as $value){
			$param['type'] = $value['name'];
			$data[$value['title']] = $SalaryDetailModel->getSalaryAll($param);
		}

		Excel::create(iconv('UTF-8', 'GBK', '工资明细表' . date('Y-m-d')),function($excel) use ($data){
			$title = [
				'合同编号','月份','批号','金额','工序生产日期'
			];
			foreach($data as $k=>$v){
				$arr = [];
				$arr[0] = $title;
				foreach($v as $value){
					$account = [];
					$account[] = $value->contract_no;
					$account[] = date('n月',$value->receipt_time);
					$account[] = $value->batch;
					$account[] = $value->money;
					$account[] = $value->produce_time ? date('Y-m-d',$value->produce_time) : '';
					$arr[] = $account;
				}
				$excel->sheet($k, function($sheet) use ($arr){
					$sheet->rows($arr);
				});
			}
		})->export('xls');
	}
}