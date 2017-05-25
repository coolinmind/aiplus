<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
class Category
{
	//获取技能分类数据
	public function get(Request $request)
	{
		$data = input();
		$field = json_decode($data['WhereJson'],true)['WhereJson'];
		$uid = json_decode($data['id'],true)['id'];
		switch ($field) {
			case '通用技能':
				$field = 'general';
				break;

			case '经验技能':
				$field = 'experience';
				break;

			case '证书技能':
				$field = 'certificate';
				break;

			
			default:
				# code...
				break;
		}
		$id = rand_str();
		$mod = new Common;
		$res = $mod -> select('category');
		if(!$res)
		{
			Db::execute('TRUNCATE category'); //清空category表 
			
			$general = 'APP下载,刷单,传单派发,问卷调查,快递分拣,商场促销,节目充场,送货员,速递员,搬运工,钟点工,临时工,文员,驾驶员,保洁员,服务员,导购员,保安,销售员,操作工,学徒,临时演员';
			$experience = '电话客服,家教,礼仪模特,英语翻译,外语老师,绘画师,美工,动漫设计师,UI/UE设计师,平面设计师,室内设计师,美术设计师,产品经理,广告设计师,软件开发工程师,文案策划师,营养师,花艺师,保姆,月嫂,催乳师,育儿师,摄影师,理发师,美容护理';
			$certificate = '教师资格证,导游证,心理咨询师证,会计证,电工证,软件技术资格证,律师资格证,育婴师证,营养师证,园艺师证,从医资格证,执业兽医证,测绘师证,翻译专业资格证,人力资源管理师证,婚姻家庭咨询师证,理财规划师证,营销师证';
			
			$generalData = explode(',',$general);
			$experienceData = explode(',',$experience);
			$certificateData = explode(',',$certificate);
			$data = [
				'general'=>$generalData,
				'experience'=>$experienceData,
				'certificate'=>$certificateData
			];

			$num = count($data['general']);
			$num1 = count($data['experience']);
			$num2 = count($data['certificate']);
			$count = max($num,$num1,$num2);
			// dump($num2);
			// 
			if($count == $num){
				for ($i=0; $i < $num; $i++) { 
					$mod -> insert('category',['general'=>$data['general'][$i]]);
				}
				for ($i=0; $i <$num1 ; $i++) { 
					$mod -> saves('category',array('id'=>$i+1),['experience'=>$data['experience'][$i]]);
				}

				for ($i=0; $i <$num2 ; $i++) { 
					$mod -> saves('category',array('id'=>$i+1),['certificate'=>$data['certificate'][$i]]);
				}
			}

			if($count == $num1){
				for ($i=0; $i < $num1; $i++) { 
					$mod -> insert('category',['experience'=>$data['experience'][$i]]);
				}
				for ($i=0; $i <$num ; $i++) { 
					$mod -> saves('category',array('id'=>$i+1),['general'=>$data['general'][$i]]);
				}

				for ($i=0; $i <$num2 ; $i++) { 
					$mod -> saves('category',array('id'=>$i+1),['certificate'=>$data['certificate'][$i]]);
				}
			}

			if($count == $num2){
				for ($i=0; $i < $num2; $i++) { 
					$mod -> insert('category',['certificate'=>$data['certificate'][$i]]);
				}
				for ($i=0; $i <$num ; $i++) { 
					$mod -> saves('category',array('id'=>$i+1),['general'=>$data['general'][$i]]);
				}

				for ($i=0; $i <$num1 ; $i++) { 
					$mod -> saves('category',array('id'=>$i+1),['experience'=>$data['experience'][$i]]);
				}
			}
		}

		//提取数据
		$DataJson = $mod -> select('category',[],$field);
		$arr = [];
		foreach ($DataJson as $k => $v) 
		{
			if($v[$field])
			{
				$arr[] = $v[$field];
			}
		}

		if($DataJson)
		{
			return json($arr);
		}else
		{
			return json(['error' => false]);
		}
	}

	//添加选项
	public function insert(Request $request)
	{
		$uid = json_decode(input('uid'),true)['id'];
		$data = json_decode(input('DataJson'),true);
		switch ($data['type']) {
			case '通用技能':
				$data['type'] = 0;
				break;

			case '经验技能':
				$data['type'] = 1;
				break;

			case '证书技能':
				$data['type'] = 2;
				break;
			
			default:
				# code...
				break;
		}
		$id = rand_str();
		$data['uid'] = $uid;
		$data['id'] = $id;

		//执行添加
		$mod = new Common;

		//查询审核表是否已添加该类别
		$arr = $mod -> select('category_review');
		foreach ($arr as $k => $v) 
		{
			if($v['name'] != $data['name'])
			{
				$res = $mod -> insert('category_review',$data);
			}
		}
		
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}
}