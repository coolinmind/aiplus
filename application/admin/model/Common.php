<?php 
namespace app\admin\model;
use think\Db;
use think\Model;

class Common extends Model
{	
	/**
	 * 数据插入  静态调用	  insert()
	 * 
	 * @param   string 	  $tables  数据表名   
	 * @param   array     $content 需要插入的数据 注意不能为空的数据类型  
	 * 
	 * @return  true      false 
	 */
	
	public static function insert($tables,$content = array())
	{
		if(!$tables && !$content) return;
		$res = Db::table($tables)->insert($content);
		if($res){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 数据删除  静态调用	  del()
	 * 
	 * @param   string    $tables  数据表名   
	 * @param   array     $id      数据表需要删除的id号   必须是数组形式 如 $id = ['id'=>1];  
	 * 
	 * @return  true      false 
	 */

	public static function del($tables,$id = array())
	{
		if(!$id && !$tables) return;
		$del = Db::table($tables)->where($id)->delete();
		if($del){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 数据更新 静态调用  saves()
	 * 
	 * @param  string   $tables    数据表名 
	 * @param  array    $id  	   数据表需要更新的id号   必须是数组形式 如 $id = ['id'=>1];  
	 * @param  array    $content   需要更新的数据  
	 * 
	 * @return true     false
	 */
	
	public static function saves($tables,$id = array() ,$content = array())
	{
		if(!$tables && !$id && !$content ) return;
		$res = Db::table($tables)->where($id)->update($content);
		if($res){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 数据查询  静态调用  selects()
	 * 
	 * @param   string 	 $tables  	 数据表名 
	 * @param   array  	 $id 	  	 数据表需要查询的id号    必须是数组形式 如 $id = ['id'=>1]; 
	 * @param   string   $field   	 条件查询默认为*         格式为 name,sex,age
	 * @param   string 	 $limit   	 要显示的条数            默认为 0,10
	 * @param   string 	 $group   	 分组            
	 * 
	 * @return 	array     $res        false
	 */
	
	public static function select($tables,$id = array() , $field = '',$limit ='0,10' , $group = '')
	{
		if(!$tables) return;

		if(!$id){
			$res = Db::table($tables)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		if($field){
			$res = Db::table($tables)->where($id)->field($field)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		if($field && $limit){
			$res = Db::table($tables)->where($id)->field($field)->limit($limit)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		if($field && $group){
			$res = Db::table($tables)->where($id)->field($field)->group($group)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		if($limit){
			$res = Db::table($tables)->where($id)->limit($limit)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		if($limit && $group){
			$res = Db::table($tables)->where($id)->group($group)->limit($limit)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		if($group){
			$res = Db::table($tables)->where($id)->group($group)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		if($field && $limit && $group){
			$res = Db::table($tables)->where($id)->field($field)->group($group)->limit($limit)->select();
			if($res){
				return $res;
			}else{
				return false;
			}
		}

		$res = Db::table($tables)->where($id)->select();

		if($res){
			return $res;
		}else{
			return false;
		}
	}
}