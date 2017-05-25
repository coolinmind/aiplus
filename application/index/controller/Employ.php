<?php
namespace app\index\controller;
use app\index\model\Common;
use think\Request;
use think\Db;

class Employ
{
	//发布任务
	public function insert(Request $request)
	{
		$data = input();
		//临时调试代码
		// return json($data);die;
		$uid = json_decode($data['uid'],true)['id'];
		$arr = json_decode($data['DataJson'],true);
		
		$str = implode(',', $arr['task_tags']);
		$arr['task_tags'] = $str;
		$id = rand_str();
		$arr['employ_id'] = $uid;
		$arr['id'] = $id;
		$arr['add_time'] = date('Y-m-d H:i:s');

		//执行添加
		$mod = new Common;
		$res = $mod -> insert('employ',$arr);
		return json(['success' => true]);
	}

	//获取任务需求
	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];

		$type = json_decode(input('DataJson'),true)['type'];//必须
		$arr = Db::table('employ') 
				-> where('employ_id',$uid) 
				-> where('type',$type) 
				-> where('is_delete',0) 
				-> order('add_time desc') 
				-> select();

		if(!$arr)
		{
			return json(['error' => 'delete']);
			exit;
		}
		if($arr)
		{
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取任务类型选项
	public function getSelect(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$res = $mod -> select('task_type');
		if(!$res)
		{
			$str = 'APP下载,刷单,传单派发,问卷调查,快递分拣,商场促销,节目充场,送货员,速递员,搬运工,钟点工,临时工,文员,驾驶员,保洁员,服务员,导购员,保安,销售员,操作工,学徒,临时演员,电话客服,家教,礼仪模特,英语翻译,外语老师,绘画师,美工,动漫设计师,UI/UE设计师,平面设计师,室内设计师,美术设计师,产品经理,广告设计师,软件开发工程师,文案策划师,营养师,花艺师,保姆,月嫂,催乳师,育儿师,摄影师,理发师,美容护理师,健身教练,汽车教练,网红主播,歌手,主持司仪,模特,占卜师,厨师,心理咨询师,撰稿人,婚姻家庭咨询师,汽车维修工,家电维修工,水电工,油漆工,木工';
			$array = explode(',',$str);
			foreach ($array as $k => $v) {
				$mod -> insert('task_type',['select' => $v]);
			}
		}

		//提取并返回数据
		$arr = $mod -> select('task_type');
		$data = [];
		foreach ($arr as $k => $v) {
			$data[] = $v['select'];
		}
		
		return json($data);
	}

	//添加任务标签
	public function insertType(Request $request)
	{
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		$id = rand_str();
		$data['uid'] = $uid;
		$data['id'] = $id;

		//执行添加
		$mod = new Common;

		//查询审核表是否已添加该类别
		$arr = $mod -> select('task_typereview');
		foreach ($arr as $k => $v) 
		{
			if($v['select'] != $data['select'])
			{
				$res = $mod -> insert('task_typereview',$data);
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

	public function find(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];//用户ID
		$data = json_decode(input('DataJson'),true);
		$id = $data['id'];//单条任务id
		$mod = new Common;

		$arr = $mod -> select('employ',['id' => $id,'is_delete' => 0]);
		
		//更新浏览次数
		$mod -> saves('employ',['id' => $id],['review_times' => $arr[0]['review_times'] + 1]);

		//查询用户详情
		$userinfo = $mod -> select('userinfo',['uid' => $arr[0]['employ_id']]);
		$nickname = $userinfo[0]['nickname'];
		$photo = $userinfo[0]['icon'];
		
		//查询申请者列表
		$applicant = $mod -> select('applicant_list',['employ_id' => $id]);

		if($applicant)
		{
			foreach ($applicant as $k => $v) 
			{
				$info = Db::table('userinfo') -> where('uid',$v['applicant_id']) -> find();
				$applicant[$k]['name'] = $info['nickname'];
				$applicant[$k]['icon'] = $info['icon'];
				$applicant[$k]['add_time'] = date('m-d H:i',strtotime($v['add_time']));
				//判断是否点赞
				$supportId = $v['support_id'];

				if(!$supportId)
				{
					$applicant[$k]['action'] = false;
				}else
				{
					$res = strstr($supportId,$uid);
					
					if($res)
					{
						$applicant[$k]['action'] = true;
					}else
					{
						$applicant[$k]['action'] = false;
					}
				}
			}
		}
		
		
		if($applicant)
		{
			$count = count($applicant);
		}else
		{
			$count = 0;
		}

		//准备数据
		$arr[0]['nickname'] = $nickname;//用户昵称
		$arr[0]['photo'] = $photo;//用户头像
		$arr[0]['applicant'] = $applicant;//竞聘者列表
		$arr[0]['count'] = $count;//竞品者个数
		return json($arr[0]);
	}

	//修改任务数据
	public function update(Request $request)
	{
		// return json(input());die;
		$data = json_decode(input('DataJson'),true);
		$id = json_decode(input('id'),true)['id'];
		$res = Db::table('employ') -> where('id',$id) -> update($data);
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
		$data = input();
		$IdJson = json_decode($data['id'],true);
		$id = $IdJson['id'];
		$mod = new Common;
		$res = $mod -> saves('employ',['id' => $id],['is_delete' => 1]);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//按条件查询任务
	public function getData(Request $request)
	{
		// return json(input());die;
		$wheres = json_decode(input('WhereJson'),true);
		$field = json_decode(input('Field'),true)['field'];
		$limit = json_decode(input('Limit'),true)['limit'];
		$order = json_decode(input('OrderJson'),true);
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$limit = $limit.','.'10';
		
		if($wheres){
			$a = implode(',',$wheres['address']);
			$b = implode(',',$wheres['task_type']);
			$c = implode(',',$wheres['settlement_type']);
			// $d = implode(',',$wheres['title']);
			 $where = [
				'address'=>$a,
				'task_type'=>$b,
				'settlement_type'=>$c,
				'title'=>$wheres['title']
			];
			if($order['orderbyChooseList'] == 'ace'){
				if($where['title'] == ''){
					// $data = $mod::select('employ',array('is_delete'=>0));
					$data = Db::table('employ')->where('is_delete',0)->where('employ_status','neq',2)->order('add_time desc')->limit($limit)->select();

					if($data){
						foreach ($data as $k => $v) 
						{
							//查询用户详情
							$userinfo = $mod -> select('userinfo',['uid' => $v['employ_id']]);
							$data[$k]['photo'] = $userinfo[0]['icon'];
							if($v['employ_id'] == $uid)
							{
								unset($data[$k]);
							}
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
				if($where['address'] == '' && $where['task_type'] == '' && $where['settlement_type'] == ''){
					$res = Db::table('employ')
						->where('title','like',"%$where[title]%")
						->where('is_delete',0)
						->where('employ_status','neq',2)
						->order('add_time desc')
						->limit($limit)
						->select();
						$datas = [];
						
					foreach ($res as $k => $v) {

							if($uid == $v['employ_id']){

							 	unset($res[$k]);

							}

						foreach ($res as $keys => $val) {

							$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));

							if($info){

								foreach ($info as $key => $value) {
									$time = $v['add_time'];
									$time = strtotime($time);
									$v['add_time'] = friend_date($time);
									$datas[] = [
										'id'=>$v['id'],
										'employ_id'=>$v['employ_id'],
										'worker_id'=>$v['worker_id'],
										'title'=>$v['title'],
										'task_time'=>$v['task_time'],
										'address'=>$v['address'],
										'description'=>$v['description'],
										'requirement'=>$v['requirement'],
										'type'=>$v['type'],
										'task_tags'=>$v['task_tags'],
										'task_price'=>$v['task_price'],
										'method'=>$v['method'],
										'task_type'=>$v['task_type'],
										'employ_status'=>$v['employ_status'],
										'review_times'=>$v['review_times'],
										'is_delete'=>$v['is_delete'],
										'add_time'=>$v['add_time'],
										'settlement_type'=>$v['settlement_type'],
										'photo'=>$value['icon']
									];
								}
							}
						}
					}

					return json($datas);
				}
			}
		}
		// $data = $mod -> select('employ',['is_delete' => 0]);
		$data = Db::table('employ')->where('employ_status','neq',2)->where('is_delete',0)->order('add_time desc')->where('employ_id','neq',$uid)->limit($limit)->select();
		
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询用户详情
				$userinfo = $mod -> select('userinfo',['uid' => $v['employ_id']]);
				$data[$k]['photo'] = $userinfo[0]['icon'];
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

	//获取进行中任务
	public function getNow(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$type = json_decode(input('DataJson'),true)['type'];
		$mod = new Common;

		$data = $mod -> select('employ',['employ_id' => $uid,'order_progress' => 1,'type' => $type,'is_delete' => 0]);

		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取已完成任务
	public function getEnd(Request $request)
	{
		// return json(input());die;
		$uid = json_decode(input('id'),true)['id'];
		$type = json_decode(input('DataJson'),true)['type'];
		$mod = new Common;

		$data = $mod -> select('employ',['employ_id' => $uid,'order_progress' => 2,'type' => $type,'is_delete' => 0]);
		
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//添加竞品优势时获取任务名称
	public function findTitle(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$data = Db::table('employ') -> where('id',$id) -> find();
		if($data)
		{
			return json(['title' => $data['title']]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//多条件查询
	public function MultiFind(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];//用户ID
		$whereData = json_decode(input('WhereJson'),true)['where'];
		$limit = json_decode(input('Limit'),true)['limit'];
		$limit = $limit.','.'10';
		$data = Db::table('employ')
			-> where('employ_id','neq',$uid) 
			-> where('address','like','%'.$whereData.'%') 
			-> whereOr('task_type','like','%'.$whereData.'%') 
			-> whereOr('title','like','%'.$whereData.'%')
			-> order('add_time desc') 
			-> limit($limit)
			-> select();
		foreach ($data as $k => $v) 
		{
			//查询个人信息
			$info = Db::table('userinfo') -> where('uid',$v['employ_id']) -> find();
			$time = $v['add_time'];
			$time = strtotime($time);
			$time = friend_date($time);
			$data[$k]['add_time'] = $time;
			$data[$k]['nickname'] = $info['nickname'];
			$data[$k]['photo'] = $info['icon'];
		}
		if($data)
		{
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
		if($whereData['task_type'] == '')
		{
			$type = 'like';
			$whereData['task_type'] = '%%';
		}else
		{
			$type = '=';
		}
		
		if($whereData['settlement_type'] == '')
		{
			$settlement = 'like';
			$whereData['settlement_type'] = '%%';
		}else
		{
			$settlement = '=';
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
		$data = Db::table('employ') 
			-> where('employ_id','neq',$uid)
			-> where('address',$address,$whereData['address'])
			-> where('task_type',$type,$whereData['task_type'])
			-> where('settlement_type',$settlement,$whereData['settlement_type'])
			-> order($whereData['order'])
			-> limit($limit)
			-> select();
			
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询个人信息
				$info = Db::table('userinfo') -> where('uid',$v['employ_id']) -> find();
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