<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
class Authentication
{
	public function insert(Request $request)
	{
		$data = json_decode(input('DataJson'),true);
		$uid = json_decode(input('uid'),true)['id'];
		$data['uid'] = $uid;
		$data['id'] = rand_str();
		$Authentication = model('Authentication');
		$Authentication -> data($data);
		$res = $Authentication -> save();
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function get(Request $request)
	{
		$data = input();
		$uid = json_decode($data['id'],true)['id'];
		$mod = new Common;
		$res = $mod -> select('authentication',['uid' => $uid]);

		if($res)
		{
			foreach ($res as $k => $v) 
			{
				if($v['status'] == 0)
				{
					$v['status'] = '待审核';
				}else
				{
					$v['status'] = '已认证';
				}
				$res[$k]['status'] = $v['status'];
			}
			return json($res);
		}else
		{
			return json(['error' => false]);
		}
	}
}