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
class Employ extends CommonsController
{
	public function index()
	{
		$employ = new Common;
		
		$list = $employ::select('employ');

		return view('/employ/index',['list'=>$list]);

	}

	/**
	 * 需求更新页面 
	 */
	public function edit(Request $request)
	{
		$id = $request->param('id');
		if(!$id){
			session::flash('tis1',2); 

            return $this->redirect("/admin/employ/index"); 
		}

		$employ = new Common;
		$list = $employ::select('employ',array('id'=>$id));
		if($list){
			return view('/employ/edit',['res'=>$list[0]]);

		}else{
			session::flash('tis1',2); 

            return $this->redirect("/admin/employ/index"); 
		}
	}

	/**
	 * 需求更改
	 */
	public function update(Request $request)
	{
		$data = $request->param();
		if(!$data){
			session::flash('tis1',2); 

            return $this->redirect("/admin/employ/index"); 
		}
		$id = array_pop($data);
		$employ = new Common;
		$res = $employ::saves('employ',array('id'=>$id),$data);
		if($res){
			session::flash('tis1',1); 

            return $this->redirect("/admin/employ/index"); 
		}else{
			session::flash('tis11',2); 

            return $this->redirect("/admin/employ/edit?id=$id"); 
		}
	}

	/**
	 * 需求删除
	 */
	public function del(Request $request)
	{
		$id = $request->param('id');
		if(!$id){
			session::flash('tis1',2); 

            return $this->redirect("/admin/employ/index"); 
		}

		$employ = new Common;
		$res = $employ::del('employ',['id'=>$id]);
		if($res){
			session::flash('tis1',1); 

            return $this->redirect("/admin/employ/index"); 
		}else{
			session::flash('tis1',2); 

            return $this->redirect("/admin/employ/index"); 
		}
	}
}