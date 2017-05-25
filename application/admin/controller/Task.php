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

class Task extends CommonsController
{
	/**
	 *  任务待审核列表 task_typereview
	 * 
	 */
	public function task_typereview()
	{	
		$db = new Common;

		$res = $db::select('task_typereview');

		// dump($res[0]);
		return view('/task_type/task_typereview',['res'=>$res]);
	}

	/**
	 * 	待核审任务提交
	 */
	public function submit(Request $request)
	{
		$id = $request->param('id');

		if(!$id){

			session::flash('tis',2); 

        	return $this->redirect("/admin/task_typereview/list"); 

		}

		$db = new Common;

		$info = $db::select('task_typereview',array('id'=>$id)); 
		// dump($info);
		if($info){
			$str_id = rand_str();

			$data = [
				'id'=>$str_id,
				'select'=>$info[0]['select']
			];
			// dump($data);
			$res = $db::insert('task_type',$data);

			if($res){

				$del = $db::del('task_typereview',array('id'=>$id));

				if($del){

					session::flash('tis',1); 

        			return $this->redirect("/admin/task_typereview/list");

				}else{

					session::flash('tis',2); 

        			return $this->redirect("/admin/task_typereview/list");
				}

			}else{

				session::flash('tis',2); 

        		return $this->redirect("/admin/task_typereview/list"); 
			}

		}else{

			session::flash('tis',2); 

        	return $this->redirect("/admin/task_typereview/list"); 
		}
		
	}

	/**
	 * 技能类型列表展示
	 */
	public function task_type()
	{
		$db = new Common;

		$list = Db::table('task_type') -> select();
		$array = [];
		foreach ($list as $k => $v) 
		{
			$array[] = ['id' => $v['id'],'pid' => $v['pid'],'name' => $v['select']];
		}
		
		function formatTree($array, $pid = 0){
		 $arr = array();
		 $tem = array();
		 foreach ($array as $v) {
		  if ($v['pid'] == $pid) {
		   $tem = formatTree($array, $v['id']);
		   //判断是否存在子数组
		   $tem && $v['son'] = $tem;
		   $arr[] = $v;
		  }
		 }
		 return $arr;
		}
		$list = formatTree($array);
		return view('/task_type/task_type',['list'=>$list]);

	}

	/**
	 * 技能类型修改页面
	 */
	public function edit(Request $request)
	{
		$id = $request->param('id');

		if(!$id){

			session::flash('tis',2); 

            return $this->redirect("/admin/task_type/list"); 

		}

		$db = new Common;

		$content = $db::select('task_type',array('id'=>$id));

		if($content){

			return view('/task_type/edit',['data'=>$content[0]]);

		}
	}

	/**
	 * 技能类型数据修改
	 */
	public function update(Request $request)
	{
		$content = $request->param();

		if(!$content){

			session::flash('tis',2); 

            return $this->redirect("/admin/task_type/list");

		}

		$db = new Common;

		$data = [
			'select'=>$content['select'],
		];

		$res = $db::saves('task_type',array('id'=>$content['id']),$data);

		if($res){

			session::flash('tis',1); 

        	return $this->redirect("/admin/task_type/list"); 

		}else{

			session::flash('tis',2); 

        	return $this->redirect("/admin/task_type/list"); 
		}
	}

	/**
	 * 任务类型数据删除
	 */
	public function delete(Request $request)
	{
		$id = $request->param('id');

		if(!$id){

			session::flash('tis',2); 

        	return $this->redirect("/admin/task_type/list"); 
		}

		$db = new Common;

		$del = $db::del('task_type',array('id'=>$id));

		if($del){

			session::flash('tis',1); 

        	return $this->redirect("/admin/task_type/list"); 

		}else{

			session::flash('tis',2); 

        	return $this->redirect("/admin/task_type/list"); 
		}
	}

	public function insert(Request $request)
	{
		$data = input();
		$res = Db::table('task_type') -> insert($data);
		if($res)
		{
			return '添加成功';
		}else
		{
			return '添加失败';
		}
	}

}