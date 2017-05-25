<?php
namespace app\index\Controller;
use think\Request;
use think\Db;
use app\index\model\Common;
class Skill
{
	//发布技能
	public function insert(Request $request)
	{
		date_default_timezone_set('PRC');
		$data = input();
		//临时调试代码
		// return json($data);die;
		$uid = json_decode($data['uid'],true)['id'];
		$arr = json_decode($data['DataJson'],true);
		$id = rand_str();
		$arr['uid'] = $uid;
		$arr['id'] = $id;
		$arr['add_time'] = date('Y-m-d H:i:s');
		$CategoryId = rand_str();

		//执行添加
		$mod = new Common;
		if(!array_key_exists('projectid',$arr) && !array_key_exists('certificateid',$arr))
		{
			$r = $mod -> insert('skill',$arr);
			
			//提取数据
			$arr = $mod -> select('skill',['id' => $id]);
			return json(['id' => $arr[0]['id']]);
			exit;
		}

		if($arr['certificateid'] && $arr['projectid'])
		{
			$projectid = $arr['projectid'];
			$certificateid = $arr['certificateid'];
			unset($arr['projectid']);
			unset($arr['certificateid']);
			$r = $mod -> insert('skill',$arr);
			
			//更新技能表关联项目经验ID
			$mod -> saves('skill',['id' => $id],['project_id' => $projectid]);

			//更新技能表证书技能ID
			$mod -> saves('skill',['id' => $id],['certificate_id' => $certificateid]);

			//证书审核状态查询
			$status = $mod -> select('certificate',['id' => $certificateid]);

			//提取数据
			$arr = $mod -> select('skill',['id' => $id]);
			return json(['id' => $arr[0]['id'],'status' => $status[0]['status']]);
		}

		if($arr['projectid'] != '')
		{
			$projectid = $arr['projectid'];
			unset($arr['projectid']);
			unset($arr['certificateid']);
			$r = $mod -> insert('skill',$arr);

			//更新技能表关联项目经验ID
			$mod -> saves('skill',['id' => $id],['project_id' => $projectid]);

			//提取数据
			$arr = $mod -> select('skill',['id' => $id]);
			return json(['id' => $arr[0]['id']]);
		}
		if($arr['certificateid'] != '') 
		{
			$certificateid = $arr['certificateid'];
			unset($arr['certificateid']);
			unset($arr['projectid']);
			$r = $mod -> insert('skill',$arr);

			//更新技能表证书技能ID
			$mod -> saves('skill',['id' => $id],['certificate_id' => $certificateid]);

			//提取数据
			$arr = $mod -> select('skill',['id' => $id]);

			//证书审核状态查询
			$status = $mod -> select('certificate',['id' => $arr[0]['certificate_id']]);
			return json(['id' => $arr[0]['id'],'status' => $status[0]['status']]);
		}
	}

	public function update(Request $request)
	{
		//临时调试代码
		// return json(input());die;
		$data = input();
		$data = json_decode(input('DataJson'),true);
		$id = json_decode(input('id'),true)['id'];

		if(array_key_exists('skill_status',$data))
		{
			// 技能任务状态:0接单中、1为工作中、2为下架中
			switch ($data['skill_status']) 
			{
				case '接单中':
					$data['skill_status'] = 0;
					break;

				case '工作中':
					$data['skill_status'] = 1;
					break;

				case '下架中':
					$data['skill_status'] = 2;
					break;
				
				default:
					# code...
					break;
			}
		}
		$mod = new Common;
		$res = $mod -> saves('skill',['id' => $id],$data);
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
		//临时调试代码
		// return json($data);die;
		$uid = json_decode(input('id'),true)['id'];
		$skillType = json_decode($data['WhereJson'],true)['skilltype'];
		
		$arr = Db::table('skill')
				-> where('uid',$uid)
				-> where('skillType',$skillType)
				-> where('is_delete',0)
				-> order('add_time desc')
				-> select();
		if(!$arr)
		{
			return json(['error' => 'delete']);
			exit;
		}

		// 技能任务状态:0接单中、1为工作中、2为下架中
		foreach ($arr as $k => $v) {
			if($v['skill_status'] == 0)
			{
				$arr[$k]['skill_status'] = '接单中';
			}else if ($v['skill_status'] == 1) 
			{
				$arr[$k]['skill_status'] = '工作中';
			}else
			{
				$arr[$k]['skill_status'] = '已下架';
			}
		}

		if($arr)
		{
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//删除技能信息
	public function delete(Request $request)
	{
		// return json(input());die;
		$id = json_decode(input('id'),true)['id'];
		$res = Db::table('skill') -> where('id',$id) -> update(['is_delete' => 1]);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取单条技能数据
	public function find(Request $request)
	{
		// return json(input());die;
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$arr = $mod -> select('skill',['id' => $id]);

		//更新浏览次数
		$num = $arr[0]['review_times'];
		Db::table('skill') -> where('id',$id) -> update(['review_times' => $num + 1]);

		//查询项目经验
		$proExperience = $mod -> select('proExperience',['id' => $arr[0]['project_id']]);

		//查询证书信息
		$certificate = $mod -> select('certificate',['id' => $arr[0]['certificate_id']]);

		//查询用户id
		$skill = $mod -> select('skill',['id' => $id]);
		$uid = $skill[0]['uid'];

		//查询用户工作经验
		$experience = $mod -> select('experience',['uid' => $uid],'','','','','entry desc');

		//查询用户昵称
		$userinfo = $mod -> select('userinfo',['uid' => $uid]);
		$nickname = $userinfo[0]['nickname'];
		$photo = $userinfo[0]['icon'];

		//查询学历信息
		$degree = Db::table('degree') -> where('uid',$uid) -> order('to_school desc') -> find();
		if(!$degree)
		{
			$degree = 'empty';
		}

		//查询评论信息
		$order = Db::table('orders') -> where('skill_id',$id) -> select();
		$comment = [];
		foreach ($order as $k => $v) 
		{
			$carr = Db::table('order_comment') -> where('type',0) -> where('order_id',$v['id']) -> order('add_time desc') -> select();
			$comment = array_merge($comment,$carr);
		}
		
		foreach ($comment as $k => $v) 
		{
			//查询用户信息
			$info = Db::table('userinfo') -> where('uid',$v['from_uid']) -> find();
			$comment[$k]['icon'] = $info['icon'];
			$comment[$k]['nickname'] = $info['nickname'];
			
		}
		
		if($order && $comment)
		{
			$arr[0]['comment'] = $comment;
		}else
		{
			$arr[0]['comment'] = '';
		}
		if($arr)
		{	
			$arr[0]['certificate'] = $certificate[0];
			$arr[0]['experience'] = $experience[0];
			$arr[0]['proExperience'] = $proExperience[0];
			$arr[0]['nickname'] = $nickname;
			$arr[0]['photo'] = $photo;
			$arr[0]['uid'] = $skill[0]['uid'];
			$arr[0]['degree'] = $degree;
			return json($arr[0]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//按条件查询技能
	public function getData(Request $request)
	{
		// return json(input());die;
		$wheres = json_decode(input('WhereJson'),true);
		$field = json_decode(input('Field'),true)['field'];
		$limit = json_decode(input('Limit'),true)['limit'];
		$order = json_decode(input('OrderJson'),true);
		$limit = $limit.','.'10';
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		// return json($wheres);
		// $wheres = $request->param();
		if($wheres){
			$a = implode(',',$wheres['address']);
			$b = implode(',',$wheres['skill_type']);
			$c = implode(',',$wheres['unit']);
	

			// $where = [
			// 	'address'=>$wheres['address'],
			// 	'skill_type'=>'',
			// 	// 'unit'=>'',
			// 	// 'skill_name'=>$wheres['skill_name']
			// ];
			 $where = [
				'address'=>$a,
				'skill_type'=>$b,
				'unit'=>$c,
				'skill_name'=>$wheres['skill_name']
			];
			// return json($where);
			// $order['orderbyChooseList'] == 'ace';
			if($order['orderbyChooseList'] == 'ace'){
				
				if($where['skill_name'] == ''){

					// $data = $mod -> select('skill',array('is_delete'=>0));
					$data = Db::table('skill')
							->where('uid','neq',$uid)
							->where('is_delete',0)
							->where('skill_status','neq',2)
							->limit($limit)
							->order('add_time desc')->select();
					
					if($data){
						foreach ($data as $k => $v) 
						{
							//查询用户详情
							$userinfo = $mod -> select('userinfo',['uid' => $v['uid']]);
							$data[$k]['photo'] = $userinfo[0]['icon'];
							$data[$k]['sex'] = $userinfo[0]['sex'];
						}
						$arr = [];
						foreach ($data as $k => $v) {
							$time = $v['add_time'];
							$time = strtotime($time);
							$v['add_time'] = friend_date($time);
							$arr[] = $v;
						}
						return json($arr);
					}else{
						return json(['error' => false]);
					}
				}	

				if($where['address'] == '' && $where['skill_type'] == '' && $where['unit'] == ''){
					$res = Db::table('skill')
						->where('skill_name','like',"%$where[skill_name]%")
						->where('is_delete',0)
						->where('uid','neq',$uid)
						->where('skill_status','neq',2)
						->order('add_time desc')
						->limit($limit)
						->select();
						$datas = [];
					foreach ($res as $k => $v) {
						
						foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['uid']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {
										$time = strtotime($v['add_time']);
										$time = friend_date($time);
										$datas[] = [
											'id'=>$v['id'],
											'uid'=>$v['uid'],
											'status'=>$v['status'],
											'address'=>$v['address'],
											'time'=>$v['time'],
											'skill_type'=>$v['skill_type'],
											'skill_name'=>$v['skill_name'],
											'skill_price'=>$v['skill_price'],
											'skill_description'=>$v['skill_description'],
											'num'=>$v['num'],
											'unit'=>$v['unit'],
											'skillType'=>$v['skillType'],
											'skill_status'=>$v['skill_status'],
											'is_delete'=>$v['is_delete'],
											'add_time'=>$time,
											'photo'=>$value['icon'],
											'sex' => $v['sex'],
											'nickname' => $v['nickname'],

										];
									}
								}
							}
						}
					return json($datas);
				}
			}
		}

		// $data = $mod -> select('skill',array('is_delete'=>0));
		$data = Db::table('skill')
				->limit($limit)
				->where('is_delete',0)
				->where('uid','neq',$uid)
				->order('add_time desc')
				->where('skill_status','neq',2)
				->select();

		if($data){
			foreach ($data as $k => $v) 
			{
				//查询用户详情
				$userinfo = $mod -> select('userinfo',['uid' => $v['uid']]);
				$data[$k]['photo'] = $userinfo[0]['icon'];
				$data[$k]['sex'] = $userinfo[0]['sex'];
				$data[$k]['nickname'] = $userinfo[0]['nickname'];
			}
			$arr = [];
			foreach ($data as $k => $v) {
				$arr[] = $v;
			}
			
			
			return json($arr);
		}else{
			return json(['error' => false]);
		}
	}

	//多条件搜索(或)
	public function MultiFind(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];//用户ID
		$whereData = json_decode(input('WhereJson'),true)['where'];
		$limit = json_decode(input('Limit'),true)['limit'];
		$limit = $limit.','.'10';
		$data = Db::table('skill')
			-> where('uid','neq',$uid) 
			-> where('address','like','%'.$whereData.'%') 
			-> whereOr('skill_type','like','%'.$whereData.'%') 
			-> whereOr('skill_name','like','%'.$whereData.'%')
			-> where('is_delete',0)
			-> order('add_time desc') 
			-> limit($limit)
			-> select();
		
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询个人信息
				$info = Db::table('userinfo') -> where('uid',$v['uid']) -> find();
				$time = $v['add_time'];
				$time = strtotime($time);
				$time = friend_date($time);
				$data[$k]['add_time'] = $time;
				$data[$k]['nickname'] = $info['nickname'];
				$data[$k]['photo'] = $info['icon'];
			}
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//多条件搜索(与)
	public function UnionFind()
	{
		// return json(input());die;
		$uid = json_decode(input('id'),true)['id'];//用户ID

		$whereData = json_decode(input('whereJson'),true);
		$limit = $whereData['limit'];
		$limit = $limit.','.'10';
		//判断各字段是否为空
		if($whereData['address'] == '')
		{
			$address = 'like';
			$whereData['address'] = '%%';
		}else
		{
			$address = '=';
		}
		if($whereData['skill_type'] == '')
		{
			$type = 'like';
			$whereData['skill_type'] = '%%';
		}else
		{
			$type = '=';
		}
		
		if($whereData['unit'] == '')
		{
			$unit = 'like';
			$whereData['unit'] = '%%';
		}else
		{
			$unit = '=';
		}
		if($whereData['order'])
		{
			switch ($whereData['order']) 
			{
				case '默认排序':
					$whereData['order'] = '';
					break;

				case '最新':
					$whereData['order'] = 'add_time desc';
					break;

				case '最热':
					$whereData['order'] = 'review_times desc';
					break;

				case '财运值最高':
					# code...
					break;

				
				default:
					# code...
					break;
			}
		}
		$data = Db::table('skill') 
			-> where('uid','neq',$uid)
			-> where('address',$address,$whereData['address'])
			-> where('skill_type',$type,$whereData['skill_type'])
			-> where('unit',$unit,$whereData['unit'])
			-> where('is_delete',0)
			-> order($whereData['order'])
			-> limit($limit)
			-> select();
			
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询个人信息
				$info = Db::table('userinfo') -> where('uid',$v['uid']) -> find();
				$time = $v['add_time'];
				$time = strtotime($time);
				$time = friend_date($time);
				$data[$k]['add_time'] = $time;
				$data[$k]['nickname'] = $info['nickname'];
				$data[$k]['photo'] = $info['icon'];
			}
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}
}