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

class Userinfo extends CommonsController
{
	public function index()
	{
		$res = new Common;

		$info   = $res::select('userinfo');
		return view('/userinfo/index',['info'=>$info]);
		
	}

	/**
	 *  修改数据遍历
	 * 
	 */
	public function edit(Request $request)
	{
		$id = $request->param('id');
		if(!$id){

			session::flash('tishis',2); 

            return $this->redirect("/admin/userinfo/index");
		} 

		$res = new Common;

		$data = $res::select('userinfo',['id'=>$id]);

		if(!$data){

			session::flash('tishis',2); 

            return $this->redirect("/admin/userinfo/index");
		}

		return view('/userinfo/edit',['data'=>$data[0]]);
		
	}

	/**
	 *  修改更新
	 */
	public function updata(Request $request)
	{
		$info = $request->param();
		// dump($info);exit;
		if(!$info){
			
			session::flash('tishis',2); 

        	return $this->redirect("/admin/userinfo/index");
		}

		$pic = $_FILES['icon'];
		// dump($pic);
		if($pic['tmp_name']){

			import('extend.upyun.vendor.autoload');

	        $client = new \Upyun('wepin','test1','test1234');

	        // 图片上传
	        $fh = fopen($pic['tmp_name'], 'r');  
	        // 图片压缩 
	        $tasks = array('x-gmkerl-thumb' => '/fw/150//fh/150/unsharp/true/quality/80/format/png');
	        // 防止图片名称冲突 
	        $picname = date('Ymd').substr(md5(uniqid()),0,12).rand('1111','9999').'.png';
	        // 获取时间去创建文件
	        $time = date('Y-m-d');
	        // 上传到upyun
	        $client->writeFile('/image/user/'.$time.'/'.$picname , $fh , true ,$tasks);
	        // 关闭资源集
	        fclose($fh);
	        // 图片路径
	        $picurl = 'http://upload.happyoneplus.com/image/user/'.$time.'/'.$picname;

	        $data = [
	        	// 'phone'=>$info['phone'],
	        	'nickname'=>$info['nickname'],
	        	'realname'=>$info['realname'],
	        	'sex'=>$info['sex'],
	        	'Verify'=>$info['Verify'],
	        	'address'=>$info['address'],
	        	'status'=>$info['status'],
	        	'icon'=>$picurl,
	        ];

	        $updata = new Common;

	        $res = $updata::saves('userinfo',array('id'=>$info['id']),$data);

	        if($res){

				session::flash('tishis',1); 

            	return $this->redirect("/admin/userinfo/index");

			}else{

				session::flash('tishis',2); 

            	return $this->redirect("/admin/userinfo/index");
			}

		}else{

			$data = [
	        	// 'phone'=>$info['phone'],
	        	'nickname'=>$info['nickname'],
	        	'realname'=>$info['realname'],
	        	'sex'=>$info['sex'],
	        	'Verify'=>$info['Verify'],
	        	'address'=>$info['address'],
	        	'status'=>$info['status'],
	        ];

	        $updata = new Common;

	        $res = $updata::saves('userinfo',array('id'=>$info['id']),$data);

	        if($res){

				session::flash('tishis',1); 

            	return $this->redirect("/admin/userinfo/index");

			}else{

				session::flash('tishis',2); 

            	return $this->redirect("/admin/userinfo/index");
			}
		}
	}
}