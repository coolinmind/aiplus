<?php
namespace app\index\controller;
use think\Request;
use think\Loader;
use app\index\model\Common;
use scws\pscws4;
use think\Db;
use think\Controller;
use PHPExcel_IOFactory;
use PHPExcel;
use Oss\Core\OssException;
use OSS\OssClient;
class Index extends controller
{
    public function index()
    {
      if(Request::instance()->isGet())
      {
        echo "<script type='text/javascript'>
                 window.onload = function() {
                  var show = document.getElementById('show');
                  var nowTime = function()
                  {
                       var time = new Date();
                       // 程序计时的月从0开始取值后+1
                       var m = time.getMonth() + 1;
                       if(m < 10)
                       {
                            m = '0' + m;
                       }
                       var d = time.getDate();
                       if(d < 10)
                       {
                            d = '0' + d;
                       }

                       var h = time.getHours();
                       if(h < 10)
                       {
                            h = '0' + h;
                       }

                       var minutes = time.getMinutes();
                       if(minutes < 10)
                       {
                            minutes = '0' + minutes;
                       }

                       var s = time.getSeconds();
                       if(s < 10)
                       {
                            s = '0' + s;
                       }

                       var t = time.getFullYear() + '-' + m + '-'
                         + d + ' ' + h + ':'
                         + minutes + ':' + s;
                       show.innerHTML = t; 
                  }
                  nowTime();
                  setInterval(function() {
                        nowTime();
                  }, 1000);
                 };
                </script>";
        echo "<center>
                <div id='show' style='background:green;height:100px;line-height:100px;font-size:40px;'></div>
              </center>";
        }else
        {
          $config = [
            'KeyId'      => '',  //您的Access Key ID
            'KeySecret'  => '',  //您的Access Key Secret
            'Endpoint'   => '',  //阿里云oss 外网地址endpoint
            'Bucket'     => '',  //Bucket名称
          ];

          $file = $_FILES['filename'];
          $pos = strpos($file['name'],'.');
          
          $str = substr($file['name'],-$pos);
          
          $accessKeyId = "LTAIFM9vTjS9GJAM";
          $accessKeySecret = "UkQhLHAVhswUOIFvXPqwDMMpLX89KW";
          $endpoint = "oss-cn-shanghai.aliyuncs.com";
          $bucket= "wepin";
          $content = "Hi, OSS.";
          $date = date('Ymd');
          $object = "test/$date/".date('Ymd').substr(md5(uniqid()),0,12).rand('1111','9999').$str;
          
          $filePath = $file['tmp_name'];
          
          try{
              $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
              $ossClient->uploadFile($bucket, $object, $filePath);
          } catch(OssException $e) {
              printf(__FUNCTION__ . ": FAILED\n");
              printf($e->getMessage() . "\n");
              return;
          }
          print(__FUNCTION__ . ": OK" . "\n");
        }
    }

    public function test()
    {
    function id(){
            return substr(md5(uniqid(md5(microtime(true)),true)),-24);
        }
    echo id();
    echo '<hr>';
    echo id();
    }

    public function ine(Request $request){

    	import('extend.upyun.vendor.autoload');

        $client = new \Upyun('wepin','test1','test1234');

        $pic = $_FILES['file'];
        // 图片上传
        $fh = fopen($pic['tmp_name'], 'r');  
        // 图片压缩 
        $tasks = array('x-gmkerl-thumb' => '/fw/300//fh/300/unsharp/true/quality/80/format/png');
        // 防止图片名称冲突 
        $picname = date('Ymd').substr(md5(uniqid()),0,12).rand('1111','9999').'.png';
        // 获取时间去创建文件
        $time = date('Y-m-d');
        // 上传到upyun
        $client->writeFile('/image/'.$time.'/'.$picname , $fh , true ,$tasks);
        // 关闭资源集
        fclose($fh);
        // 图片路径
        $picurl = 'upload.happyoneplus.com/image/'.$time.'/'.$picname;
        echo $picurl;
    }

    public function participle(Request $request)
    {
        $where = json_decode(input('WhereJson'),true);
        $limit = json_decode(input('Limit'),true)['limit'];
        $limit = $limit.','.($limit+10);
        $data = [];
        Vendor('scws.pscws4');
        $pscws = new PSCWS4();
        $pscws->set_charset('utf-8');
        $pscws->set_dict(VENDOR_PATH.'scws/lib/dict.utf8.xdb');
        $pscws->set_rule(VENDOR_PATH.'scws/lib/rules.utf8.ini');
        $pscws->set_ignore(true);
        // $str = implode('', $content);
        $title = $where['title'];
        $pscws->send_text($title);
        $words = $pscws->get_tops(100);
        $tags = array();
        foreach ($words as $val) {
            $tags[] = $val['word'];
        }
        $pscws->close();
        // return json([1=>$tags]);
        foreach ($tags as $k => $v) {
            // if($v == '任务'){
            //     return json(['success'=>'任务页面']);
            // }

            // if($v == '需求'){
            //     return json(['success'=>'需求页面']);
            // }

            $num = count($tags);
            for ($i=0; $i < $num; $i++) { 
                $res = Db::table('employ')->where('title','like',"%$tags[$i]%")->order('add_time desc')->limit($limit)->select();
                if($res){
                    foreach ($res as $k => $v) {
                        if($v['is_delete'] == 0){
                            $info = Db::table('userinfo')->where('uid',$v['employ_id'])->select();
                            if($info){
                                foreach ($info as $key => $value) {
                                  $time = strtotime($v['add_time']);
                                  $time = friend_date($time);
                                  $v['add_time'] = $time;
                                  $data[] = [
                                      'id'=>$v['id'],
                                      'employ_id'=>$v['employ_id'],
                                      'worker_id'=>$v['worker_id'],
                                      'title'=>$v['title'],
                                      'task_time'=>$v['task_time'],
                                      'address'=>$v['address'],
                                      'description'=>$v['description'],
                                      'requirement'=>$v['requirement'],
                                      'type'=>$v['type'],
                                      'task_tags'=>$v['task_tags'],
                                      'task_price'=>$v['task_price'],
                                      'method'=>$v['method'],
                                      'task_type'=>$v['task_type'],
                                      'employ_status'=>$v['employ_status'],
                                      'review_times'=>$v['review_times'],
                                      'is_delete'=>$v['is_delete'],
                                      'add_time'=>$v['add_time'],
                                      'settlement_type'=>$v['settlement_type'],
                                      'photo'=>$value['icon']
                                  ]; 
                              }
                            }else{
                                $data[] = [
                                    'id'=>$v['id'],
                                    'employ_id'=>$v['employ_id'],
                                    'worker_id'=>$v['worker_id'],
                                    'title'=>$v['title'],
                                    'task_time'=>$v['task_time'],
                                    'address'=>$v['address'],
                                    'description'=>$v['description'],
                                    'requirement'=>$v['requirement'],
                                    'type'=>$v['type'],
                                    'task_tags'=>$v['task_tags'],
                                    'task_price'=>$v['task_price'],
                                    'method'=>$v['method'],
                                    'task_type'=>$v['task_type'],
                                    'employ_status'=>$v['employ_status'],
                                    'review_times'=>$v['review_times'],
                                    'is_delete'=>$v['is_delete'],
                                    'add_time'=>$v['add_time'],
                                    'settlement_type'=>$v['settlement_type'],
                                ]; 
                            }
                            
                        }

                    }

                    return json($data);
                }else{
                    return json(['error'=>false]);
                }
            }
            
        }
    }
}
