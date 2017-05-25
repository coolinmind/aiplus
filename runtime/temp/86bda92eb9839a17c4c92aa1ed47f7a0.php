<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/data/wwwroot/dev.happyoneplus.com/public/../application/index/view/1.html";i:1491817127;}*/ ?>
 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登陆</title>
	<link rel="stylesheet" href="/Backstage/bootstrap/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/Backstage/bootstrap/css/bootstrap.min.css" type="text/css" />
</head>
<body style='background: #FFCA08;' style='width:100%;'>
	<div class='container-fluid'>
		<div style="margin-left: 10px;margin-top: 20px;">
			<img style="margin-top: -18px;" src="/Backstage/images1/title.png" width='40' alt="">
			<span style='padding-top:10px;font-family:Microsoft YaHei;font-size: 28px;color:#666;'>&nbsp;AiPlus-微聘助手</span>
		</div>
		<div style='margin-top: 80px'>
			<div style="width:380px;height:380px;border-radius: 20px;background: white;margin: 0 auto;">	
				<p style='padding-top: 20px;font-size: 16px;font-family:Microsoft YaHei;text-align: center;'>登录微聘助手</p>
				<div id='code' style='margin-left: 100px;position: relative;'>
					<img  src="<?php echo url('/index/qrcodes/qrcodes'); ?>" alt="">
				</div>
				<div style="margin-top: 15px;">
					<p style='font-size: 16px;text-align: center;font-family:Microsoft YaHei;'>请使用微聘助手扫码一键登录</p>
					<p style='font-size: 16px;text-align: center;font-family:Microsoft YaHei;'>AiPlus智能招聘助手</p>
				</div>
				<div style="margin-left: 80px;margin-top: 25px;">
					<a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;" href="#" data-toggle="modal" data-target="#myModal">下载APP</a>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;" href="#" data-toggle="modal" data-target="#myModal">　登陆　</a>
				</div>
			</div>
			<div style="position:fixed; bottom: 0;width: 100%;">
					<p style='color:#666;width: 100%;text-align: center;'>客服热线：010-57213025 （周一至周六10:00-19:00）Copyright © 2017</p>
			</div>
		</div>
	</div>
</body>
<script src='/Backstage/js/libs/jquery-1.8.3.min.js'></script>
<script>

	// var thisHREF = navigator.userAgent;;
	// console.log(thisHREF);
	setTimeout("timeCode()",10000);
	function timeCode()
	{
		$('#code').html('<img  src="<?php echo url("/index/qrcodes/qrcodes"); ?>" alt=""><div style="position: absolute;background: #000;filter: alpha(opacity=60);-moz-opacity: .6;opacity: .6;height: 180px;left:0px;top: 0px;width:180px;text-align: center;line-height: 100px;z-index: 9;"></div><p style="color: #fbfbfb;z-index: 19;position: absolute;top: 60px;left: 52px;" class="err-cont">二维码已失效</p><a style="position: absolute;top: 100px;left: 68px;cursor: pointer;z-index:19;color: #fbfbfb;" href="javascript:void(0)" class="btn btn-danger btn-lg disabled" onclick="renovate()" class="refresh-btn">刷新</a>');
	}

	function renovate()
	{
		 $.ajax( {
	         type : "post",
	         url  : "/index/qrcodes/renovateCode",
	         timeout : 2000,
	         async:true,
	         success : function(data) {
	         		
	         		// console.log(data);
					$('#code').html('<div><img src="'+data+'" alt=""></div>');
	         },
	         error : function() {
				$('#code').html('<img  src="<?php echo url("/index/qrcodes/qrcodes"); ?>" alt=""><div style="position: absolute;background: #000;filter: alpha(opacity=60);-moz-opacity: .6;opacity: .6;height: 180px;left:0px;top: 0px;width:180px;text-align: center;line-height: 100px;z-index: 9;"></div><p style="color: #fbfbfb;z-index: 19;position: absolute;top: 60px;left: 52px;" class="err-cont">二维码发生错误</p><a style="position: absolute;top: 100px;left: 68px;cursor: pointer;z-index:19;color: #fbfbfb;" href="javascript:void(0)" class="btn btn-danger btn-lg disabled" onclick="renovate()" class="refresh-btn">刷新</a>');
	         }
        });
		  setTimeout("timeCode()",10000);
	}

</script>
</html>