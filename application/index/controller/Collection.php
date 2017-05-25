<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
use think\Db;
class Collection
{
	public function insert(Request $request)
	{
		date_default_timezone_set('PRC');
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$data['uid'] = $uid;
		$data['id'] = rand_str();
		$data['add_time'] = date('Y-m-d H:i:s');
		$mod = new Common;
		if($data['employ_id'])
		{
			//查询是否已收藏
			$arr = $mod -> select('collection',['uid' => $uid,'employ_id' => $data['employ_id']]);
			if($arr)
			{
				return json(['exists' => false]);
			}else
			{
				//执行添加
				$res = $mod -> insert('collection',$data);
				if($res)
				{
					return json(['success' => true]);
				}else
				{
					return json(['error' => false]);
				}
			}
		}

		if($data['skill_id'])
		{
			//查询是否已收藏
			$arr = $mod -> select('collection',['uid' => $uid,'skill_id' => $data['skill_id']]);
			if($arr)
			{
				return json(['exists' => false]);
			}else
			{
				//执行添加
				$res = $mod -> insert('collection',$data);
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

	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$where = json_decode(input('WhereJson'),true)['type'];
		$mod = new Common;
		$data = Db::table('collection') -> where('uid',$uid) -> select();

		$arr = [];

		if($where == 'employ')
		{
			if($data)
			{
				foreach ($data as $k => $v) 
				{
					if($v['employ_id'])
					{
						$arr[] = $v;
					}
				}
				return json($arr);
			}else
			{
				return json(['error' => false]);
			}
		}else
		{
			if($data)
			{
				foreach ($data as $k => $v) 
				{
					if($v['skill_id'])
					{
						$arr[] = $v;
					}
				}
				return json($arr);
			}else
			{
				return json(['error' => false]);
			}
		}

		
	}

	/**
	 * 收藏删除
	 */
	public function delete(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$eid= json_decode(input('whereJson'),true)['del_id'];
		$type= json_decode(input('whereJson'),true)['type'];
		$error = array('error'=>false);
		$success = array('success'=>true);
		// return json(['1'=>$id,'2'=>$eid,'3'=>$type]);
	
		$db = new Common;

		if($type == 'employ'){
			
			$del = $db::del('collection',array('uid'=>$id,'employ_id'=>$eid));
			
			if($del){

				return json($success);

			}else{

				return json($error);
				
			}

		}elseif($type == 'skill'){

			$del = $db::del('collection',array('uid'=>$id,'skill_id'=>$eid));
			
			if($del){

				return json($success);

			}else{

				return json($error);
				
			}
		}
	}

	/**
	 * 查询用户收藏技能
	 */
	public function getdate(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$type= json_decode(input('WhereJson'),true)['type'];
		
		$error = array('error'=>false);
		$success = array('success'=>true);
		
		$db = new Common;

		if($type == 'skill'){
			$collection = $db::select('collection',array('uid'=>$uid));

			$data  = [];
			if(!$collection)
			{
				return json(['error' => 'empty']);exit;
			}
			
			foreach ($collection as $k => $v) {

				$skill = $db::select('skill',array('id'=>$v['skill_id']));
				$skillData[] = $skill;
				if($skill){
					foreach ($skill as $key => $value) {
						$info = $db::select('userinfo',array('uid'=>$value['uid']));
			
						foreach ($info as $keys => $values) {
							$time = $value['add_time'];
							$time = strtotime($time);
							$time = friend_date($time);
							$data[] = [
								'id'=>$value['id'],
								'uid'=>$value['uid'],
								'status'=>$value['status'],
								'address'=>$value['address'],
								'time'=>$value['time'],
								'skill_type'=>$value['skill_type'],
								'skill_name'=>$value['skill_name'],
								'skill_price'=>$value['skill_price'],
								'skill_description'=>$value['skill_description'],
								'num'=>$value['num'],
								'unit'=>$value['unit'],
								'skillType'=>$value['skillType'],
								'skill_status'	=>$value['skill_status'],
								'is_delete'=>$value['is_delete'],
								'add_time'=>$time,
								'photo'=>$values['icon']
							];
						}
					}
				}
			}
			if($data)
			{
				return json($data);
			}else
			{
				return json(['error' => 'empty']);
			}
			

		}elseif($type == 'employ'){

			$collection = $db::select('collection',array('uid'=>$uid));

			$data  = [];
			if(!$collection)
			{
				return json(['error' => 'empty']);exit;
			}
			foreach ($collection as $k => $v) {
				if($v['employ_id']){
					// dump($v['employ_id']);
				$employ = $db::select('employ',array('id'=>$v['employ_id']));
				// dump($employ);
				if($employ){
					// array_push($data,$employ);
					foreach ($employ as $key => $value) {
						if($value['employ_id']){
							$info = $db::select('userinfo',array('uid'=>$value['employ_id']));
		
							foreach ($info as $keys => $values) {
								$time = $value['add_time'];
								$time = strtotime($time);
								$time = friend_date($time);
								$data[] = [
									'id'=>$value['id'],
									'employ_id'=>$value['employ_id'],
									'worker_id'=>$value['worker_id'],
									'title'=>$value['title'],
									'task_time'=>$value['task_time'],
									'address'=>$value['address'],
									'description'=>$value['description'],
									'requirement'=>$value['requirement'],
									'type'=>$value['type'],
									'task_tags'=>$value['task_tags'],
									'task_price'=>$value['task_price'],
									'method'=>$value['method'],
									'task_type'	=>$value['task_type'],
									'employ_status'=>$value['employ_status'],
									'review_times'=>$value['review_times'],
									'is_delete'=>$value['is_delete'],
									'add_time'=>$time,
									'photo'=>$values['icon']
								];
							}
						}
					}
				}
			}

			}	
			return json($data);
		}
	}
}