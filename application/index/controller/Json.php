<?php 
namespace app\index\controller;
use think\Db;
use think\Request;
class Json
{
	public function index(Request $request)
	{	

		// $arr = $request->param();
		$arr = array(0=>'menu',1=>'role_qx','permissions_id'=>7);
		$count = count($arr);
		// $id = array_slice($arr,-2,1); //获取第一id
		$id2 = array_slice($arr,-1,1);//获取第二个id
		// dump($id2);
		// exit;
		$id1 = '';
		foreach ($id2 as $k => $v) {
			$id1 = $v;
		}
		// dump($id1);
		if($count == 3){
			$row1 = Db::table($arr[0])->where(['id'=>$id1])->select();
			if($row1){
				
				$row2 = Db::table($arr[1])->where($id2)->select();
				$row1[$arr[1]] = $row2;
				dump($row1);
			}
		}

	}
}