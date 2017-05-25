<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use app\admin\controller\CommonsController;
Class Agreement extends CommonsController
{
	//合同列表
	public function index(Request $request)
	{
		//查询合同
		$data = Db::table('agreement') -> select();

		return view('agreement/index',['data' => $data]);
	}

	//合同详情
	public function details(Request $request)
	{
		if(Request::instance()->isPost())
		{
			$data = input();
			$res = Db::table('agreement') -> where('id',$data['id']) -> update();
			if($res)
			{
				return '更新成功';
			}else
			{
				return '更新失败';
			}
		}
		$id = input('get.id');
		$data = Db::table('agreement') -> where('id',$id) -> find();

		return view('agreement/details',['data' => $data]);
	}
}