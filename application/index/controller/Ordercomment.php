<?php
namespace app\index\controller;
use app\index\model\Common;
use think\Request;
use think\Db;
class Ordercomment
{
	public function insert(Request $request)
	{
		$data = json_decode(input('DataJson'),true);

		$type = $data['type'];
		if(!array_key_exists('id',$data))
		{
			$id = $data['id'] = 0;
		}else
		{
			$id = $data['id'];
		}
		unset($data['id']);
		
		$mod = new Common;

		//准备数据
		if($type == 0)
		{
			$data['pid'] = 0;
		}else
		{
			$data['pid'] = $id;
		}
		$data['add_time'] = date('Y-m-d H:i:s');
		
		//执行添加
		$res = Db::table('order_comment') -> insert($data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取评论信息
	public function get(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//订单ID

		$mod = new Common;

		//查询评论数据
		$data = $mod -> select('order_comment',['order_id' => $id,'pid' => 0]);

		foreach ($data as $k => $v) 
		{
			//查询回复
			$reply = $mod -> select('order_comment',['pid' => $k]);
			if($reply)
			{
				$data[$k]['reply'] = $reply;
			}else
			{
				$data[$k]['reply'] = '';
			}

			//如果用户匿名评论，隐藏用户信息
			if($v['anonymous'] == 1)
			{
				$data[$k]['photo'] = '';
				$data[$k]['nickname'] = '';
			}else
			{
				//查询用户详情
				$info = Db::table('userinfo') -> where('uid',$v['from_uid']) -> find();
				$data[$k]['photo'] = $info['icon'];
				$data[$k]['nickname'] = $info['nickname'];
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

	//点赞
	public function support(Request $request)
	{
		$uid = json_decode(input('uid'),true)['id'];//用户ID
		$data = json_decode(input('DataJson'),true);
		$id = $data['id'];//评论ID

		//获取评论数据
		$commentData = Db::table('order_comment') -> where('id',$id) -> find();
		$num = $commentData['support'];
		if($commentData['supporter_id'])
		{
			$supporterId = $commentData['supporter_id'].','.$uid;
		}else
		{
			$supporterId = $uid;
		}

		//执行更新
		$res = Db::table('order_comment') -> where('id',$id) -> update(['support' => $num+1,'supporter_id' => $supporterId]);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}

	}

	//判断用户是否点赞
	public function isSupport(Request $request)
	{
		// return json(input());die;
		$uid = json_decode(input('uid'),true)['id'];//用户ID
		$data = json_decode(input('DataJson'),true);
		$id = $data['id'];//技能ID
		//查询订单
		$order = Db::table('orders') -> where('skill_id',$id) -> select();

		if($order)
		{
			//查询评论
			$commentData = [];
			foreach ($order as $k => $v) 
			{
				$array = Db::table('order_comment') -> where('order_id',$v['id']) -> select();
				$commentData = array_merge($commentData,$array);
			}
			
			$arr = [];

			if($commentData)
			{
				foreach ($commentData as $k => $v) 
				{
					if(strstr($v['supporter_id'],$uid))
					{
						$arr[$k]['id'] = $v['id'];
					}
				}

				//返回用户点赞过的评论ID
				return json($arr);
			}else
			{
				return json(['error' => null]);
			}
		}else
		{
			return json(['error' => null]);
		}
	}
}