<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use app\admin\model\Common;
class CommonsController extends Controller
{
	public function _initialize()
	{
		// 判断用户是否已经登录
		$data = Session::has('admin');
		// dump($data);
		if(!$data){
			$this -> error('请登录','/admin/login');
		}
	}
}