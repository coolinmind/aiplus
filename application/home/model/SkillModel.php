<?php
namespace app\home\model;
use think\Model;
use think\Db;
class SkillModel extends Model
{
	/**
	 * 查询需求
	 * @return [type] [description]
	 */
	static public function select($where)
	{
		$data = Db::table('employ')-> where($where) -> select();
		if($data)
		{
			return $data;
		}else
		{
			return null;
		}
	}
}