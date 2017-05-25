<?php 
namespace app\admin\controller;
use think\View;
use app\admin\model\Common;
use think\Db;
use think\Paginator;
use think\Controller;
use think\Session;
use app\admin\controller\CommonsController;
use think\Request;
use think\Validate;
use PHPExcel_IOFactory;
use PHPExcel;
class Userlist extends CommonsController
{
    public function index(Request $request)
    {	
    	$user = new Common;
    	$res = $user::select('user');
    	// dump(input('resetmsg'));
     	return view('userlist/userlist',['list'=>$res]);
    }


    /**
       * 用户封禁
       */
    public function sealuser(Request $request)
    {
      	$username = $request->param('username');

      	if(!$username) return;

      	$users = [

      		'username'=>$username,

      	];

      	$user = new Common;

    		$deltime = date('Y-m-d H:i:s',time());
    		// dump($_GET);exit;

    		$isnull = $user::saves('user',$users,['delstatus'=>'0','deltime'=>$deltime]);

    		if($isnull){

               session::flash('tishi',1);

    			     return $this->redirect('/admin/userlist');

    		}else{

             session::flash('tishi',2);

  			     return $this->redirect('/admin/userlist');
    		}
    }

    /**
       * 用户信息展示
       */
    public function userinfo(Request $request)
    {
       $id = $request->param();
       // dump($id);
       if(!$id) return;

       $user = new Common;

       $res = $user::select('user',$id);
       
       return  view('userlist/userupdate',['info'=>$res]);
    }

    /**
       * 用户信息系应该
       */
    public function userupdate(Request $request)
    {
        $info = $request->param();
        // dump($info);exit;
        if(!$info) {
            session::flash('tishis',1); 
            return $this->redirect("/admin/userinfo?id=$info[id]");
        } 

        $user = new Common;

        $name = ['username'=>$info['username']];

        $row = $user::saves('user',$name,['delstatus'=>$info['delname'],'deltime'=>' ']);

        if($row){

            return $this->redirect('/admin/userlist');
             
        }else{

            session::flash('tishis',1);

            return $this->redirect("/admin/userinfo?id=$info[id]");

        }
        
        
    }

    //用户添加
    public function insert(Request $request)
    {
      date_default_timezone_set('PRC');
      if(Request::instance()->isPost())
      {
        $data = input();
        $file = $_FILES['photo'];//头像
        $picture = [];
        if($file)
        {
          foreach ($file['tmp_name'] as $k => $v) 
          {
            $picture[] = $v;
          }
        }

        $user = [];
        foreach ($data as $k => $v) 
        {
          foreach ($v as $key => $value) 
          {
            $user[$key][$k] = $value;
          }
        }

        //验证
        foreach ($user as $k => $v) 
        {
          $rule = [
            'username'  => 'require|unique:user',
          ];
          $msg = [
              'username.require' => '手机号不能为空',
              'username.unique' => $v['username'].'手机号已存在',
          ];
          $validate = new Validate($rule,$msg);
          $result[$k] = $validate->check($user[$k]);
          if(!$result[$k])
          {
            $info[] =  $validate->getError();
          }
        }
        
        if(in_array(false, $result))
        { 
            Session::flash('info',$info);
            return $this -> redirect('/admin/userlist/insert');
        }

        //执行添加
        foreach ($user as $k => $v) 
        {
          $userData = [];
          $id = random();
          $userData['username'] = $v['username'];
          $userData['email'] = $v['email'];
          $userData['add_time'] = date('Y-m-d H:i:s');
          $userData['id'] = $id;
          $res = Db::table('user') -> insert($userData);
          //男头像
          $boy = ['http://upload.happyoneplus.com/image/icon/boy/icon1.png','http://upload.happyoneplus.com/image/icon/boy/icon3.png','http://upload.happyoneplus.com/image/icon/boy/icon5.png','http://upload.happyoneplus.com/image/icon/boy/icon8.png','http://upload.happyoneplus.com/image/icon/boy/icon9.png'];

          //女头像
          $girl = ['http://upload.happyoneplus.com/image/icon/girl/icon4.png','http://upload.happyoneplus.com/image/icon/girl/icon2.png','http://upload.happyoneplus.com/image/icon/girl/icon6.png','http://upload.happyoneplus.com/image/icon/girl/icon7.png'];

          $select = ['http://upload.happyoneplus.com/image/icon/boy/icon1.png','http://upload.happyoneplus.com/image/icon/boy/icon3.png','http://upload.happyoneplus.com/image/icon/boy/icon5.png','http://upload.happyoneplus.com/image/icon/boy/icon8.png','http://upload.happyoneplus.com/image/icon/boy/icon9.png','http://upload.happyoneplus.com/image/icon/girl/icon2.png','http://upload.happyoneplus.com/image/icon/girl/icon6.png','http://upload.happyoneplus.com/image/icon/girl/icon7.png','http://upload.happyoneplus.com/image/icon/girl/icon4.png'];

            if($v['sex'] == 0)
            {
              $str = array_rand($girl);
              $pic = $girl[$str];
            }else if($v['sex'] == 1)
            {
              $str = array_rand($boy);
              $pic = $boy[$str];
            }else
            {
              $str = array_rand($select);
              $pic = $select[$str];
            }
            //初始化
            $info = [
              'id' => random(),
              'uid' => $id,
              'phone' => $v['username'],
              'nickname' => '新人驾到',
              'sex' => $v['sex'],
              'icon' => $pic,
            ];
            if($v['nickname'])
            {
              $info['nickname'] = $v['nickname'];
            }

            if($picture[$k])
            {
              $pic = $picture[$k];
              import('extend.upyun.vendor.autoload');

              $client = new \Upyun('wepin','test1','test1234');

              // 图片上传
              $fh = fopen($pic, 'r');  
              // 图片压缩 
              $tasks = array('x-gmkerl-thumb' => '/fw/150//fh/150/unsharp/true/quality/80/format/png');
              // 防止图片名称冲突 
              $picname = date('Ymd').substr(md5(uniqid()),0,12).rand('1111','9999').'.png';
              // 获取时间去创建文件
              $time = date('Y-m-d');
              // 上传到upyun
              $client->writeFile('/image/user/'.$time.'/'.$picname , $fh , true ,$tasks);
              // 关闭资源集
              fclose($fh);
              // 图片路径
              $picurl = 'http://upload.happyoneplus.com/image/user/'.$time.'/'.$picname;
              $info['icon'] = $picurl;
            }

            Db::table('userinfo') -> insert($info);//个人信息
            $mid = random();
            $wallet = [
              'id' => $mid,
              'uid' => $id,
            ];

            Db::table('wallet') -> insert($wallet);//钱包

            $resume = [
              'id' => random(),
              'uid' => $id,
            ];

            Db::table('resume') -> insert($resume);//简历
        }
        return redirect('/admin/userlist');
      }else
      {
        return view();
      }
    }

    //导入用户页面
    public function import(Request $request)
    {
      if(Request::instance()->isPost())
      {
        ini_set("memory_limit",-1);
        $filename = $_FILES['filename']['tmp_name'];
        if(!$filename)
        {
        	$info[] = '请选择文件';
        	Session::flash('info',$info);
        	return redirect('/admin/userlist/insert');
        }

        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        $dataArray = $objPHPExcel->getActiveSheet()->toArray();
        array_shift($dataArray);
        
        $info = [];
        foreach ($dataArray as $k => $v) 
        {
           if($v[4] == '')
           {
            unset($dataArray[$k]);
           }
           $info[$k]['city'] = $v[0];//城市
           $info[$k]['time'] = $v[1];//发布时间
           $info[$k]['title'] = $v[2];//标题
           $info[$k]['username'] = $v[3];//联系人
           $info[$k]['phone'] = $v[4];//电话
           $info[$k]['account'] = $v[5];//薪资
           $info[$k]['post'] = $v[6];//招聘职位
           $info[$k]['requirement'] = $v[7];//需求描述
           $info[$k]['address'] = $v[8];//工作地址
           $info[$k]['company'] = $v[10];//公司名称
           $info[$k]['size'] = $v[11];//公司规模
           $info[$k]['nature'] = $v[12];//公司性质
           $info[$k]['type'] = $v[13];//行业
           $info[$k]['company_address'] = $v[14];//公司地址
           $info[$k]['description'] = $v[15];//职位描述
        }
        
        foreach ($info as $k => $v) 
        {
          //查询用户名是否存在
          $res = Db::table('user') -> where('username',$v['phone']) -> find();
          if(!$res)
          {
            //注册用户
            //准备数据
            $id = random();
            $data = [
              'id' => $id,
              'username' => $v['phone'],
              'add_time' => date('Y-m-d H:i:s'),
            ];

            Db::table('user') -> insert($data);

            //初始化用户详情
            //准备数据
            $select = ['http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon1.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon3.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon5.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon8.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/boys/icon9.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon2.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon4.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon6.png','http://wepin.oss-cn-shanghai.aliyuncs.com/defaultPic/girls/icon7.png'];
            $str = array_rand($select);
            $picture = $select[$str];
            
            Db::table('userinfo') -> insert(['id' => random(),'nickname' => $v['username'],'icon' => $picture,'city' => $v['city'],'uid' => $id]);
            Db::table('wallet') -> insert(['id' => random(),'uid' => $id]);
            Db::table('resume') -> insert(['id' => random(),'uid' => $id]);
            //添加需求
            //准备数据
            $employData = [
              'id' => random(),
              'employ_id' => $id,
              'title' => $v['title'],
              'address' => $v['address'],
              'description' => $v['description'],
              'requirement' => $v['requirement'],
              'task_price' => $v['account'],
              'task_type' => $v['type'],
              'add_time' => date('Y-m-d H:i:s')
            ];

            Db::table('employ') -> insert($employData);
          }else
          {
            //用户ID
            $uid = $res['id'];

            //添加需求
            //准备支付
            $employData = [
              'id' => random(),
              'employ_id' => $uid,
              'title' => $v['title'],
              'address' => $v['address'],
              'description' => $v['description'],
              'requirement' => $v['requirement'],
              'task_price' => $v['account'],
              'task_type' => $v['type'],
              'add_time' => date('Y-m-d H:i:s')
            ];
            Db::table('employ') -> insert($employData);
          }
        }
       
        $num = count($info);
        dump($num);die;
	      Session::flash('str',$str);
      }
      return view('userlist/insert');
    }
}