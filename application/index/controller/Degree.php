<?php
namespace app\index\controller;
use think\Request;
use think\Db;
class Degree
{	
	//获取学历信息
	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$data = Db::table('degree') -> where('uid',$uid) -> select();
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//判断学历信息是否存在
	public function isNull(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$res = Db::table('degree') -> where('uid',$uid) -> select();
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//更新学历信息
	public function update(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$res = Db::table('degree') -> where('id',$id) -> update($data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取单条数据
	public function find(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$data = Db::table('degree') -> where('id',$id) -> find();
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}
}