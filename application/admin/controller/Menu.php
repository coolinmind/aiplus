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
class Menu extends CommonsController
{
	public function index()
	{
		$menu = new Common;

		$items = $menu::select('menu');
		// $wx = $this -> formatTree($items,0);
		// $w = $menu::select('menu',array('is_show'=>1)	);
		// dump($w);
		return view('menu',['res'=>$items]);

	}
	
	/**
	 * 无限分类
	 */
	public function formatTree($array, $pid = 0)
	{
		 $arr = array();

		 $tem = array();

		 foreach ($array as $v) {

		  if ($v['parent_id'] == $pid) {

		   $tem = $this->formatTree($array, $v['id']);

		   //判断是否存在子数组
		   $tem && $v['son'] = $tem;

		   $arr[] = $v;

		   }

		 }

		 return $arr;
	}

	/*
	 * 删除菜单
	 */
	public function delete(Request $request)
	{
		$id = $request->param('menu_id');
		// dump($id);
		if(!$id){

			session::flash('tishi',2); 

            return $this->redirect("/admin/menu");

       	}
		
		$menu = new Common;

		$is_show = $menu::select('menu',array('parent_id'=>$id));

		if($is_show){

			session::flash('tishi',3); 

            return $this->redirect("/admin/menu");

		}else{

			// $del = $menu::del('menu',array('id'=>$id));
			$save = $menu::saves('menu',array('id'=>$id),['is_show'=>0]);

			if($save){

				session::flash('tishi',1); 

            	return $this->redirect("/admin/menu");

			}else{

				session::flash('tishi',2); 

            	return $this->redirect("/admin/menu");

			}
		}
	}

	/*
	 * 更新菜单名称
	 */
	public function edit(Request $request)
	{
		$info = $request->param();
		// dump($info);exit;
		if(!$info){

			session::flash('tishi',2); 

            return $this->redirect("/admin/menu");

       	}

		$menu = new Common;

		$save = $menu::saves('menu',array('id'=>$info['id']),array('menu_name'=>$info['menu_name']));

		if($save){

			session::flash('tishi',1); 

            return $this->redirect("/admin/menu");

		}else{

			session::flash('tishi',2); 

            return $this->redirect("/admin/menu");

		}
	}

	/*
	 * 插入菜单
	 */
	public function insert(Request $request)
	{
		$info = $request->param();
		// dump($info);exit;
		if(!$info){

			session::flash('tishi',2); 

            return $this->redirect("/admin/menu");

       	}

       	if($info['id']){

			$menu = new Common;

			$data = [
				'parent_id'=>$info['id'],
				'menu_name'=>$info['menu_name'],
				'is_show'=>1
			];

	       	$res = $menu::insert('menu',$data);

	       	if($res){

				session::flash('tishi',1);

	            return $this->redirect("/admin/menu");

			}else{

				session::flash('tishi',2); 

	            return $this->redirect("/admin/menu");

			}	

		}else{

			$menu = new Common;

			$data = [
				'parent_id'=>0,
				'menu_name'=>$info['menu_name'],
				'is_show'=>1
			];

	       	$res = $menu::insert('menu',$data);

	       	if($res){

				session::flash('tishi',1);

	            return $this->redirect("/admin/menu");

			}else{

				session::flash('tishi',2); 

	            return $this->redirect("/admin/menu");

			}

		}

	}

	/**
	 *  设置路径或者修改
	 */
	public function pathedit(Request $request)
	{
		$info = $request->param();
		// dump($info);exit;
		if(!$info){

			session::flash('tishi',2); 

            return $this->redirect("/admin/menu");

       	}

       	$menu = new Common;

       	$data = [
       		'menu_path'=>$info['menu_path'],
       		'menu_name'=>$info['menu_name']
       	];

       	$res = $menu::saves('menu',array('id'=>$info['id']),$data);

       	if($res){

				session::flash('tishi',1);

	            return $this->redirect("/admin/menu");

			}else{

				session::flash('tishi',2); 

	            return $this->redirect("/admin/menu");

		}

	}

	public function set(Request $request)
	{
		$id = $request->param('id');
		// dump($id);
		if(!$id){

			session::flash('tishi',2); 

            return $this->redirect("/admin/menu");

       	}

       	$menu = new Common;

       	$sel = $menu::select('menu',array('parent_id'=>$id));
       	// dump($sel);exit;

		if(!$sel){

				session::flash('tishi',2); 

	            return $this->redirect("/admin/menu");

		}

		return view('menu/list',['list'=>$sel]);
		
	}

	/**
	 * 路径添加或者修改
	 */
	public function setedit(Request $request)
	{
		$data = $request->param();

		foreach ($data as $k => $v) {
			foreach ($v as $key => $val) {
				$info = [
					'menu_name'=>$val['menu_name'],
					'menu_path'=>$val['menu_path'],
					'is_show'=>$val['is_show'],
				];

				$menu = new Common;
				
				$res = $menu::saves('menu',['id'=>$val['id']],$info);


				if($res){

					session::flash('tishi',1);

		            return $this->redirect("/admin/menu");

				}
			
			}
				
		}

		if(!$res){

			session::flash('tishi',2);

            return $this->redirect("/admin/menu");

		}

	}

}