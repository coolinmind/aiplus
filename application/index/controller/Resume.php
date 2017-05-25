<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
class Resume
{
	//分类添加(项目经验、工作经验、学历信息)
	public function cateinsert(Request $request)
	{
		$data = json_decode(input()['DataJson'],true);
		$uid = json_decode(input('uid'),true)['id'];
		$id = rand_str();
		$data['uid'] = $uid;
		$data['id'] = $id;
		$table = input('table');
		$mod = new Common;
		switch ($table) {
			case 'proExperience':
				$res = $mod -> insert('proExperience',$data);
				$arr = $mod -> select('proExperience',['id' => $id]);
				if($res)
				{
					return json(['success' => true,'id' => $arr[0]['id']]);
				}else
				{
					return json(['error' => false]);
				}
				break;

			case 'experience':
				$res = $mod -> insert('experience',$data);
				if($res)
				{
					return json(['success' => true]);
				}else
				{
					return json(['error' => false]);
				}
				break;

			case 'degree':
				$res = $mod -> insert('degree',$data);
				if($res)
				{
					return json(['success' => true]);
				}else
				{
					return json(['error' => false]);
				}
				break;
			
			default:
				# code...
				break;
		}
	}

	//获取简历所有资料信息
	public function getTotal(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		
		//获取用户详情信息
		$mod = new Common;
		$userinfo = $mod -> select('userinfo',['uid' => $uid]);
		$nickname = $userinfo[0]['nickname'];
		$photo = $userinfo[0]['icon'];

		//获取技能详情信息
		$postSkill = $mod -> select('skill',['uid' => $uid]);

		//获取工作经验
		$experience = $mod -> select('experience',['uid' => $uid]);

		//获取项目经验
		$proExperience = $mod -> select('proExperience',['uid' => $uid]);

		//获取简历信息
		$resume = $mod -> select('resume',['uid' => $uid]);//获取简历信息
		$company = $resume[0]['company'];//公司名称
		$post = $resume[0]['post'];//职位名称
		$skill = $resume[0]['skill'];
		$status = $resume[0]['status'];
		$school = $resume[0]['school'];
		$toSchool = $resume[0]['toSchool'];
		$graduate = $resume[0]['graduate'];
		$specialty = $resume[0]['specialty'];
		$introduction = $resume[0]['introduction'];

		//获取财运指数
		$luckMammonMoney = $mod -> select('wallet',['uid' => $uid])[0]['luckMammonMoney'];

		//准备数据
		$data = [];
		$data['photo'] = $photo;//用户头像
		$data['nickname'] = $nickname;//昵称
		$data['status'] = $status;//职业状态
		$data['company'] = $company;//公司名称
		$data['post'] = $post;//所在职位
		$data['luckMammonMoney'] = $luckMammonMoney;//财运值
		$data['skill'] = $skill;//擅长技能
		$data['postSkill'] = $postSkill;//技能详情
		$data['experience'] = $experience;//工作经验
		$data['proExperience'] = $proExperience;//项目经验
		$data['school'] = $school;//学校名称
		$data['toSchool'] = $toSchool;//入学时间
		$data['graduate'] = $graduate;//毕业时间
		$data['specialty'] = $specialty;//所学专业
		$data['introduction'] = $introduction;//自我评价
		$data['department'] = $resume[0]['department'];
		$data['toCompany'] = $resume[0]['toCompany'];
		return json($data);
	}

	//执行更新
	public function update(Request $request)
	{
		$data = json_decode(input('DataJson'),true);
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$res = $mod -> saves('resume',['uid' => $uid],$data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}

	}

	//获取资料完善度
	public function get(Request $request)
	{
		// return json(input());die;
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;

		$num = 0;//未完善选项数目
		$total = 0;//总选项数目

		//查询用户职业状态
		$data = $mod -> select('resume',['uid' => $uid],'status');
		$status = $data[0]['status'];

		switch ($status) {
			case '0': //自由职业
				//判断是否添加工作经验
				$experience = $mod -> select('experience',['uid' => $uid],'company');
				if(!$experience)
				{
					$num ++;
				}

				//判断是否添加学历信息
				$degree = $mod -> select('degree',['uid' => $uid],'school_name');
				if(!$degree)
				{
					$num ++;
				}

				//判断是否添加技能特长
				$skill = $mod -> select('resume',['uid' => $uid]);
				if($skill[0]['skill'] == '')
				{
					$num ++;
				}

				//判断是否添加项目经验
				$proExperience = $mod -> select('proExperience',['uid' => $uid]);
				if($proExperience)
				{
					$num ++;
				}
				$total = 4;
				$percent = ($total - $num)/$total;
				if($percent == 1)
				{
					$percent = 0.99;
				}
				$percent = ($percent * 100).'%';
				return json(['percent' => $percent]);
				break;

			case '1': //在校
				//判断学校、擅长技能信息是否完善
				$school = $mod -> select('resume',['uid' => $uid],'school,specialty,toSchool,graduate,skill');
				foreach ($school[0] as $k => $v) {
					if(!$v)
					{
						$num ++;
					}
				}
				$total = 5;
				$percent = ($total - $num)/$total;
				if($percent == 1)
				{
					$percent = 0.99;
				}
				$percent = ($percent * 100).'%';
				return json(['percent' => $percent]);
				break;

			case '2': //在职
				//判断是否添加项目经验
				$proExperience = $mod -> select('proExperience',['uid' => $uid]);
				if($proExperience)
				{
					$num ++;
				}

				//判断是否添加学历信息
				$degree = $mod -> select('degree',['uid' => $uid]);
				if(!$degree)
				{
					$num ++;
				}

				//判断是否添加技能特长
				$skill = $mod -> select('resume',['uid' => $uid]);
				if($skill[0]['skill'] == '')
				{
					$num ++;
				}

				//判断是否添加工作经验
				$experience = $mod -> select('experience',['uid' => $uid],'company');
				if(!$experience)
				{
					$num ++;
				}
				$total = 4;
				$percent = ($total - $num)/$total;
				if($percent == 1)
				{
					$percent = 0.99;
				}
				$percent = ($percent * 100).'%';
				return json(['percent' => $percent]);
				break;
			
			default:
				return json(['error' => null]);//未选择职业状态
				break;
		}

		

		//判断是否添加项目经验
		$proExperience = $mod -> select('proExperience',['uid' => $uid]);
		if(!$proExperience)
		{
			$num ++;
		}

		$field = '';
		$data = $mod -> select('resume',['uid' => $uid],$field);
	}

	//判断字段是否为空
	public function isNull(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;

		//查询简历
		$data = $mod -> select('resume',['uid' => $uid]);

		$arr = [];
		foreach ($data[0] as $k => $v) 
		{
			if(!$v && $v !=0)
			{
				$arr[$k] = null;
			}else
			{
				$arr[$k] = $v;
			}
		}

		if($arr['status'] == 3)
		{
			$arr['status'] = null;
		}
		return json($arr);
	}
}