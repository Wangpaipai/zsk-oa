<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/2/18
 * Time: 13:52
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Summary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
			DB::beginTransaction();
			try{
				$SummaryModel->createSummary($param);
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
			return view('admin.summary.update',['summary' => $summary]);
		}
	}

	public function setData(Request $request){}

	public function excelDown(Request $request){}
}