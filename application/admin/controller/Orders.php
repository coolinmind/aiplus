<?php 
namespace app\admin\controller;
use think\View;
use app\admin\model\Common;
use think\Db;
use think\Paginator;
use think\Controller;
use think\Session;
use app\admin\controller\CommonsController;
use think\Request;

class Orders extends CommonsController
{
	public function index()
	{
		$ord = new Common;

		$res = $ord::select('orders');
		// dump($username);
		return view('/orders/index',['res'=>$res]);
		
	}

	/**
	 * 展示修改页面
	 */
	public function edit(Request $request)
	{
		$id = $request->param('id');
		if(!$id){
			session::flash('tis',2); 

            return $this->redirect("/admin/orders/index");
		}

		$ord = new Common;

		$res = $ord::select('orders',['id'=>$id]);
		// dump($res);
		return view('/orders/edit',['res'=>$res[0]]);

	}

	/**
	 * 更新订单状态
	 */
	public function update(Request $request)
	{
		$data = $request->param();
		// dump($data);exit;
		if(!$data){
			session::flash('tis',2); 

            return $this->redirect("/admin/orders/index");
		}
		$info = [
			'order_num'=>$data['order_num'],
			'title'=>$data['title'],
			'role_status'=>$data['role_status'],
			'status'=>$data['status'],
			'add_time'=>$data['add_time'],
			'order_price'=>$data['order_price'],
			'task_id'=>$data['task_id'],
			'skill_id'=>$data['skill_id']
		];
		$ord = new Common;
		$res = $ord::saves('orders',array('id'=>$data['id']),$info);
		if($res){
			session::flash('tis',1); 

            return $this->redirect("/admin/orders/index");
		}else{
			session::flash('tis',2); 

            return $this->redirect("/admin/orders/index");
		}
	}

	/**
	 * 创建订单页
	 */
	public function create()
	{
		return view('/orders/create');
	}

	/**
	 * 创建订单数据
	 */
	public function insert(Request $request)
	{
		$content = $request->param();
		// dump($content['task_id'] );exit;
		if($content['task_id'] == '' && $content['employ_id'] == '' && $content['worker_id'] == '' && $content['title'] == '' && $content['order_price'] == '' && $content['task_id'] == '' && $content['skill_id'] == ''){

			session::flash('tis',2); 

            return $this->redirect("/admin/orders/index");
		}

		// dump($content);
		//生成订单id
		$id = rand_str(); //生成订单id
		$order_num = order_num(); //生成订单号
		// $employId = json_decode(input('uid'),true)['id'];
		// dump($employId);
		// if($employId){

		// 	$employId = json_decode(input('uid'),true)['id'];

		// }else{

		// 	$employId = json_decode(input('uid'),true);
			
		// }
		// $data = json_decode(input('DataJson'),true);

		//准备数据
		$data['employ_id'] = $content['employ_id'];
		$data['id'] = $id;
		$data['worker_id'] = $content['worker_id'];
		$data['title'] = $content['title'];
		$data['order_price'] = $content['order_price'];
		$data['task_id'] = $content['task_id'];
		$data['skill_id'] = $content['skill_id'];
		$data['order_num'] = $order_num;
		$data['add_time'] = date('Y-m-d H:i:s');

		//执行添加
		$mod = new Common;
		$res = $mod -> insert('orders',$data);

		//初始化合同表、任务进度表、合同关键节点表
		//生成合同ID
		$agreementId = rand_str();
		$agreementData = [
			'id' => $agreementId,
			'orders_id' => $id,
			'num' => order_num(),
		];
		$task_progressData = [
			'id' => rand_str(),
			'order_id' => $id,
		];
		$key_nodeData = [
			'id' => rand_str(),
			'agreement_id' => $agreementId,
		];
		$res1 = $mod -> insert('agreement',$agreementData);
		$res2 = $mod -> insert('task_progress',$task_progressData);
		$res3 = $mod -> insert('key_node',$key_nodeData);

		if($res && $res1 && $res2 && $res3){

			session::flash('tis',1); 

            return $this->redirect("/admin/orders/index");

		}else{

			session::flash('tis',2); 

            return $this->redirect("/admin/orders/index");

		}
	}
}