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

class Cate extends CommonsController
{
	public function index()
	{
		$data = Db::query("SELECT id,name,path,pid,concat(path,',',id) AS sort FROM `cate` ORDER BY sort");
		
		//遍历获取path(给path分层)
        foreach($data as $k => $v)
        {
        	$num = substr_count($v['path'],',');
            $str = '|----';
            $data[$k]['name'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$num*2).$str.$v['name'];
        }
        
		return view('',['list' => $data]);
	}

	public function insert(Request $request)
	{
		$data = input();

		//拼装新路径
		if($data['pid'] == $data['path'])
		{
			$path = 0;
		}else
		{
			$path = $data['path'].','.$data['pid'];
		}
		
		$data['path'] = $path;
		
		//执行添加
		$res = Db::table('cate') -> insert($data);
		if($res)
		{
			return $this -> redirect('/admin/cate/index');
		}else
		{
			return '失败';
		}
	}

	public function edit(Request $request)
	{
		$id = input('id');
		$data = Db::table('cate') -> where('id',$id) -> find();
		$name = $data['name'];
		$pid = $data['pid'];
		return json(['name' => $name,'pid' => $pid]);
	}

	public function doEdit(Request $request)
	{
		if(Request::instance() -> isPost())
		{
			$data = input();
			//查询父类数据
			$arr = Db::table('cate') -> where('id',$data['pid']) -> find();
			if($data['pid'] == 0)
			{
				$path = 0;
			}else
			{
				$path = $arr['path'].','.$data['pid'];
			}
			$data['path'] = $path;
			
			$res = Db::table('cate') -> where('id',$data['id']) -> update($data);

			//判断是否有子类
			$son = Db::table('cate') -> where('pid',$data['id']) -> select();
			if($son)
			{
				//更新子类path
				foreach ($son as $k => $v) 
				{
					Db::table('cate') -> where('id',$v['id']) -> update(['path' => $path.$data['id']]);
				}
			}
			if($res)
			{
				return $this -> redirect('/admin/cate/index');
			}else
			{
				return '失败';
			}
		}
	}

	public function delete(Request $request)
	{
		$id = input('id');
		//判断是否有子分类
		$result = Db::table('cate') -> where('pid',$id) -> find();
		if($result)
		{
			return json(['info' => '有子分类,无法删除']);
		}

		$res = Db::table('cate') -> delete($id);
		if($res)
		{
			return json(['info' => '删除成功']);
		}else
		{
			return json(['info' => '删除失败']);
		}
		
	}
}