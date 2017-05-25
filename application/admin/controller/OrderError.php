<?php 
namespace app\admin\controller;
use think\View;
use app\admin\model\Common;
use think\Db;
use think\Paginator;
use think\Controller;
use think\Session;
use app\admin\controller\CommonsController;
use think\Request;
class OrderError extends CommonsController
{
	public function index()
	{
		$db = new Common;
		$list = $db::select('error_log');
		return view('index',['list'=>$list]);
	}
}