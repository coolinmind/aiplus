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
class Role extends CommonsController
{
	public function index()
	{
		$role = new Common();
       
		$res = $role::select('role');

		return view('role',['res'=>$res]);

	}
      /**
       * 角色添加
       */
	public function add(Request $Request)
	{
		$role = $Request->param();

		if(!$role['name']){

			session::flash('tishi',2); 

                  return $this->redirect("/admin/role");

       	}

		$roles = new Common();

       	$res = $roles::insert('role',array('names'=>$role['name']));

       	if($res){

       		session::flash('tishi',1); 

                  return $this->redirect("/admin/role");

       	}else{

       		session::flash('tishi',2); 

                  return $this->redirect("/admin/role");

       	}

	}	

      /**
       * 角色删除
       */
	public function del(Request $Request)
	{
		$id = $Request->param();

		if(!$id){

			session::flash('tishi',2); 

                  return $this->redirect("/admin/role");

       	}

       	if($id['id'] == '1'){

       		session::flash('tishi',3); 

                  return $this->redirect("/admin/role");

       	}

       	$role = new Common();

       	$res  = $role::del('role',$id);

       	if($res){

       		session::flash('tishi',1); 

                  return $this->redirect("/admin/role");

       	}else{

       		session::flash('tishi',2); 

                  return $this->redirect("/admin/role");
       	}
	}

      /**
       * 权限设置页
       */
      public function permissions(Request $request)
      {     
            $id = $request->param('id');

            if(!$id){

                  session::flash('tishi',2); 

                  return $this->redirect("/admin/role/permissions");

            }

            $role = new Common();

            $item = $role::select('menu');
            // dump($item);
            // $res = $role::select('role_qx',array('role_id'=>$id));
            $role_id = (int) $id;

	      $datas = Db::table('role_qx')->where(" role_id = '{$role_id}' ")->select();

	      $return = array();

	      foreach($datas as $val){

	         $return[$val['permissions_id']] = $val['permissions_id'];

	      }
       
            // $arr = implode(',', $return);
            // dump($arr);
            
            if($return){

                  return view('permissions',array('id'=>$id,'item'=>$item,'res'=>$return));

            }else{

                  return view('permissions',array('id'=>$id,'item'=>$item));

            }
      }

      /**
       * 权限写入
       */
      public function permissionwrite(Request $request)
      {
            $res = $request->param();
            // dump($res);
            // exit;
            if(!$res){

                  session::flash('tishi',2); 

                  return $this->redirect("/admin/role");

            }

            $role = new Common();

            if($res['id']){

                  $sel = $role::del('role_qx',array('role_id'=>$res['id']));

                  if(isset($res['data'])){
                        foreach ($res['data'] as $k => $v) {

                              $row = $role::insert('role_qx',array('role_id'=>$res['id'],'permissions_id'=>$v));

                        }
                  }
            }

            
            if(isset($row)){
                if($row){

                      session::flash('tishi',1); 

                      return $this->redirect("/admin/role");

                  }else{

                      session::flash('tishi',2); 

                      return $this->redirect("/admin/role");
                  }  
            }else{
                  session::flash('tishi',1); 

                  return $this->redirect("/admin/role");  
            }
            
      }
}