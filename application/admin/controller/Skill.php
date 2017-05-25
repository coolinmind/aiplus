<?php
namespace app\admin\controller;
use think\Request;
use think\Db;
use app\admin\controller\CommonsController;
use think\Session;
class Skill extends CommonsController
{
	public function index(Request $request)
	{
		$data = Db::table('skill') -> where('is_delete',0) -> order('add_time desc') -> select();
		return view('',['list' => $data]);
	}

	public function edit(Request $request)
	{
		if(Request::instance()->isPost())
		{
			$data = input();
			$res = Db::table('skill') -> where('id',$data['id']) -> update($data);

			if($res)
			{
				Session::flash('success','更新成功');
				return $this -> redirect('/admin/skill/index');
			}else
			{
				Session::flash('error','更新失败');
				return "<script>window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
			}
		}else
		{
			$id = input('get.id');
			$res = Db::table('skill') -> where('id',$id) -> find();
			return view('',['res' => $res]);
		}
	}

	public function delete(Request $request)
	{
		$id = input('get.id');
		
		//执行删除
		$res = Db::table('skill') -> where('id',$id) -> update(['is_delete' => 1]);
		if($res)
		{
			return $this -> redirect();
		}else
		{
			return '删除失败';
		}
	}
}