<?php
namespace app\home\controller;
use think\Controller;
use think\Session;
class CommonsController extends Controller
{
	public function _initialize()
	{
		// 判断用户是否已经登录
		$data = Session::has('user');
		// dump($data);
		if(!$data){
			$this -> error('请登录','/login/index');
		}
	}
}