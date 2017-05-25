<?php
namespace app\index\model;
use think\Model;
use think\Db;
class RoleModel extends Model
{
	public function create()
	{
		return 111;
	}

	public function getRole($id)
	{
		return $id;
	}
}