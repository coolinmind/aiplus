<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\model\Common;
class ProExperience
{
	//添加项目经验
	public function insert(Request $request)
	{
		date_default_timezone_set('PRC');
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$data['uid'] = $uid;
		$data['add_time'] = date('Y-m-d H:i:s');
		$where = $data;
		$data['id'] = rand_str();
		$mod = new Common;

		//避免重复添加
		$result = Db::table('proExperience') -> where($where) -> find();
		if(!$result)
		{
			$res = $mod -> insert('proExperience',$data);
		}else
		{
			$res = false;
		}
		
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取项目经验信息
	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$arr = Db::table('proExperience') -> where('uid',$uid) -> order('add_time desc') -> select();
		if($arr)
		{
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取单条项目经验数据
	public function find(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$arr = $mod -> select('proExperience',['id' => $id]);
		if($arr)
		{
			return json($arr[0]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//更新项目经验
	public function update(Request $request)
	{
		$data = json_decode(input('DataJson'),true);
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$res = $mod -> saves('proExperience',['id' => $id],$data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//判断项目经验是否已添加
	public function isExists(Request $request)
	{
		// return json(input());die;
		$data = json_decode(input('id'),true);
		$uid = $data['id'];
		$mod = new Common;
		$arr = $mod -> select('proExperience',['uid' => $uid]);
		$res = []; //项目名称
		$result = []; //项目名称不为空
		$id = ''; //项目名称为空时返回id
		if(!$arr)
		{
			return json([['error' => false]]);die;
		}
		foreach($arr as $v)
		{
			$res[] = $v['name'];
			if($v['name'])
			{
				$result[] = $v;
			}else
			{
				$id = $v['id'];continue;
			}
		}
		$str = implode('',$res);
		if(!$str)
		{
			//项目名为空，返回数据
			return json([['error' => false,'id' => $id]]);
		}else
		{
			//返回数据
			return json($result);
		}
	}
}