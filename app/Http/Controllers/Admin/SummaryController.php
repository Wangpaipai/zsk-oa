<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/2/18
 * Time: 13:52
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
		return view('admin.summary.index');
	}

	public function create(Request $request){}

	public function update(Request $request){}

	public function setData(Request $request){}

	public function excelDown(Request $request){}
}