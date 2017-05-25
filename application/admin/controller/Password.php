<?php
namespace app\admin\controller;
use app\admin\controller\CommonsController;
use think\Request;
use app\admin\model\Common;
use think\Validate;
use think\Session;
class Password extends CommonsController
{
	public function update(Request $request)
	{
		if(Request::instance()->isPost())
		{
			$data = input();
			$validate = new Validate([
				'oldpass' => 'require',
				'newpass' => 'require',
				'surepass' => 'require',
				],[
				'oldpass.require' => '请输入原密码',
				'newpass.require' => '请输入新密码',
				'surepass.require' => '请确认密码',
				]);
			$res = $validate -> check($data);
			if(!$res)
			{
				$error = $validate -> getError();
				Session::flash('error',$error);
				return $this -> redirect('/admin/password');
			}else
			{
				if($data['newpass'] != $data['surepass'])
				{
					Session::flash('error','确认密码不一致');
					return $this -> redirect('/admin/password');
				}

				//判断原密码是否正确
				$id = Session::get('admin')['id'];
				$select = new Common;
				$password = sha1($data['oldpass']);
				$res = $select -> select('admin',['id' => $id,'password' => $password]);
				if(!$res)
				{
					Session::flash('error','原密码不正确');
					return $this -> redirect('/admin/password');
				}

				//执行更新
				$res = $select -> saves('admin',['id' => $id],['password' => sha1($data['newpass'])]);
				if(!$res)
				{
					Session::flash('error','您的密码与原密码一致');
					return $this -> redirect('/admin/password');
				}else
				{
					return $this -> success('密码修改成功','/admin');
				}
			}
		}else
		{
			return view('edit');
		}
	}
}