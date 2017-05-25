<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
use think\Db;
class Visitor
{
	public function insert(Request $request)
	{
		// return json(input());die;
		date_default_timezone_set('PRC');
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$data['uid'] = $uid;
		$data['visit_time'] = date('Y-m-d H:i:s');
		$employId = $data['employ_id'];
		$skillId = $data['skill_id'];
		$mod = new Common;
		if($employId)
		{
			//获取上次访问时间
			$arr = $mod -> select('visitor',['visitor_id' => $data['visitor_id'],'employ_id' => $employId]);
			if($arr)
			{
				$time = strtotime($arr[0]['visit_time']);
				if(time() - $time > 2*60*60)
				{
					$data['id'] = random();
					$res = $mod -> insert('visitor',$data);
				}else
				{
					$res = $mod -> saves('visitor',['id' => $arr[0]['id']],['visit_time' => date('Y-m-d H:i:s')]);
				}
			}else
			{
				$data['id'] = random();
				$res = $mod -> insert('visitor',$data);
			}
			
		}

		if($skillId)
		{
			//获取上次访问时间
			$arr = $mod -> select('visitor',['visitor_id' => $data['visitor_id'],'skill_id' => $skillId]);
			if($arr)
			{
				$time = strtotime($arr[0]['visit_time']);
				if(time() - $time > 2*60*60)
				{
					$data['id'] = random();
					$res = $mod -> insert('visitor',$data);
				}else
				{
					$res = $mod -> saves('visitor',['id' => $arr[0]['id']],['visit_time' => date('Y-m-d H:i:s')]);
				}
			}else
			{
				$data['id'] = random();
				$res = $mod -> insert('visitor',$data);
			}
			
		}
		
		
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取来访记录
	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$data = Db::table('visitor') -> where('uid',$uid) -> order('visit_time desc') -> select();

		if($data)
		{
			foreach ($data as $k => $v) 
			{
				Db::table('visitor') -> where('id',$v['id']) -> update(['is_scan' => 1]);
				//查询访客昵称
				$visitor = Db::table('userinfo') -> where('uid',$v['visitor_id']) -> find();
				$name = $visitor['nickname'];
				$photo = $visitor['icon'];

				//查询访问对象
				$type = '';
				$title = '';
				if($v['employ_id'])
				{
					$theme = Db::table('employ') -> where('id',$v['employ_id']) -> find();
					$title = '看过';
					$type = $theme['task_type'];
				}

				if($v['skill_id'])
				{
					$theme = Db::table('skill') -> where('id',$v['skill_id']) -> find();
					$title = '招聘';
					$type = $theme['skill_type'];
				}

				$time = $v['visit_time'];
				$time = strtotime($time);
				$time = visitor_time($time);
				$data[$k]['name'] = $name;
				$data[$k]['photo'] = $photo;
				$data[$k]['visit_time'] = $time;
				$data[$k]['type'] = $type;
				$data[$k]['title'] = $title;
			}
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//删除来访记录
	public function delete(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//来访记录ID

		//执行删除
		$res = Db::table('visitor') -> where('id',$id) -> delete();
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function isScan(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$data = Db::table('visitor') -> where('uid',$uid) -> where('is_scan',0) -> find();
		if($data)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}
}