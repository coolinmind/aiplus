<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
class TaskType
{
	public function get()
	{
		$db = new Common;

		$res = $db::select('task_type');

		if($res){
			foreach ($res as $k => $v) {	

				$data[] = $v['select'];

			}

			return json($data);

		}else{

			return json(['error'=>false]);
			
		}
	}
}