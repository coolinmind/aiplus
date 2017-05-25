<?php
namespace app\index\controller;
use think\Db;
use think\Request;
class Feedback
{
	public function add(Request $request)
	{
		$data = $request -> param();
		$res = Db::table('feedback') -> insert($data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}
}