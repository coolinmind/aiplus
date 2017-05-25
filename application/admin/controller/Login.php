<?php
namespace app\admin\controller;
use app\admin\model\Common;
use think\Request;
use think\Controller;
use think\Session;
use think\Db;

class Login extends Controller
{
	public function login(Request $request)
	{
		if(Request::instance()->isPost())
		{

			$obj = new Common;

			$data = input();

			$data['password'] = sha1($data['password']);

			$res = $obj -> select('admin',$data);

			if($res){

				// 查询登录次数
				$times = $res[0]['times'];
				//更新登录次数
				Db::table('admin') -> where('id',$res[0]['id']) -> update(['times' => $times + 1]);
				$res[0]['times'] = $times + 1;
				Session::set('admin',$res[0]);
				$mod = new Common;

		   		$ret = $mod::select('menu');

				$row = Session::get('admin');

		   		if($row){

					$arrs = $mod -> select('admin',['id' => $row['id']]);
				
					if($arrs){

						Session::set('arrs',$arrs[0]);

					}
					
					if($arrs[0]['name'] != 'admin'){

						$role_id = $arrs[0]['rid'];

				        $datas = Db::table('role_qx')->where(" role_id = '{$role_id}' ")->select();

				        if(!$datas){
				        	return $this -> error('没有权限');
				        }

				        $return = array();

				        foreach($datas as $val){

				            $return[$val['permissions_id']] = $val['permissions_id'];

				        }

				        $in_id = Db::table('menu')->where('id','in',$return)->select();

				        if(!$in_id ) return $this -> error('登录失败');

						Session::set('in_id',$in_id);
						
				        // foreach ($in_id as $k => $v) {
				        // 	Session::set('in_id',$v);
				        // }
						 $parent_id = [];

						foreach ($in_id as $k => $v) {
						  
						  $parent_id[] = $v['parent_id'];

						}

						$idall = array_unique($parent_id);

						$data = Db::table('menu')->where('id','in',$idall)->select();

				        Session::set('menudata',$data);

						Session::set('ret',$ret);

						Session::set('q_id',$return);
						
			   				// return view('/header',array('res'=>$res,'arr'=>$arr[0]));	
			   		}else{
						Session::set('ret',$ret);
					
			   		}	
		   		}

				return $this -> redirect('/admin');
		

			}else{

				return $this -> error('登录失败');
			}

		}else{

			return view();

		}
		
	}
}