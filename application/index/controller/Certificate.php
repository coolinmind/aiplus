<?php
namespace app\index\controller;
use app\index\model\Common;
use think\Request;
class Certificate
{
	public function insert(Request $request)
	{
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$id = rand_str();
		$data['uid'] = $uid;
		$data['id'] = $id;

		//执行添加
		$mod = new Common;
		$res = $mod -> insert('certificate',$data);
		if($res)
		{
			return json(['success' => true,'id' => $id]);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function update(Request $request)
	{
		$data = json_decode(input('DataJson'),true);
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$res = $mod -> saves('certificate',['id' => $id],$data);
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
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$arr = $mod -> select('certificate',['uid' => $uid]);
		if($arr)
		{
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取单条项证书技能
	public function find(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$arr = $mod -> select('certificate',['id' => $id]);
		if($arr)
		{
			return json($arr[0]);
		}else
		{
			return json(['error' => false]);
		}
	}
}