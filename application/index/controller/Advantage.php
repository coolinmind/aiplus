<?php
namespace app\index\controller;
use think\Db;
use think\Request;
class Advantage
{
	public function insert(Request $request)
	{
		// return json(input());die;
		date_default_timezone_set('PRC');
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$data['uid'] = $uid;
		$data['time'] = date('Y-m-d');
		$data['id'] = random();

		$res = Db::table('advantage') -> insert($data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}
}