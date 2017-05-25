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

class Accounts extends CommonsController
{
	/**
	 * 卡号管理列表页
	 */
	public function index()
	{
		$db = new Common;

		$list = $db::select('accounts');

		return view('accounts/index',['list'=>$list]);

	}

	/**
	 * 卡号管理修改页面
	 */
	public function edit(Request $request)
	{
		$id = $request->param('id');

		if(!$id){

			session::flash('tis',2); 

            return $this->redirect("/admin/accounts/index");

		}

		$db = new Common;

		$res = $db::select('accounts',array('id'=>$id));

		return  view('/accounts/edit',['res'=>$res[0]]);

	}

	/**
	 * 卡号管理修改数据提交
	 */
	public function update(Request $request)
	{
		$info = $request->param();

		if(!$info){

			ession::flash('tis',2); 

            return $this->redirect("/admin/accounts/index");
		}

		$db = new Common;
		$id = array_pop($info);
		// dump($info);
		$res = $db::saves('accounts',array('id'=>$id),$info);
		
		if($res){

			session::flash('tis',1); 

            return $this->redirect("/admin/accounts/index");

		}else{

			session::flash('tis',2); 

            return $this->redirect("/admin/accounts/index");

		}
	}
}