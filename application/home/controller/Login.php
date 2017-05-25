<?php
namespace app\home\controller;
use think\Request;
use think\Response;
use think\Db;
use Endroid\QrCode\QrCode;
use app\home\model\LoginModel;
use think\Session;
use alidayu\TopSdk;
use alidayu\top\TopClient;
use alidayu\top\RequestCheckUtil;
use alidayu\top\request\AlibabaAliqinFcSmsNumSendRequest;
use alidayu\Autoloader;
use think\Controller;

class Login extends controller
{
    //展示首页 
    public function index()
    {   
        return view();
    }
    
    //判断是否是Android或iphone
    public function isCode(Request $request)
    {
        $time = $request->param('time');
        
        $ordtime = $time+60;

        $newtime = time();

        if($newtime > $ordtime){

            return view('/login/error');//显示二维码有效时间已过期

            // 判断HTTP_USER_AGENT是否是自己App所扫描的   如果是返回 code 不是跳转下载页面
        }else if(strpos($_SERVER['HTTP_USER_AGENT'],'Chrome') && strpos($_SERVER['HTTP_USER_AGENT'],'Version') && !strpos($_SERVER['HTTP_USER_AGENT'],'MQQBrowser') && !strpos($_SERVER['HTTP_USER_AGENT'],'TBS') && !strpos($_SERVER['HTTP_USER_AGENT'],'UCBrowser') && !strpos($_SERVER['HTTP_USER_AGENT'],'U3') && !strpos($_SERVER['HTTP_USER_AGENT'],'baidu')  && !strpos($_SERVER['HTTP_USER_AGENT'],'WindVane')  && !strpos($_SERVER['HTTP_USER_AGENT'],'Ali')  && !strpos($_SERVER['HTTP_USER_AGENT'],'weibo')  && !strpos($_SERVER['HTTP_USER_AGENT'],'Iqiyi') && !strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') && !strpos($_SERVER['HTTP_USER_AGENT'],'QQ') || strpos($_SERVER['HTTP_USER_AGENT'],'iPhone') && !strpos($_SERVER['HTTP_USER_AGENT'],'MQQBrowser') && !strpos($_SERVER['HTTP_USER_AGENT'],'TBS') && !strpos($_SERVER['HTTP_USER_AGENT'],'UCBrowser') && !strpos($_SERVER['HTTP_USER_AGENT'],'U3') && !strpos($_SERVER['HTTP_USER_AGENT'],'baidu')  && !strpos($_SERVER['HTTP_USER_AGENT'],'WindVane')  && !strpos($_SERVER['HTTP_USER_AGENT'],'Ali')  && !strpos($_SERVER['HTTP_USER_AGENT'],'weibo') && !strpos($_SERVER['HTTP_USER_AGENT'],'Iqiyi') && !strpos($_SERVER['HTTP_USER_AGENT'],'Version') && !strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') && !strpos($_SERVER['HTTP_USER_AGENT'],'QQ')){
            
            // dump($_SERVER);
            $code = substr(md5(uniqid(md5(microtime(true)),true)),-24).time();

            return $code;

        }else{

            return view('/download/index');

        }
    }

    //二维码第一次请求响应展示 
    public function qrcodes()
    {   

        $qrCode = new QrCode();

        $httpTime = 'http://dev.happyoneplus.com/login/isCode/'.time();

        $qrCode ->setText($httpTime)
                ->setSize(160)
                ->setPadding(10)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabel('')
                ->setLabelFontSize(16)
                ->setImageType(\Endroid\QrCode\QrCode::IMAGE_TYPE_PNG);
                // $qrCode->render();
                $response = new Response($qrCode->get(), 200);
                $response -> contentType($qrCode->getContentType());
                return $response;
    
    }

    //点击刷新是ajax请求的二维码
    public function renovateCode()
    {
        $qrCode = new QrCode();
            
        $httptime = 'http://dev.happyoneplus.com/login/isCode/'.time();

        $qrCode ->setText($httptime)
                ->setSize(160)
                ->setPadding(10)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabel('')
                ->setLabelFontSize(16)
                ->setImageType(\Endroid\QrCode\QrCode::IMAGE_TYPE_PNG);
                $img =  $qrCode->getDataUri();
                return $img;
    }

    //留用
    public function renovateCodes()
    {

        $qrCode = new QrCode();
        
        $code = substr(md5(uniqid(md5(microtime(true)),true)),-24).time();

        $qrCode ->setText($code)
                ->setSize(160)
                ->setPadding(10)
                ->setErrorCorrection('high')
                ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
                ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
                ->setLabel('')
                ->setLabelFontSize(16)
                ->setImageType(\Endroid\QrCode\QrCode::IMAGE_TYPE_PNG);
                $img =  $qrCode->getDataUri();
                return $img;
    }

    //二维码登陆验证  成功返回 true  失败返回 false
    public function codetime(Request $request)
    {
        $date = $request->param(); //需要和前台对接

        $ordTime = substr($code,-10)+60;
        
        $newTime = time();

        $tokn = random();

        $tokns = random();

        if($newTime < $ordTime){

            $row = Db::table('accessToken')->where('tokins',$date['accessToken'])->find();


                if($row){
                    
                    $data = [
                        'id'=>$tokn,
                        'username'=>$row['username'],
                        'tokins'=>$tokns,
                    ];
                    
                    $res = Db::table('accessToken')->insert($data);

                    if($res){

                        session::set('user',$data); 

                        return array('success'=>true);
                    }else{
                        return array('error'=>false);
                    }

                    // return $this->redirect("index/index");
                }

        }else{

            // return json(['error'=>'10000','status'=>'已过期']);
            return view('/login/error');//显示二维码有效时间过期
            
        }
    }
    
    //账号登陆
    public function enter(Request $request)
    {
        $info = $request->post();

        $username = $info['username'];

        $pwd = $info['pwd'];

        if(empty($username)){
            return json(['error'=>10000,'text'=>'手机号不能为空！']);
        }else if(!preg_match("/^1[3578]\d{9}$/", $username)){
            return json(['error'=>10002,'text'=>'手机号格式不正确！']);
        }else if(empty($pwd)){
            return json(['error'=>10003,'text'=>'验证码不能为空！']);
        }else if($pwd != Session::get('Code')){
            return json(['error'=>10004,'text'=>'验证码不正确！']);
        }


        //实例化model类
        $db = new LoginModel;

        $userinfo = $db::IsUser($username);

        if(array_key_exists("error",$userinfo)){

            return json($userinfo);

        }else{

            Session::set('user',$userinfo);
            // dump(Session::get('user'));
            return json(['success'=>'/home/index']);

        }
    }

    //短信验证
    public function SmsCode(Request $request)
    {
        $Telephone = $request->post();
        // dump($Telephone);
        // exit;
        if($Telephone['username'] != '' && $Telephone['status'] != ''){
            //判断是否是登陆区间
            if($Telephone['status'] == 'login'){
                $res = Db::table('user')->where('username',$Telephone['username'])->find();

                if(!$res){

                    return array('error'=>'10009','text'=>'手机号不存在！');

                }else if(preg_match("/^1[3578]\d{9}$/", $Telephone['username'])){
                    $rand = rand('111111','999999');
                    Session::set('Code',$rand);
                    // dump(Session::get('Code'));
                    $c = new TopClient;
                    $c->appkey = '23752893';
                    $c->secretKey = '20b30e23fdf7bba40f402d571ff539ec';
                    $c->format = 'json';

                    $req = new AlibabaAliqinFcSmsNumSendRequest;
                    // $req->setExtend("123456");
                    $req->setSmsType("normal");
                    $req->setSmsFreeSignName("AiPlus助手");
                    $req->setSmsParam("{\"code\":'".Session::get('Code')."'}");
                    $req->setRecNum($Telephone['username']);
                    $req->setSmsTemplateCode("SMS_62300059");
                    $resp = $c->execute($req);
                    // var_dump($resp);

                    if(!isset($resp->sub_code)){

                        return array('success'=>'true');

                    }else if($resp->sub_code == 'isv.BUSINESS_LIMIT_CONTROL'){

                        return array('sub_msg'=>'发送短信验证码次数受限,不能过多发送！');

                    }else if($resp->sub_code =='isv.ACCOUNT_ABNORMAL'){

                        return array('sub_msg'=>'服务器内部发生错误！');

                    }else{

                        return array('msg'=>'false');
                    }

                }else{

                    return json(['error'=>10002,'text'=>'手机号格式不正确！']);
                } 

            //判断是否是注册区间
            }else if($Telephone['status'] == 'register'){

                $res = Db::table('user')->where('username',$Telephone['username'])->find();

                if($res){

                    return array('error'=>'10008','text'=>'手机号已存在！');

                }else if(preg_match("/^1[3578]\d{9}$/", $Telephone['username'])){
                    $rand = rand('111111','999999');
                    Session::set('Codes',$rand);
                    $c = new TopClient;
                    $c->appkey = '23752893';
                    $c->secretKey = '20b30e23fdf7bba40f402d571ff539ec';
                    $c->format = 'json';

                    $req = new AlibabaAliqinFcSmsNumSendRequest;
                    // $req->setExtend("123456");
                    $req->setSmsType("normal");
                    $req->setSmsFreeSignName("AiPlus助手");           
                    $req->setSmsParam("{\"code\":'".Session::get('Codes')."'}");
                    $req->setRecNum($Telephone['username']);
                    $req->setSmsTemplateCode("SMS_62300059");
                    $resp = $c->execute($req);
                    // var_dump($resp);

                    if(!isset($resp->sub_code)){

                        return array('success'=>'true');

                    }else if($resp->sub_code == 'isv.BUSINESS_LIMIT_CONTROL'){

                        return array('sub_msg'=>'发送短信验证码次数受限,请1小时后重新尝试！');

                    }else if($resp->sub_code =='isv.ACCOUNT_ABNORMAL'){

                        return array('sub_msg'=>'服务器内部发生错误！');

                    }else{

                        return array('msg'=>'false');
                    }
                }else{

                    return json(['error'=>10002,'text'=>'手机号格式不正确！']);
                } 
            }

        }else{

            return json(['error'=>10000,'text'=>'手机号不能为空！']);

        }     
    }

    // 注册页面
    public function regindex()
    {
        return view('/register/index');
    }

    //注册
    public function register(Request $request){

        $info = $request->post();
        // dump(Session::get('Codes'));
        // return $info;
        $username = $info['username'];

        $phonecode = $info['phonecode'];

        if(empty($username)){
            return json(['error'=>10000,'text'=>'手机号不能为空！']);
        }else if(!preg_match("/^1[3578]\d{9}$/", $username)){
            return json(['error'=>10002,'text'=>'手机号格式不正确！']);
        }else if(empty($phonecode)){
            return json(['error'=>10003,'text'=>'验证码不能为空！']);
        }else if($phonecode != Session::get('Codes')){
            return json(['error'=>10004,'text'=>'验证码不正确！']);
        }

        //实例化Model类
        $db = new LoginModel;
        //调用注册方法
        $userinfo = $db::registers($username);
        if(array_key_exists("error",$userinfo)){

            return json($userinfo);

        }else{

            Session::set('user',$userinfo);
            // dump(Session::get('user'));
            return json(['success'=>'/home/index']);

        }

    }
}
