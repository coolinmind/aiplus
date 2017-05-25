<?php
namespace app\index\controller;
use think\Request;
use think\Db;
class Cate
{
	public function get(Request $request)
	{
		$data = Db::table('cate') -> select();
		foreach ($data as $k => $v) 
		{
			$array[] = ['id' => $v['id'],'pid' => $v['pid'],'name' => $v['name']];
		}

		function formatTree($array, $pid = 0){
		 $arr = array();
		 $tem = array();
		 foreach ($array as $v) {
		  if ($v['pid'] == $pid) {
		   $tem = formatTree($array, $v['id']);
		   //判断是否存在子数组
		   $tem && $v['son'] = $tem;
		   $arr[] = $v;
		  }
		 }
		 return $arr;
		}

		$list = formatTree($array);
		return json($list);
	}

	//发布任务、技能时获取
	public function find(Request $request)
	{
		$data = Db::table('cate') -> select();
		foreach ($data as $k => $v) 
		{
			$array[] = ['id' => $v['id'],'pid' => $v['pid'],'name' => $v['name']];
		}

		function formatTree($array, $pid = 0){
		 $arr = array();
		 $tem = array();
		 foreach ($array as $v) {
		  if ($v['pid'] == $pid) {
		   $tem = formatTree($array, $v['id']);
		   //判断是否存在子数组
		   $tem && $v['sub'] = $tem;
		   unset($v['pid']);
		   unset($v['id']);
		   $arr[] = $v;
		  }
		 }
		 return $arr;
		}

		$list = formatTree($array);

		return json($list);
	}
}