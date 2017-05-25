<?php
namespace app\index\controller;
use app\index\model\Common;
use think\Request;
use think\Db;
class Orders
{
	public function insert(Request $request)
	{
		// return json(input());die;
		
		//生成订单id
		$id = rand_str(); //生成订单id
		$order_num = order_num(); //生成订单号
		$employId = json_decode(input('uid'),true)['id'];//雇主ID
		
		if($employId){

			$employId = json_decode(input('uid'),true)['id'];

		}else{

			$employId = json_decode(input('uid'),true);
			
		}
		$data = json_decode(input('DataJson'),true);

		$mod = new Common;

		//查询任务价格
		$employPrice = $mod -> select('employ',['id' => $data['task_id']]);

		//更新任务状态
		Db::table('employ') -> where('id',$data['task_id']) -> update(['order_progress' => 1]);

		//准备数据
		$data['employ_id'] = $employId;
		$data['id'] = $id;
		$data['order_num'] = $order_num;
		$data['add_time'] = date('Y-m-d H:i:s');
		$data['update_time'] = date('Y-m-d H:i:s');
		$data['order_price'] = $employPrice[0]['task_price'];
		$data['title'] = $employPrice[0]['title'];

		//执行添加
		$res = $mod -> insert('orders',$data);

		//获取能人、雇主姓名
		$employ = $mod -> select('userinfo',['uid' => $data['employ_id']]);
		$employName = $employ[0]['nickname'];
		$worker = $mod -> select('userinfo',['uid' => $data['worker_id']]);
		$workerName = $worker[0]['nickname'];

		if(!$employName)
		{
			$employName = '雇主';
		}

		if(!$workerName)
		{
			$workerName = '能人';
		}

		//初始化合同表、任务进度表、合同关键节点表
		//生成合同ID
		$agreementId = rand_str();
		$agreementData = [
			'id' => $agreementId,
			'orders_id' => $id,
			'num' => order_num(),
			'add_time' => date('Y-m-d H:i:s'),
		];
		$task_progressData = [
			'id' => rand_str(),
			'order_id' => $id,
			'begin_time' => date('Y-m-d H:i:s'),
			'title' => $employName.'邀请了'.$workerName.',等待确认',
			'update_time' => date('Y-m-d H:i:s'),
		];
		$res1 = $mod -> insert('agreement',$agreementData);
		$res2 = $mod -> insert('task_progress',$task_progressData);
		$res3 = $mod -> saves('orders',['id' => $id],['agreement_id' => $agreementId,'update_time' => date('Y-m-d H:i:s')]);

		if($res && $res1 && $res2 && $res3)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//更新订单信息
	public function update(Request $request)
	{
		// return json(input());die;
		$id = json_decode(input('id'),true)['id'];//订单id
		$data = json_decode(input('DataJson'),true);

		//判断支付方式
		$pay = '';
		if(array_key_exists('pay',$data))
		{
			$pay = $data['pay'];
			unset($data['pay']);
		}
		$account = 0;
		if(array_key_exists('account',$data))
		{
			//雇主实付金额
			$account = $data['account'];
			unset($data['account']);
		}
		$data['update_time'] = date('Y-m-d H:i:s');

		//查询能人钱包
		$employId = Db::table('orders') -> where('id',$id) -> find()['employ_id'];
		$employWallet = Db::table('wallet') -> where('uid',$employId) -> find();
		if($account > $employWallet['account'])
		{
			return json(['error' => 'account_error']);exit;//余额不足返回数据
		}

		//执行更新
		$mod = new Common;

		$res = $mod -> saves('orders',['id' => $id],$data);

		//查询订单数据
		$arr = $mod -> select('orders',['id' => $id]);
		$status = $arr[0]['role_status'];

		//获取能人、雇主姓名
		$employ = $mod -> select('userinfo',['uid' => $arr[0]['employ_id']]);
		$employName = $employ[0]['nickname'];
		$worker = $mod -> select('userinfo',['uid' => $arr[0]['worker_id']]);
		$workerName = $worker[0]['nickname'];

		if(!$workerName)
		{
			$workerName = '能人';
		}

		if(!$employName)
		{
			$employName = '雇主';
		}

		//添加任务进度信息
		switch ($status) {
			case '1':
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $workerName.'确认了服务,等待发起电子合同',
					];
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);
					}
					
				break;

			case '2':
					//添加任务进度信息
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $employName.'发起了合同,等待确认电子合同',
					];
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);
					}
				break;

			case '3':
					//添加任务进度信息
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $workerName.'确认了合同,等待雇主支付',
					];
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);
					}

				break;

			case '4':

					//添加任务进度信息
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $employName.'支付了交易佣金,'.$workerName.'即将开始服务',
					];
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);

						//订单价格
						$price = $arr[0]['order_price'];
						

						if($price == $account)
						{
							//添加交易明细
							$skillId = $arr[0]['skill_id'];//技能ID

							//查询技能数据
							$skillData = $mod -> select('skill',['id' => $skillId]);
							$skillName = $skillData[0]['skill_name'];

							$time = date('Y-m-d H:i:s');//交易时间
							$employId = $arr[0]['employ_id'];
							
							//查询钱包数据
							$employWallet = $mod -> select('wallet',['uid' => $employId]);

							//准备雇主数据
							$employData = [
								'id' => rand_str(),
								'uid' => $employId,
								'transaction_account' => '-'.$price,
								'transaction_time' => $time,
								'type' => 2,
								'skill_id' => $skillId,
								'description' => '购买-'.$skillName.'技能',
							];
							if(!$pay)
							{
								$employData['balance'] = $employWallet[0]['account'] - $account;
							}else
							{
								$employData['balance'] = $employWallet[0]['account'];
							}

							//执行添加
							$mod -> insert('wallet_details',$employData);
							if(!$pay)
							{
								//更新钱包数据
								$employAccount = $employWallet[0]['account'] - $price;
								$mod -> saves('wallet',['uid' => $employId],['account' => $employAccount]);
							}
							
						}else
						{
							// 添加异常信息
							$skillId = $arr[0]['skill_id'];//技能ID

							//查询技能数据
							$skillData = $mod -> select('skill',['id' => $skillId]);
							$skillName = $skillData[0]['skill_name'];

							$time = date('Y-m-d H:i:s');//交易时间
							$employId = $arr[0]['employ_id'];

							//准备雇主数据
							$employData = [
								'id' => rand_str(),
								'error_id' => $id,
								'add_time' => $time,
								'error_type' => '订单异常',
								'description' => '购买'.$skillName.'技能交易出错',
							];

							//执行添加
							$mod -> insert('error_log',$employData);

							return json(['error' => 'account_error']);
						}
					}
				break;

			case '5':
					//查询合同数据
					$agreement = $mod -> select('agreement',['orders_id' => $id]);

					$status = $agreement[0]['agreement_status'];
					$str = '';
					if($status == 0)
					{
						$str = '待确认';
					}else if($status == 1)
					{
						$str = '已确认';
					}else
					{
						$str = '已生效';
					}

					//添加任务进度信息
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $employName.'确认了关键进度,合同'.$str,
					];
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);
					}
				break;

			case '6':
					//添加任务进度信息
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $workerName.'确认了服务完毕,'.$employName.'即将验收',
					];
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);
					}
				break;

			case '7':
					//添加任务进度信息
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $employName.'验收了服务,即将同意付款',
					];
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);
					}
				break;

			case '8':

					//添加任务进度信息
					$time = date('Y-m-d H:i:s');
					$progressData = [
						'id' => rand_str(),
						'order_id' => $id,
						'update_time' => $time,
						'title' => $employName.'已同意付款,等待相互评论',
					];

					//更新任务状态
					Db::table('employ') -> where('id',$arr[0]['task_id']) -> update(['order_progress' => 2]);

					//删除申请记录
					Db::table('applicant_list') -> where('employ_id',$arr[0]['task_id']) -> where('applicant_id',$arr[0]['worker_id']) -> delete();
					
					if($res)
					{
						//添加进度
						$mod -> insert('task_progress',$progressData);

						//添加交易明细
						$skillId = $arr[0]['skill_id'];//技能ID

						//查询技能数据
						$skillData = $mod -> select('skill',['id' => $skillId]);
						$skillName = $skillData[0]['skill_name'];

						$account = $arr[0]['order_price'];//交易金额
						$time = date('Y-m-d H:i:s');//交易时间
						$employId = $arr[0]['employ_id'];
						$workerId = $arr[0]['worker_id'];
						
						//查询钱包数据
						$workerWallet = $mod -> select('wallet',['uid' => $workerId]);

						//准备能人数据
						$workerData = [
							'id' => rand_str(),
							'uid' => $workerId,
							'transaction_account' => '+'.$account,
							'transaction_time' => $time,
							'type' => 3,
							'skill_id' => $skillId,
							'balance' => $workerWallet[0]['account'] + $account,
							'description' => '收入-'.$skillName.'技能',
						];

						//执行添加
						$mod -> insert('wallet_details',$workerData);

						//能人
						$workerAccount = $workerWallet[0]['account'] + $account;
						
						$res = $mod -> saves('wallet',['uid' => $workerId],['account' => $workerAccount]);

						if(!$res)
						{
							//添加错误日志
							$arr = [
								'error_id' => $id,
								'id' => rand_str(),
								'add_time' => date('Y-m-d H:i:s'),
								'error_type' => '订单异常',
								'description' => '能人金额更新失败',
							];

							$mod -> insert('error_log',$arr);
						}
					}



				break;
			
			default:
				# code...
				break;
		}

		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取角色状态
	public function getStatus(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//订单id
		$mod = new Common;

		//查询订单表
		$orders = $mod -> select('orders',['id' => $id]);
		$status = $orders[0]['role_status'];
		if($orders)
		{
			return json(['role_status' => $status]);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function get(Request $request)
	{
		$employId = json_decode(input('id'),true)['id'];
		$workerId = json_decode(input('worker_id'),true)['worker_id'];
		$order_num = json_decode(input('order_num'),true)['order_num'];
		$mod = new Common;

		//查询订单数据
		//查询雇主订单
		 if($employId)
		 {
		 	$data = Db::table('orders') -> where('employ_id',$employId) -> where('role_status','<',8) -> select();
		 	$arr = [];
		 	if($data)
		 	{
		 		foreach ($data as $k => $v) 
			 	{
			 		$arr[] = $v['skill_id'];
			 	}

			 	//返回worker_id
		 		return json($arr);
		 	}else
		 	{
		 		return json(['error' => false]);
		 	}
		 }

		 //查询能人订单
		 if($workerId)
		 {
		 	$data = $mod -> select('orders',['worker_id' => $workerId]);
		 	return json($data);
		 }

		 //根据订单号查询单条数据
		 if($order_num)
		 {
		 	$data = $mod -> select('order',['order_num' => $order_num]);
		 	return json($data);
		 }

	}

	//获取总订单数据
	public function getData(Request $request)
	{
		date_default_timezone_set('PRC');
		$uid = json_decode(input('id'),true)['id'];

		// 查询订单数据
		$mod = new Common;
		// $data = $mod -> select('orders',['status' => 0]);
		$data = Db::table('orders') -> where('status',0) -> where('employ_id',$uid) -> whereor('worker_id',$uid) -> order('update_time desc') -> select();

		$arr = [];
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询任务进度
				$progress = $mod -> select('task_progress',['order_id' => $v['id']],'','','','update_time desc');

				if($progress[0]['update_time'])
				{
					$updateTime = strtotime($progress[0]['update_time']);//任务更新时间
					$time = friend_date($updateTime);
					$v['update_time'] = $time;
				}else
				{
					$v['update_time'] = '';
				}
				$v['progress'] = $progress;
				

				//查询工作地点
				$employData = $mod -> select('employ',['id' => $v['task_id']]);
				if($employData[0]['address'])
				{
					$address = $employData[0]['address'];
					$v['address'] = $address;
					$v['account'] = $employData[0]['task_price'];
					$v['begin_time'] = $employData[0]['task_time'];
				}else
				{
					$v['address'] = '';
				}
				

				if($uid == $v['employ_id'])
				{
					$v['role'] = 'employ';//雇主
					$arr[] = $v;
				}else
				{
					$v['role'] = 'worker';//能人
					$arr[] = $v;
				}
			}

			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
		
	}

	//查询进行中订单
	public function getNow(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];

		// 查询订单数据
		$mod = new Common;
		$data = Db::table('orders') 
				-> where('employ_id',$uid)
				-> whereor('worker_id',$uid)
				-> where('status',0) 
				-> order('update_time desc')
				-> select();
		foreach ($data as $k => $v) 
		{
			if($v['role_status'] >= 8)
			{
				unset($data[$k]);
			}
		}
		$arr = [];
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询任务进度
				$progress = $mod -> select('task_progress',['order_id' => $v['id']],'','','','update_time desc');

				if($progress[0]['update_time'])
				{
					$updateTime = strtotime($progress[0]['update_time']);//任务更新时间
					$time = friend_date($updateTime);
					$v['update_time'] = $time;
				}else
				{
					$v['update_time'] = '';
				}
				$v['progress'] = $progress;
				

				//查询工作地点
				$employData = $mod -> select('employ',['id' => $v['task_id']]);
				if($employData[0]['address'])
				{
					$address = $employData[0]['address'];
					$v['address'] = $address;
					$v['account'] = $employData[0]['task_price'];
					$v['begin_time'] = $employData[0]['task_time'];
				}else
				{
					$v['address'] = '';
				}


				if($uid == $v['employ_id'])
				{
					$v['role'] = 'employ';//雇主
					$arr[] = $v;
				}else
				{
					$v['role'] = 'worker';//能人
					$arr[] = $v;
				}
			}

			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//查询已完成订单
	public function getEnd(Request $request)
	{
		// return json(input());die;
		$uid = json_decode(input('id'),true)['id'];//用户id

		// 查询订单数据
		$mod = new Common;
		$data1 = Db::table('orders') 
				-> where('employ_id',$uid)
				-> where('role_status',8)
				-> order('update_time desc')
				-> select();
		$data2 = Db::table('orders') 
				-> where('worker_id',$uid)
				-> where('role_status',8)
				-> order('update_time desc')
				-> select();
		$data = array_merge($data1,$data2);
		
		$arr = [];
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询任务进度
				$progress = $mod -> select('task_progress',['order_id' => $v['id']],'','','','update_time desc');

				if($progress[0]['update_time'])
				{
					$updateTime = strtotime($progress[0]['update_time']);//任务更新时间
					$time = friend_date($updateTime);
					$v['update_time'] = $time;
				}else
				{
					$v['update_time'] = '';
				}
				$v['progress'] = $progress;
				

				//查询工作地点
				$employData = $mod -> select('employ',['id' => $v['task_id']]);
				if($employData[0]['address'])
				{
					$address = $employData[0]['address'];
					$v['address'] = $address;
					$v['account'] = $employData[0]['task_price'];
					$v['begin_time'] = $employData[0]['task_time'];
				}else
				{
					$v['address'] = '';
				}

				if($uid == $v['employ_id'])
				{
					$v['role'] = 'employ';//雇主
					$arr[] = $v;
				}else
				{
					$v['role'] = 'worker';//能人
					$arr[] = $v;
				}
			}

			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//查询已关闭订单
	public function getClosed(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];

		// 查询订单数据
		$mod = new Common;
		$data = Db::table('orders') -> where('status',0) -> where('role_status',9) -> order('update_time desc') -> select();
		$arr = [];
		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询任务进度
				$progress = $mod -> select('task_progress',['order_id' => $v['id']],'','','','update_time desc');

				if($progress[0]['update_time'])
				{
					$updateTime = strtotime($progress[0]['update_time']);//任务更新时间
					$time = friend_date($updateTime);
					$v['update_time'] = $time;
				}else
				{
					$v['update_time'] = '';
				}
				$v['progress'] = $progress;
				

				//查询工作地点
				$employData = $mod -> select('employ',['id' => $v['task_id']]);
				if($employData[0]['address'])
				{
					$address = $employData[0]['address'];
					$v['address'] = $address;
					$v['account'] = $employData[0]['task_price'];
					$v['begin_time'] = $employData[0]['task_time'];
				}else
				{
					$v['address'] = '';
				}

				if($uid == $v['employ_id'])
				{
					$v['role'] = 'employ';//雇主
					$arr[] = $v;
				}else
				{
					$v['role'] = 'worker';//能人
					$arr[] = $v;
				}
			}

			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//查询单条数据
	public function find(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];

		$mod = new Common;

		//查询订单
		$data = $mod -> select('orders',['id' => $id]);

		//查询需求
		$employ = $mod -> select('employ',['id' => $data[0]['task_id']]);
		$title = $employ[0]['title'];
		$description = $employ[0]['description'];
		$address = $employ[0]['address'];
		$time = $employ[0]['task_time'];

		//查询订单进度
		$progressData = $mod -> select('task_progress',['order_id' => $id]);

		//查询电子合同
		$agreement = $mod -> select('agreement',['orders_id' => $id]);
		$agreementName = $agreement[0]['title'];
		$agreementNum = $agreement[0]['num'];

		if($data)
		{
			//准备数据
			$arr = $data[0];
			$arr['task_title'] = $title;//需求名称
			$arr['description'] = $description;//需求简介
			$arr['address'] = $address;//任务工作地点
			$arr['begin_time'] = $time;//任务开始时间
			$arr['progress'] = $progressData;//订单流程
			$arr['agreementname'] = $agreementName;//合同名称
			$arr['agreementnum'] = $agreementNum;//合同编号
			if($arr['order_status'] == 1)
			{
				$arr['order_status'] = '已支付';
			}else
			{
				$arr['order_status'] = '未支付';
			}
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取支付信息
	public function getPay(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//订单ID

		$mod = new Common;

		//查询订单
		$data = $mod -> select('orders',['id' => $id]);
		$title = $data[0]['title'];//订单名称
		$orderNum = $data[0]['order_num'];//订单编号

		//查询任务详情
		$employ = $mod -> select('employ',['id' => $data[0]['task_id']]);
		if($employ[0]['address'])
		{
			$address = $employ[0]['address'];//服务地址
		}else
		{
			$address = '';
		}

		if($employ[0]['description'])
		{
			$description = $employ[0]['description'];
		}else
		{
			$description = '';
		}
		

		//准备数据
		$arr = [
			'title' => $title,//订单名称
			'order_num' => $orderNum,//订单编号
			'address' => $address,//服务地址
			'description' => $description,//描述
			'account' => $data[0]['order_price'],//描述
		];

		return json($arr);
	}

	//获取待结金额
	public function willPay(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//用户ID

		//查询订单数据
		$data = Db::table('orders') -> where('worker_id',$id) -> where('role_status','in','3,4,5,6,7') -> select();

		$mod = new Common;

		foreach ($data as $k => $v) 
		{
			if($id == $v['employ_id'])
			{
				$data[$k]['role'] = 'employ';
			}else
			{
				$data[$k]['role'] = 'worker';
			}
			//查询任务
			$employ = $mod -> select('employ',['id' => $v['task_id']]);
			$data[$k]['address'] = $employ[0]['address'];//工作地点
			$data[$k]['begin_time'] = $employ[0]['task_time'];//任务开始时间

			//查询订单进度
			$progress = Db::table('task_progress') -> where('order_id',$v['id']) -> order('update_time desc') -> select();
			
			$time = $progress[0]['update_time'];//最新节点时间

			$timeData = strtotime($time);

			//显示友好时间
			$data[$k]['update_time'] = friend_date($timeData);
			if(!$data[$k]['update_time'])
			{
				$data[$k]['update_time'] = '';
			}
			$data[$k]['progress'] = $progress;//进度节点
		}
		
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取我的任务详情(能人)
	public function myTask(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//用户ID
		$mod = new Common;
		$data = Db::table('orders') -> where('worker_id',$id) -> order('update_time desc') -> select();
		if(!$data)
		{
			return json(['error' => 'empty']);exit;
		}
		foreach ($data as $k => $v) 
		{
			//查询任务
			$employ = $mod -> select('employ',['id' => $v['task_id']]);
			$data[$k]['address'] = $employ[0]['address'];//工作地点
			$data[$k]['begin_time'] = $employ[0]['task_time'];//任务开始时间

			//查询订单进度
			$progress = Db::table('task_progress') -> where('order_id',$v['id']) -> order('update_time desc') -> select();
			
			$time = $v['update_time'];//最新节点时间

			$timeData = strtotime($time);

			//显示友好时间
			$data[$k]['update_time'] = friend_date($timeData);
			if(!$data[$k]['update_time'])
			{
				$data[$k]['update_time'] = '';
			}
			$data[$k]['progress'] = $progress;//进度节点

			//查询用户详情信息
			$info = $mod -> select('userinfo',['uid' => $id]);
			$pic = $info[0]['icon'];
			$data[$k]['pic'] = $pic;
			$data[$k]['role'] = 'worker';
		}

		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取发布的任务详情(雇主)
	public function mainTask(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//用户ID
		$mod = new Common;
		$data = Db::table('orders') -> where('employ_id',$id) -> order('update_time desc') -> select();

		if(!$data)
		{
			return json(['error' => 'empty']);exit;
		}
		foreach ($data as $k => $v) 
		{
			//查询任务
			$employ = $mod -> select('employ',['id' => $v['task_id']]);
			$data[$k]['address'] = $employ[0]['address'];//工作地点
			$data[$k]['begin_time'] = $employ[0]['task_time'];//任务开始时间

			//查询订单进度
			$progress = Db::table('task_progress') -> where('order_id',$v['id']) -> order('update_time desc') -> select();
			
			$time = $v['update_time'];//最新节点时间

			$timeData = strtotime($time);

			//显示友好时间
			$data[$k]['update_time'] = friend_date($timeData);
			if(!$data[$k]['update_time'])
			{
				$data[$k]['update_time'] = '';
			}
			$data[$k]['progress'] = $progress;//进度节点
			$data[$k]['role'] = 'employ';
		}
		
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//招聘消息(雇主身份)
	public function message(Request $request)
	{
		// return json(input());die;
		$id = json_decode(input('id'),true)['id'];
		$data = Db::table('applicant_list') -> where('uid',$id) -> order('add_time desc') -> select();
		
		if($data)
		{
			//准备数据
			$arr = [];
			foreach ($data as $k => $v) 
			{
				Db::table('applicant_list') -> where('id',$v['id']) -> update(['is_scan' => 1]);
				//查询需求
				$employData = Db::table('employ') -> where('id',$v['employ_id']) -> find();

				//查询技能
				$skillData = Db::table('skill') -> where('id',$v['skill_id']) -> find();

				//查询发布技能者头像信息
				$userinfo = Db::table('userinfo') -> where('uid',$skillData['uid']) -> find();

				$arr[$k] = [
					'title' => $skillData['skill_name'],//标题
					'post' => $skillData['skill_type'],//技能职位
					'content' => $skillData['skill_description'],//技能描述
					'for_post' => $employData['task_type'],//竞聘职位
					'role' => 'employ',
					'photo' => $userinfo['icon'],
					'skill_id' => $skillData['id']

				];
				$arr[$k] = array_merge($data[$k],$arr[$k]);
			}
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//招聘消息(能人身份)
	public function messageWorker(Request $request)
	{
		// return json(input());die;
		$id = json_decode(input('id'),true)['id'];//用户ID
		$data = Db::table('orders') -> where('worker_id',$id) -> order('update_time desc') -> select();

		if($data)
		{
			//准备数据
			$arr = [];
			foreach ($data as $k => $v) 
			{
				Db::table('orders') -> where('id',$v['id']) -> update(['is_scan' => 1]);
				//查询需求
				$employData = Db::table('employ') -> where('id',$v['task_id']) -> find();
				$tags = [];
				if(strstr($employData['task_tags'],','))
				{
					$tags = explode(',',$employData['task_tags']);
				}else
				{
					$tags[] = $employData['task_tags'];
				}

				//查询技能
				$skillData = Db::table('skill') -> where('id',$v['skill_id']) -> find();

				//查询发布需求者头像
				$userinfo = Db::table('userinfo') -> where('uid',$employData['employ_id']) -> find();
			
				$time = strtotime($employData['add_time']);
				$time = friend_date($time);

				$type = $employData['type'];
				if($type == 1)
				{
					$type = '项目制';
				}else
				{
					$type = '独立制';
				}

				$arr[$k] = [
					'order_id' => $v['id'],//订单ID
					'title' => $employData['title'],//标题
					'time' => $time,//发布时间
					'task_tags' => $tags,//任务标签
					'requirement' => $employData['requirement'],//任务要求
					'role' => 'worker',
					'photo' => $userinfo['icon'],
					'type' => $type,//用人类型
					'post' => $employData['task_type'],//邀约职位类型
					'role_status' => $v['role_status'],//角色状态
					'refuse' => $v['refuse'],
					'task_id' => $v['task_id'],
					'uid' => $employData['employ_id']
				];
				
			}
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function isMessage(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$data1 = Db::table('applicant_list') -> where('uid',$id) -> where('is_scan',0) -> order('add_time desc') -> find();
		$data2 = Db::table('orders') -> where('worker_id',$id) -> where('is_scan',0) -> order('update_time desc') -> find();
		if($data1 || $data2)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}
}