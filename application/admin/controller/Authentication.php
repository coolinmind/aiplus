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
class Authentication  extends CommonsController
{
	public function index()
	{	
		$db = new Common;

		$res = $db::select('authentication');
		// dump($res);	
		return view('/authentication/index',['list'=>$res]);
	}

	/**
	 * 修改个人信息页面
	 */
	public function edit(Request $request)
	{
		$id = $request->param('id');

		if(!$id){

			session::flash('tis1',2); 

            return $this->redirect("/admin/authentication/index");
		}

		$db = new Common;

		$res = $db::select('authentication',array('id'=>$id));

		if($res){

			return view('/authentication/edit',['res'=>$res[0]]);

		}else{

			session::flash('tis1',2); 

            return $this->redirect("/admin/authentication/index");
		}
	}

	/**
	 * 将修改信息数据提交到数据库
	 */
	public function update(Request $request)
	{
		$status = $request->param();

		if(!$status){

			session::flash('tis1',2); 

            return $this->redirect("/admin/authentication/index");

		}

		$id = array_pop($status);

		$db = new Common;

		$res = $db::saves('authentication',array('id'=>$id),$status);

		if($res){

			session::flash('tis1',1); 

            return $this->redirect("/admin/authentication/index");

		}else{

			session::flash('tis1',2); 

            return $this->redirect("/admin/authentication/index");

		}
	}
}