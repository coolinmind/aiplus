<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use app\index\model\Common;
class Agreement
{
	public function update(Request $request)
	{
		// return json(input());die;
		$data = json_decode(input('DataJson'),true);
		$id = json_decode(input('id'),true)['id'];//合同ID
		$mod = new Common;
		if(!array_key_exists('agreement_price',$data))
		{
			//查询合同价格
			$agreementData = $mod -> select('agreement',['id' => $id]);
			$data['agreement_price'] = $agreementData[0]['agreement_price'];
		}

		$data['update_time'] = date('Y-m-d H:i:s');

		//更新合同数据
		$res = $mod -> saves('agreement',['id' => $id],$data);

		//更新订单信息
		$res1 = $mod -> saves('orders',['agreement_id' => $id],['order_price' => $data['agreement_price'],'update_time' => date('Y-m-d H:i:s')]);

		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}


	//添加任务节点
	public function insert(Request $request)
	{
		// return json(input());die;
		$data = json_decode(input('DataJson'),true);
		$id = rand_str();
		$data['id'] = $id;
		$mod = new Common;
		$res = $mod -> insert('key_node',$data);
		if($res)
		{
			return json(['success' => true,'id' => $id]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取合同中的默认信息
	public function get(Request $request)
	{
		$agreementId = json_decode(input('id'),true)['id'];
		$mod = new Common;

		//查询订单
		$orders = $mod -> select('orders',['agreement_id' => $agreementId]);
	
		$taskId = $orders[0]['task_id'];//任务ID
		$employId = $orders[0]['employ_id'];
		$workerId = $orders[0]['worker_id'];

		//查询详情
		$employInfo = $mod -> select('userinfo',['uid' => $employId]);
		$employName = $employInfo[0]['realname'];
		if(!$employName)
		{
			$employName = '';
		}
		$workerInfo = $mod -> select('userinfo',['uid' => $workerId]);
		$workerName = $workerInfo[0]['realname'];
		if(!$workerName)
		{
			$workerName = '';
		}

		//查询任务
		$employ = $mod -> select('employ',['id' => $taskId]);

		if($employ)
		{
			$description = $employ[0]['description'];//任务简介
			$requirement = $employ[0]['requirement'];//任务需求
			$title = $employ[0]['title'];//需求名称
		}else
		{
			$description = '';//任务简介
			$requirement = '';//任务需求
			$title = '';//需求名称
		}
		

		//查询竞聘优势
		$advantageData = $mod -> select('applicant_list',['employ_id' => $taskId,'applicant_id' => $workerId,'uid' => $employId]);

		if($advantageData)
		{
			$advantage = $advantageData[0]['content'];//竞聘优势
		}else
		{
			$advantage = '';//竞聘优势
		}
		

		//准备数据
		$data = [
			'title' => $title.'电子合同',//合同标题
			'employname' => $employName,//甲方姓名
			'workername' => $workerName,//乙方姓名
			'description' => $description,//任务简介
			'requirement' => $requirement,//任务需求
			'advantage' => $advantage,//竞聘优势
		];
		
		$data = array_merge($data,$employ[0]);
		return json($data);

	}

	//读取合同数据
	public function find(Request $request)
	{
		// return json(input());die;
		$id = json_decode(input('id'),true)['id'];//合同id
		$mod = new Common;
		$data = $mod -> select('agreement',['id' => $id]);
		
		//查询合同节点
		$node = $mod -> select('key_node',['agreement_id' => $id]);

		//查询订单
		$order = Db::table('orders') -> where('id',$data[0]['orders_id']) -> find();

		//查询竞品优势
		$advantage = Db::table('applicant_list') -> where(['uid' => $order['employ_id'],'employ_id' => $order['task_id'],'applicant_id' => $order['worker_id'],'skill_id' => $order['skill_id']]) -> find();

		//准备数据
		$arr = $data[0];
		$arr['advantage'] = $advantage['content'];
		if($node)
		{
			$arr['key_node'] = $node;
		}else
		{
			$arr['key_node'] = '';
		}


		//返回数据
		if($data)
		{
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function delNode(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$res = Db::table('key_node') -> where('id',$id) -> delete();
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}
}