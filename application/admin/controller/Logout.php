<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use app\admin\model\Common;
class Logout extends Controller
{
	//执行退出
	public function logout()
	{
		Session::delete('admin');
		$res = Session::has('admin');
		if(!$res)
		{
			return $this -> redirect('/admin/login');
		}else
		{
			return $this -> error('退出失败');
		}
	}
}