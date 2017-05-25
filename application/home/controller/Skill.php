<?php
namespace app\home\controller;
use app\home\model\SkillModel;
use think\Db;
class Skill
{
	public function index()
	{
		$where = [];
		$data = SkillModel::select($where);		
		$cate = Db::table('cate') -> where('pid',0) -> select();
		$city = Db::table('provinces') -> select();
		return view('',['cate' => $cate,'city' => $city]);
	}
}