<?php 
namespace app\home\model;
use think\Db;
use think\Model;

class LoginModel extends Model
{
	//登陆验证
	public static function IsUser($user)
	{
		$res = Db::table('user')->where('username',$user)->find();

		$tokn = random();

		$tokns = random();

		if($res){

			if($res['delstatus'] == 0){

				if($row['deltime']){

					return array('error'=>10010,'text'=>"该账号已于$res[deltime]被封！");

				}

			}

			$data = [
					'id'=>$tokn,
					'username'=>$user,
					'tokins'=>$tokns,
				];

			$row = Db::table('accessToken')->insert($data);

			if($row){

				return $data;

			}

		}else{

			return array('error'=>10011,'text'=>'该账号不存在！');

		}
	}

	//注册验证
	public static function registers($username)
	{
		$res = Db::table('user')->where('username',$username)->find();

		$tokn = random();

		$tokns = random();

		function id(){
			$time = time();
			$time = substr($time,4);
			$data = md5($time);
			$str = '';
			for($i=0;$i<18;$i++){
				$num = rand(0,31);
				$str .= $data[$num];
			}
			return $time.$str;
		}

		if($res){

			return array('error'=>10011,'text'=>'该账号已存在！');

		}else{

			$data = [
					'id'=>id(),
					'username'=>$username,
					'phonepassword'=>sha1($username),
					'status'=>0,
					'qx'=>1,
					'pid'=>0,
					'mid'=>0,
					'delstatus'=>1,
					'add_time' => date('Y-m-d H:i:s'),
				];

				Db::table('user')->insert($data);

				//初始化userinfo信息
				$userId = Db::table('user') -> where('username',$username)->find();

				// $userInfo = model('Userinfo');
				// $tokn = random();

				$data = ['uid' => $userId['id'],'id'=>$tokn];
				
				// $userInfo -> save($data);
				Db::table('userinfo')->insert($data);

				$pid = Db::table('userinfo') -> where('uid',$userId['id'])->find();
				// dump($pid);
				// $User -> save([
				//     'pid'  => $pid['id'],
				// ],['id' => $userId['id']]);
				Db::table('user')->where('id',$userId['id'])->update(['pid'=>$pid['id']]);

				$u = Db::table('user') -> where('id',$userId['id']) -> find();
				// dump($u);
				$phone = $u['username'];

				// 信息初始化 性别：0为女，1为男 2为保密
				//用户头像
				$select = ['http://upload.happyoneplus.com/image/icon/boy/icon1.png','http://upload.happyoneplus.com/image/icon/boy/icon3.png','http://upload.happyoneplus.com/image/icon/boy/icon5.png','http://upload.happyoneplus.com/image/icon/boy/icon8.png','http://upload.happyoneplus.com/image/icon/boy/icon9.png','http://upload.happyoneplus.com/image/icon/girl/icon2.png','http://upload.happyoneplus.com/image/icongirl/icon4.png','http://upload.happyoneplus.com/image/icongirl/icon6.png','http://upload.happyoneplus.com/image/icon/girl/icon7.png'];
				$str = array_rand($select);
				$picture = $select[$str];
				$uinfo = Db::table('userinfo')->where('id',$pid['id'])->update(['nickname'=>'新人驾到','sex'=>'2','phone' => $phone,'icon' => $picture]);
				// dump($uinfo);
				//初始化钱包信息
				// $tokn = random();
				$wallet = Db::table('wallet') -> insert(['uid' => $userId['id'],'id'=>id()]);
				$mid = Db::table('wallet') -> where('uid',$userId['id'])->find();
				// dump($mid);
				//更新用户mid
				Db::table('user') -> where('id',$userId['id']) -> update(['mid' => $mid['id']]);

				//初始化简历
				$id = rand_str();
				$uid = $userId['id'];
				Db::table('resume') -> insert(['id' => $id,'uid' => $uid]);

				//关联accessToken表uid
				Db::table('accessToken') -> where('username',$username) -> update(['uid' => $userId['id']]);

				// $tokins = sha1(uniqid());
				// $tokn = random();
				
				$data = [
					'id'=>id(),
					'username'=>$username,
					'tokins'=>$tokns,
				];

				$res = Db::table('accessToken')->insert($data);

				if($res){

					return $data;

				}else{

					return array('error'=>10010,'text'=>"未知原因,注册失败！");

				}
			  
		}
	}
}