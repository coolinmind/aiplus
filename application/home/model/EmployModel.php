<?php 
namespace app\home\model;
use think\Db;
use think\Model;
use think\Paginator;

class EmployModel extends Model
{
    /**
     * 查询技能
     * @return [type] [description]
     */
    public static function select()	
    {
		$list = Db::table('skill') -> paginate(1);
		
		foreach ($list as $k => $v) 
		{
			$info = Db::table('userinfo') -> where('uid',$v['uid']) -> find();
			$v['icon'] = $info['icon'];
			$list[$k] = $v;
		}
		
		if($list){

			return $list;

		}else
		{
			return null;
		}
		
    }
}