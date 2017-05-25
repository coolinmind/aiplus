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
class Admin extends CommonsController
{
	public function index()
	{
	
		$res = Db::table('admin')
		->alias('a')
		->field(['a.id','role.names','a.name','a.rid'])
		->join('role w','w.id = a.rid ')
		->select();
		// dump($res);
		$admin = new Common;
		$row = $admin::select('role');
		// dump($row);
		return view('admin',['res'=>$res,'row'=>$row]);
	}

	/**
       * 管理员添加
       */
	public function add(Request $request)
	{
		$info = $request->param();
		if(!$info){
			session::flash('tishi',2); 
            return $this->redirect("/admin/admin");
		}
		$admin = new Common;
		$info['password'] = sha1($info['password']);
		$res = $admin::insert('admin',$info);
		if($res){
			session::flash('tishi',1); 
            return $this->redirect("/admin/admin");
		}else{
			session::flash('tishi',2); 
            return $this->redirect("/admin/admin");
		}
	}

	/**
       * 管理员删除 但admin用户不能删除
       */
	public function del(Request $request)
	{
		$id = $request->param();
		// dump($id);
		if(!$id){
			session::flash('tishi',2); 
            return $this->redirect("/admin/admin");
		}

		if($id['id'] == 1){
			session::flash('tishi',3); 
            return $this->redirect("/admin/admin");
		}

		$admin = new Common;
		$del = $admin::del('admin',$id);
		if($del){
			session::flash('tishi',1); 
            return $this->redirect("/admin/admin");
		}else{
			session::flash('tishi',2); 
            return $this->redirect("/admin/admin");
		}
	}

	/**
       * 管理员修改页面展示
       */
	public function uppage(Request $request)
	{
		$id = $request->param();
		// dump($id);exit;

		if(!$id){

			session::flash('tishi',2); 

            return $this->redirect("/admin/admin");
		}

		$admin = new Common;

		$res = $admin::select('admin',$id);
		// dump($res);
		$row = $admin::select('role');
		// dump($res[0]['rid']);
		return view('update',['res'=>$res,'row'=>$row,'id'=>$res[0]['rid']]);
	}

	/**
       * 管理员修改
       */
	public function updates(Request $request)
	{
		$upinfo = $request->param();

		if(!$upinfo){

			session::flash('tishi',2); 

            return $this->redirect("/admin/adminuppage?id=$upinfo[id]");
		}

		if($upinfo['password'] == '******'){
			$admin = new Common;
			$res = $admin::saves('admin',array('id'=>$upinfo['id']),array('rid'=>$upinfo['rid']));
			if($res){

				session::flash('tishi',1); 

	            return $this->redirect("/admin/admin");
			}else{
				session::flash('tishi',2); 

	            return $this->redirect("/admin/adminuppage?id=$upinfo[id]");
			}
		}else{
			$admin = new Common;
			$res = $admin::saves('admin',array('id'=>$upinfo['id']),array('rid'=>$upinfo['rid'],'password'=>$upinfo['password']));
			if($res){

				session::flash('tishi',1); 

	            return $this->redirect("/admin/admin");
			}else{
				session::flash('tishi',2); 

	            return $this->redirect("/admin/adminuppage?id=$upinfo[id]");
			}
		}
	}
}