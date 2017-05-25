<?php
namespace app\demo\controller;
use think\Loader;
use Wechat\Wechat;
class Demo
{
	public function index()
	{
		Loader::import('Wechat.Wechat', EXTEND_PATH, '.class.php');
		$Wechat = new Wechat();
		dump($Wechat);
	}
}