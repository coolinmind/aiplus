<?php
namespace app\index\controller;
use think\Request;
use think\Loader;
use app\index\model\Common;
use scws\pscws4;
use think\Db;
use think\Controller;

class Download extends controller
{
	public function index()
	{
		return view('index');
	}
}