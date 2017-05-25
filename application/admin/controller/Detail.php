<?php
namespace app\admin\controller;
use app\admin\controller\CommonsController;
use think\Request;
use app\admin\model\Common;
use think\Session;
class Detail extends CommonsController
{
	public function index()
	{
		$mod = new Common;
		$res = Session::get('admin');
		// dump($res);
		$arr = $mod -> select('admin',['id' => $res['id']]);
		// dump($arr);
		return view('index',['info'=>$arr[0]]);
	}

	public function upload(Request $request)
	{
		if(request() -> file('photo') == null)
		{
			Session::flash('error','请选择图片');
			return redirect('/admin/detail');
		}
		//图像处理(居中裁剪)
		$image = \think\Image::open(request()-> file('photo'));
		$type = $image->type();
		$time = date('Ymd',time());
		$path = './uploads/imgs/'.$time;
		$str = rand_str();

		//判断目录是否存在
		if(!file_exists($path))
		{
			mkdir($path,0777,true);
		}
		
		//拼装缩略图名称
		$fileName = $path.'/'.$str.'.'.$type;
		$image->thumb(309,309,\think\Image::THUMB_CENTER)->save($fileName);
		//执行修改
		$mod = new Common;
		$id = Session::get('admin')['id'];

		//获取原图片
		$arr = $mod -> select('admin',['id' => $id]);
		$oldPhoto = $arr[0]['photo'];
		$fileName = substr($fileName,1);

		$res = $mod -> saves('admin',['id' => $id],['photo' => $fileName]);

		//删除原来的图片
		if(file_exists('.'.$oldPhoto))
		{
			unlink('.'.$oldPhoto);
		}

		if($res)
		{
			// //更新session信息
			// $arr = $mod -> select('admin',['id' => $id]);
			// // Session::set('admin',$arr[0]);

			$this-> redirect('/admin/detail');
		}else
		{
			return $this -> error('修改失败');
		}
	}
}