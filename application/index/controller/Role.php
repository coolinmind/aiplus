<?php
namespace app\index\controller;
use think\Request;
use think\Db;
use think\Response;
class Role
{
	//创建角色
    public function create(Request $request)
    {
        $data = $request -> param();
        $res = DB::table('role') -> insert($data);
        return json($data);
    }

    //获取角色
    public function getRole()
    {
        $res = DB::table('role') -> select();
        dump($res);
    }

    //更新角色
    public function update($id)
    {
    	return $id;
    }

    //删除角色
    public function delete($id)
    {
    	return $id;
    }

    //角色权限
    public function auth()
    {
        return 'auth';
    }
}
