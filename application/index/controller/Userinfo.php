<?php
namespace app\index\controller;
use think\Db;
use think\Request;
use app\index\model\Common;
use app\index\model\User;
class Userinfo
{
	//获取用户详情
	public function get(Request $request)
	{
		$data = input();
		$uid = json_decode($data['id'],true)['id'];
		$arr = Db::table('userinfo') -> where('uid',$uid) -> select();
		
		//获取钱包数据
		$wallet = Db::table('wallet') -> where('uid',$uid) -> select();

		//获取邮箱数据
		$email = Db::table('user') -> where('id',$uid) -> find();
		$arr[0]['account'] = $wallet[0]['account'];
		$arr[0]['email'] = $email['email'];
		return json($arr);
	}

	//修改个人中心
	public function update(Request $request)
	{
		$data = input();
		//临时调试代码
		// return json($data);die;
		$arr = json_decode($data['DataJson'],true);
		$uid = json_decode($data['id'],true)['id'];
		$mod = new Common;
		if(array_key_exists('email',$arr))
		{
			//更新用户邮箱
			$mod -> saves('user',['id' => $uid],['email' => $arr['email']]);
			unset($arr['email']);
		}
		$res = Db::table('userinfo') -> where('uid',$uid) -> update($arr);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//验证新手机号是否可用于更新
	public function phone(Request $request)
	{
		$data = json_decode(input('DataJson'),true);
		
		$phone = $data['phone'];

		//查询账号是否存在
		$res = Db::table('user') -> where('username',$phone) -> select();

		if($res)
		{
			return json(['exits' => false]);
		}else
		{
			return json(['access' => true]);
		}
	}

	public function upload(Request $request)
	{
		$data = $request() -> file();

		//图像处理(居中裁剪)
		$image = \think\Image::open(request()->file('pic'));
		$type = $image->type();
		$time = date('Ymd',time());
		$path = './uploads/imgs/'.$time;
		$str = mt_rand(10000,99999);

		//判断目录是否存在
		if(!file_exists($path))
		{
			mkdir($path,0777,true);
		}
		
		//拼装缩略图名称
		$fileName = $path.'/'.$str.time().'.'.$type;
		$image->thumb(150,150,\think\Image::THUMB_CENTER)->save($fileName);
		return '成功';
	}

	//发布技能时判断资料是否完善
	public function isNull(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$data = $mod -> select('userinfo',['uid' => $uid]);

		//判断昵称、真实姓名
		$error = '';
		foreach ($data as $k => $v) 
		{
			if(!$v['nickname'] && !$v['realname'])
			{
				$error = '请填写昵称及真实姓名';
			}

			if(!$v['nickname'] && $v['realname'])
			{
				$error = '请填写昵称';
			}

			if(!$v['realname'] && $v['nickname'])
			{
				$error = '请填写真实姓名';
			}
		}

		if($error)
		{
			return json(['error' => $error]);
		}else
		{
			return json(['success' => true]);
		}
	}

	//随机头像
	public function randPic(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$data = json_decode(input('DataJson'),true);

		// 性别：0为女，1为男 2为保密
		$sex = $data['sex'];

		//男头像
		$boy = ['http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon1.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon3.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon5.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon8.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon9.png'];

		//女头像
		$girl = ['http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon2.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon4.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon6.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon7.png'];
		$mod = new Common;

		//执行更新
		switch ($sex) 
		{
			case '0':
				$str = array_rand($girl);
				$picture = $girl[$str];

				$res = $mod -> saves('userinfo',['uid' => $uid],['icon' => $picture]);

				break;

			case '1':
				$str = array_rand($boy);
				$picture = $boy[$str];
				$res = $mod -> saves('userinfo',['uid' => $uid],['icon' => $picture]);
				break;
			
			default:
				# code...
				break;
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