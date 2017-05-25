<?php
namespace app\home\controller;
use think\Request;
class User
{
	//添加
	public function insert(Request $request)
	{
		$data = input();
		dump($data);
	}

	//查询
	public function get(Request $request)
	{

	}

	//更新
	public function update(Request $request)
	{

	}

	//删除
	public function delete(Request $request)
	{

	}
}