<?php
namespace app\index\controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\Db;
use think\Request;
class User
{	
	
	/**
	* 	实现手机端的用户快速注册和快速登陆,并且实现电脑端的注册。
	* 	@param  userName 手机端需要的用户名
	* 	@param 	username 电脑端用户名
	* 	@param 	password 电脑端密码
	* 	@param 	password_confirm 电脑端确认密码
	* 	@param 	system   判断是电脑端或者是手机端  电脑的状态码 1  手机端状态码  0
	* 	@param  http://dev.happyoneplus.com/user/adduser  POST方式
	**/
	public function insert(Request $request)
	{	
		date_default_timezone_set('PRC');
		if(!Request::instance()->isPost() || !Request::instance()->isPost())	return;
		$total = json_decode(input()['DataJson'],true);

		if($total['userName']==''){
			return;
		} 

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
		
		$User = model('User');

		// 判断是手机还是电脑 0手机 1电脑
		if($total['system'] == 0){

			
			// $row = Db::table('user')->where('username',$total['userName'])->find();
			
			$row = $User::get(['username'=>$total['userName']]);
			// dump($row);exit;
			if($row){
				
				if($row['delstatus'] == 0) {

					if($row['deltime']){

						return json(['error'=>"用户已于$row[deltime]被封"]);

					}
				}

				$tokins = random();			
    			
				$tokinaa = [
					'id'=>$tokins,
					'username'=>$total['userName'],
					'tokins'=>$tokins,
				];

				$res = Db::table('accessToken')->insert($tokinaa);

				if($res){

					$info = Db::table('accessToken')->where('username',$total['userName'])->find();
					
					$data = Db::table('user')->where('username',$total['userName'])->find();
					$userinfo = Db::table('userinfo') -> where('uid',$data['id']) -> find();
					return json(['token'=>$info['tokins'],'id'=>$data['id'],'icon' => $userinfo['icon']]);

				}

			}else{
				
				$data = [
					'id'=>id(),
					'username'=>$total['userName'],
					'phonepassword'=>sha1($total['userName']),
					'status'=>0,
					'qx'=>1,
					'pid'=>0,
					'mid'=>0,
					'delstatus'=>1,
					'add_time' => date('Y-m-d H:i:s'),
				];

				$User->save($data);

				//初始化userinfo信息
				$userId = Db::table('user') -> where('username',$total['userName'])->find();

				$userInfo = model('Userinfo');

				$data = ['uid' => $userId['id'],'id'=>id()];
				
				$userInfo -> save($data);

				$pid = Db::table('userinfo') -> where('uid',$userId['id'])->find();

				$User -> save([
				    'pid'  => $pid['id'],
				],['id' => $userId['id']]);

				$u = Db::table('user') -> where('id',$userId['id']) -> find();
				$phone = $u['username'];

				// 信息初始化 性别：0为女，1为男 2为保密
				//用户头像
				$select = ['http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon1.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon3.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon5.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon8.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon9.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon2.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon4.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon6.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon7.png'];
				$str = array_rand($select);
				$picture = $select[$str];
				$uinfo = Db::table('userinfo')->where('id',$pid['id'])->update(['nickname'=>'新人驾到','sex'=>'2','phone' => $phone,'icon' => $picture]);

				//初始化钱包信息
				$wallet = Db::table('wallet') -> insert(['uid' => $userId['id'],'id'=>id()]);
				$mid = Db::table('wallet') -> where('uid',$userId['id'])->find();

				//更新用户mid
				Db::table('user') -> where('id',$userId['id']) -> update(['mid' => $mid['id']]);

				//初始化简历
				$id = rand_str();
				$uid = $userId['id'];
				Db::table('resume') -> insert(['id' => $id,'uid' => $uid]);

				//关联accessToken表uid
				Db::table('accessToken') -> where('username',$total['userName']) -> update(['uid' => $userId['id']]);

				$tokins = sha1(uniqid());
			
				$tokinaa = [
					'id'=>$tokins,
					'username'=>$total['userName'],
					'tokins'=>$tokins,
				];

				$res = Db::table('accessToken')->insert($tokinaa);


				if($res){
					
					$id = Db::table('accessToken')->where('id',$tokins)->find();

					$info = Db::table('accessToken')->where('id',$id['id'])->find();
				
					$data = Db::table('user')->where('username',$total['userName'])->find();

					$userinfo = Db::table('userinfo') -> where('uid',$data['id']) -> find();

					return json(['token'=>$info['tokins'],'fist'=>1,'id'=>$data['id'],'icon' => $userinfo['icon']]);

				}

			}

		}
	}


	/**
	*	查询接口
	*	@param http://dev.happyoneplus.com/user/login  POST方式
	**/
	public function get(Request $request)
	{
		// if(!Request::instance()->isPost())	return;
		// $User = model('User');
		// if($row['delstatus'] == 0) {
		// 	if($row['deltime']){

		// 		return json(['error'=>"用户已于$row[deltime]被封"]);

		// 	}
		// }
		$data = json_decode(input()['DataJson'],true);

		//微信登录判断
		$WeChat = Db::name('userinfo') -> where('WeChat',$data['WeChat']) -> find();
		if($WeChat)
		{
			$uid = $WeChat['uid'];
			$data = Db::table('user') -> where('id',$uid) -> find();
			$username = $data['username'];
			$accessToken = Db::table('accessToken') -> where('username',$username) -> find();
			$token = $accessToken['tokins'];
			return json(['id' => $uid,'token' => $token,'icon' => $WeChat['icon']]);
		}else
		{
			//微信不存在
			return json(['access' => true]);
		}

	}

	//第三方登录
	public function login(Request $request)
	{
		$data = json_decode(input()['DataJson'],true);
		$res = Db::table('user') -> where('username',$data['phone']) -> find();
		if($res)
		{
			$uid = $res['id'];

			//更新用户详情微信
			Db::table('userinfo') -> where('uid',$uid) -> update(['WeChat' => $data['WeChat']]);
			$token = Db::table('accessToken') -> where('username',$data['phone']) -> find();
			$userinfo = Db::table('userinfo') -> where('uid',$uid) -> find();
			return json(['id' => $uid,'token' => $token['tokins'],'icon' => $userinfo['icon']]);
		}else
		{
			//注册新用户并关联
			//添加accessToken
			$tokins = sha1(uniqid());
			$tokinaa = [
				'id'=>$tokins,
				'username'=>$data['phone'],
				'tokins'=>$tokins,
			];
			Db::table('accessToken') -> insert($tokinaa);

			//添加用户
			//字符串随机函数
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
			$arr = [
				'id'=>id(),
				'username'=>$data['phone'],
				'phonepassword'=>sha1($data['phone']),
				'status'=>0,
				'qx'=>1,
				'pid'=>0,
				'mid'=>0,
				'delstatus'=>1,
			];

			Db::table('user') -> insert($arr);

			//初始化userinfo信息
			$userId = Db::table('user') -> where('username',$data['phone'])->find();

			$userInfo = model('Userinfo');

			$array = ['uid' => $userId['id'],'id'=>id()];
			
			$userInfo -> save($array);

			$pid = Db::table('userinfo') -> where('uid',$userId['id'])->find();
			$User = model('user');
			$User -> save([
			    'pid'  => $pid['id'],
			],['id' => $userId['id']]);

			$u = Db::table('user') -> where('id',$userId['id']) -> find();
			$phone = $u['username'];
			$data['phone'] = $phone;
			
			// 信息初始化 性别：0为女，1为男 2为保密
			$uinfo = Db::table('userinfo')->where('id',$pid['id'])->update($data);

			//初始化钱包信息
			$wallet = Db::table('wallet') -> insert(['uid' => $userId['id'],'id'=>id()]);
			$mid = Db::table('wallet') -> where('uid',$userId['id'])->find();

			//更新用户mid
			Db::table('user') -> where('id',$userId['id']) -> update(['mid' => $mid['id']]);

			//初始化简历表
			$id = rand_str();
			Db::table('resume') -> insert(['id' => $id,'uid' => $userId['id']]);
			$userinfo = Db::table('userinfo') -> where('uid',$userId['id']) -> find();
			return json(['id' => $userId['id'],'token' => $tokins,'icon' => $userinfo['icon']]);
		}
	}

	/**
	*	用户退出
	*	@param tokin 验证是否登陆
	*	@param system 手机端和电脑端状态码判断
	*	@param 电脑端退出未写
	*	@param http://dev.happyoneplus.com/user/loginout  POST方式
	**/
	public function loginout(Request $request)
	{
		if(!Request::instance()->isPost() || !Request::instance()->isPost())	return;

		$inp = $request->param();
		

		if(!$inp['tokin']) return;
			// 手机端退出

			if($inp['system'] == 0){

				if(!$inp['tokin']) return;

					$del = Db::table('accessToken')->where('tokins',$inp['tokin'])->delete();
					// dump($del);
				if($del){

					return json(['secusss'=>'退出成功！']);

				}else{

					return json(['error'=>'数据异常，请重新尝试！']);

				}
		}
	}

	/**
	*	邮箱验证
	**/
	public function emailtokin()
	{
		// 实例化邮件类
		$mail = new PHPMailer(true);
		try {
		    // 服务器设置
		    $mail->SMTPDebug = 2;                                    // 开启Debug
		    $mail->isSMTP();                                        // 使用SMTP
		    $mail->Host = 'smtp.mxhichina.com';                        // 服务器地址
		    $mail->SMTPAuth = true;                                    // 开启SMTP验证
		    $mail->Username = 'admin@sandboxcn.com';                // SMTP 用户名（你要使用的邮件发送账号）
		    $mail->Password = 'xxxxxx';                                // SMTP 密码
		    $mail->SMTPSecure = 'tls';                                // 开启TLS 可选
		    $mail->Port = 25;                                        // 端口
		    // 收件人
		    $mail->setFrom('admin@sandboxcn.com', 'SandBoxCn');            // 来自
		    $mail->addAddress('23275429@qq.com', 'George.Haung');        // 添加一个收件人
		    $mail->addAddress('23275429@qq.com');                        // 可以只传邮箱地址
		    $mail->addReplyTo('admin@sandboxcn.com', 'SandBoxCn');        // 回复地址
		    // $mail->addCC('cc@example.com');
		    // $mail->addBCC('bcc@example.com');
		    // 附件
		    // $mail->addAttachment('/var/tmp/file.tar.gz');                // 添加附件
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');            // 可以设定名字
		    // 内容
		    $mail->isHTML(true);                                        // 设置邮件格式为HTML
		    $mail->Subject = '欢迎注册成为SandBoxCN的一员:)';
		    $mail->Body    = '欢迎注册成为<b>SandBoxCN</b>的一员';
		    $mail->AltBody = 'xxxxxx';
		    $mail->send();
		    echo '邮件发送成功。<br>';
		} catch (Exception $e) {
		    echo '邮件发送失败。<br>';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}


	/**
	*	获取用户
	*	@param $id 需要传入user表的id号
	*	@param http://dev.happyoneplus.com/user/getuser     GET方式
	**/
	public function getuser($id)
	{
		if(!Request::instance()->isAjax() && !Request::instance()->isGet() )	return;
		if(!$id) return;
		$row = Db::table('user')->where('id',$id)->find();
		if($row){
			return json($row);
		}else{
			return json(['error'=>'检查值是否正确！']);
		}
	}

	/**
	* 	查询多个用户信息 
	* @param $id 需要传入userinfo表的id号 必须是 id：{'sdasdasd','sdasdas'}格式
	* @param http://dev.happyoneplus.com/user/getallid     POST方式
	*/
	public function getallid(Request $request)
	{	
		if(!Request::instance()->isAjax() && !Request::instance()->isPost() )	return;
		$id = $request->param('id');
		if(!$id) return;
		$arr = json_decode($id);
		$str = implode(',',$arr);
		$row = Db::table('userinfo')->where('id','in',$str)->select();
		if($row){
			return json($row);
		}else{
			return json(['error'=>'检查值是否正确！']);
		}	
	}

	/**
	*	删除用户 
	*	@param  userName 手机端或者电脑端用户名
	*	@param  http://dev.happyoneplus.com/user/deluser   POST方式
	**/
	public function deluser(Request $request)
	{
		if(!Request::instance()->isAjax())	return;
		$info = $request->param();
		if($info['userName']==''){
			return;
		}
		$User = model('User');
		$deltime = date('Y-m-d H:i:s',time());
		$isnull = $User->save(['delstatus'=>'0','deltime'=>$deltime],['username'=>$info['userName']]);
		if($isnull){
			return json(['succsee'=>'您的已被封']);
		}else{
			return json(['error'=>'此用户不存在！']);
		}
	}


}