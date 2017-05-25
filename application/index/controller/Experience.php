<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
class Experience
{
	//获取工作经验
	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$res = $mod -> select('experience',['uid' => $uid]);
		if($res)
		{
			return json($res);
		}else
		{
			return json(['error' => false]);
		}
	}

	//更新工作经验
	public function update(Request $request)
	{
		// return json(input());die;
		$id = json_decode(input('id'),true)['id'];
		$data = json_decode(input('DataJson'),true);

		$mod = new Common;
		$res = $mod -> saves('experience',['id' => $id],$data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//查询单条数据
	public function find(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$arr = $mod -> select('experience',['id' => $id]);
		if($arr)
		{
			return json($arr[0]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//添加工作经验
	public function insert(Request $request)
	{
		$data = json_decode(input('DataJson'),true);
		$uid = json_decode(input('uid'),true)['id'];
		$data['uid'] = $uid;
		$data['id'] = rand_str();
		$mod = new Common;
		$res = $mod -> insert('experience',$data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//判断工作经验是否添加
	public function isNull(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$data = $mod -> select('experience',['uid' => $uid]);
		if($data)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}
}