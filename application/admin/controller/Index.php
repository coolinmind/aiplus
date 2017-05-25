<?php
namespace app\admin\controller;
use think\View;
use app\admin\controller\CommonsController;
use think\Request;
use think\Session;
use app\admin\model\Common;
use think\Db;

class Index extends CommonsController
{
    public function index(Request $request)
    {
//    $colorlist = array("apple"=>"red", "grass"=>"green","sky"=>"blue","night"=>"black","wall"=>"white"); 
// echo "数组长度为: ".count($colorlist); //5
        // $res = Db::table('menu')
        // ->alias('a')
        // ->join('role_qx w','w.permissions_id = a.id')
        // ->where('w.permissions_id',12)
        // ->select()->json;
        // dump($res);
        $request = Request::instance();
        $ip = $request->ip();
        $version = PHP_VERSION;
        $mysql = Db::query("select VERSION()")[0]['VERSION()'];
        $pos = strpos($mysql,'-');
        $mysql = substr($mysql,0,$pos);
        $nginx = $_SERVER["SERVER_SOFTWARE"];
    	return view('index',['ip' => $ip,'version' => $version,'mysql' => $mysql,'nginx' => $nginx]);

    }

    /**
     * 图片接口
     */
    public function info()
    {
   		$mod = new Common;
		$res = Session::get('admin');
		// dump($res);
		$arr = $mod -> select('admin',['id' => $res['id']]);
		if($arr){
			return json(['pic'=>$arr[0]['photo']]);
		}else{
			return json(['err'=>'false']);
		}
    }

    public function test()
    {   
        $city = array('北京','天津');
        $type = '传单派发,电话客服';
        $re = '';
        $where['address'] = array('in',$city);
        // $where['task_type'] = array('in',$type); 
        // $where['task_tags'] = array('in',$re);
        $res = Db::table('employ')->where($where)->select();
        // $res = Db::table('employ')->where('address','in',$city ,'AND' ,'task_type','in',$type)->select();
        dump($res);
    }
   
}
