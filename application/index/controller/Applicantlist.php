<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
use think\Db;
class Applicantlist
{
	public function insert(Request $request)
	{
		// return json(input());die;
		date_default_timezone_set('PRC');
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$data['applicant_id'] = $uid;
		$data['add_time'] = date('Y-m-d H:i:s');
		$data['id'] = rand_str();
		$mod = new Common;

		//查询申请列表
		$arr = $mod -> select('applicant_list',['employ_id' => $data['employ_id'],'applicant_id' => $uid]);
		if($arr)
		{
			return json(['exists' => false]);
		}else
		{
			$res = $mod -> insert('applicant_list',$data);
			if($res)
			{
				return json(['success' => true]);
			}else
			{
				return json(['error' => false]);
			}
		}
	}

	public function get(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//需求ID
		$uid = json_decode(input('WhereJson'),true)['id'];//用户ID
		$data = Db::table('applicant_list') -> where('employ_id',$id) -> order('add_time desc') -> select();
		foreach ($data as $k => $v) 
		{
			//查询申请者详情
			$user = Db::table('userinfo') -> where('uid',$v['applicant_id']) -> find();

			//查询技能
			$skillData = Db::table('skill') -> where('id',$v['skill_id']) -> find();

			$data[$k]['nickname'] = $user['nickname'];
			$data[$k]['skill_description'] = $skillData['skill_description'];
			$data[$k]['icon'] = $user['icon'];
			$time = strtotime($v['add_time']);
			$time = friend_date($time);
			$data[$k]['add_time'] = $time;

			//判断是否点赞
			$supportId = $v['support_id'];

			if(!$supportId)
			{
				$data[$k]['action'] = false;
			}else
			{
				$res = strstr($supportId,$uid);
				
				if($res)
				{
					$data[$k]['action'] = true;
				}else
				{
					$data[$k]['action'] = false;
				}
			}
			
		}

		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取投递过的任务
	public function getEmploy(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];//申请者ID
		$data = Db::table('applicant_list') -> where('applicant_id',$uid)-> where('applicant_status','neq',2) -> select();

		//查询任务
		$arr = [];
		foreach ($data as $k => $v) 
		{
			$arr[$k] = Db::table('employ') -> where('id',$v['employ_id']) -> find()['id'];
		}
		
		if($data)
		{
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//更新
	public function update(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$res = Db::table('applicant_list') -> where('id',$id) -> update($data);

		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//点赞
	public function support(Request $request)
	{
		// return json(input());die;
		$supportId = json_decode(input('uid'),true)['id'];//点赞者ID
		$data = json_decode(input('DataJson'),true);
		$id = $data['good'];//申请者列表ID
		unset($data['good']);
		
		//查询原来点赞次数
		$arr = Db::table('applicant_list') -> where('id',$id) -> find();
		$num = $arr['support_num'];
		$supporter = $arr['support_id'];

		//判断是否点赞
		if(!$supporter)
		{
			$result = false;
		}else
		{
			$array = explode(',',$supporter);
			$result = array_key_exists($supportId,$array);
			if($result)
			{
				$result = true;
			}else
			{
				$result = false;
			}
		}
		
		//判断用户是否已经点赞
		if($result)
		{
			return json(['error' => 'already']);
		}else
		{
			$data['support_num'] = $num + 1;
			if($arr['support_id'])
			{
				$data['support_id'] = $arr['support_id'].','.$supportId;
			}else
			{
				$data['support_id'] = $supportId;
			}

			$res = Db::table('applicant_list') -> where('id',$id) -> update($data);
			if($res)
			{
				return json(['success' => true]);
			}else
			{
				return json(['error' => false]);
			}
		}

		
	}
}