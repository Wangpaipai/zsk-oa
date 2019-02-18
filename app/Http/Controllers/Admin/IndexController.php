<?php
/**
 * Created by PhpStorm.
 * User: 54714
 * Date: 2019/1/17
 * Time: 15:15
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	public function index()
	{
		return view('admin.index.index');
	}

	public function main()
	{
		return view('admin.index.main');
	}
}