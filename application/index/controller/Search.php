<?php
namespace app\index\controller;
use think\Request;
use think\Db;
class Search
{
	public function insert(Request $request)
	{
		date_default_timezone_set('PRC');
		$data = json_decode(input('DataJson'),true);
		$uid = json_decode(input('uid'),true)['id'];
		$content = $data['content'];
		$data['uid'] = $uid;
		$data['id'] = random();
		$data['add_time'] = date('Y-m-d H:i:s');

		//查询是否有记录
		$arr = Db::table('search_history') -> where('uid',$uid) -> where('content',$content) -> find();
		if($arr)
		{
			$res = Db::table('search_history') -> where('id',$arr['id']) -> update($data);
		}else
		{
			$res = Db::table('search_history') -> insert($data);
		}
		
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function delete(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$where = json_decode(input('whereJson'),true)['type'];
		$res = Db::table('search_history') -> where('uid',$uid) -> where('type',$where) -> delete();
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
		$where = json_decode(input('WhereJson'),true)['type'];
		$data = Db::table('search_history') -> where('uid',$uid) -> where('type',$where) -> order('add_time desc') -> select();

		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}
}