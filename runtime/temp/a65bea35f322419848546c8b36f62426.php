<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"/data/wwwroot/dev.happyoneplus.com/public/../application/home/view/login/index.html";i:1495439982;}*/ ?>
 <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>AiPlus登陆</title>
	<link rel="stylesheet" href="/Backstage/bootstrap/css1/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/Backstage/bootstrap/css1/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="/home/css/login.css" type="text/css" />
	 <meta name="keywords" content="free mobile website templates, free mobile website template, free iphone template, free android template, free high end touch mobile templates, free high end touch mobile template" />
    <meta name="description" content="Get free mobile website templates for Iphone , Android and High end touch mobile devices" />
</head>
<body style="background: #FFCA08;" style="width:100%;">
	<div class="container-fluid">
		<div class="top" >
			<img class="top_img" src="/Backstage/images1/title.png" width="40" alt="">
			<span class="top_span">&nbsp;AiPlus-微聘助手</span>
		</div>
		<div class="content" id="form-content">
			<div class="con_div1">	
				<p class="con_p">扫码登录微聘助手</p>
				<div id="code" class="con_code">
					<img  src="<?php echo url('/login/qrcodes'); ?>" alt="">
					<div id="zezhao"></div>
				</div>
				<div class="con_div2">
					<p class="con_p1">请使用微聘助手扫码一键登录</p>
					<p class="con_p1">AiPlus智能招聘助手</p>
				</div>
				<div style="margin-left: 90px;margin-top: 25px;">
					<a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;cursor: pointer;" href="javascript:;" data-toggle="modal" data-target="#myModal">扫码登陆</a>
					&nbsp;&nbsp;
					<a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;cursor: pointer;" href="javascript:;" id="form-data" data-toggle="modal" data-target="#myModal">账号登陆</a>&nbsp;&nbsp;
				
				</div>
				<div style="margin-top: 25px;margin-left: 135px">
					<p style="color:#9fa3b0;">没有账号 <a href="javascript:;" id="form-info">立即注册</a></p>
				</div>
			</div>
		</div>
		<div class="bottom">
			<p class="bottom_p">客服热线：010-57213025 （周一至周六10:00-19:00）Copyright © 2017</p>
		</div>
	</div>
</body>
<script src='/Backstage/js/libs/jquery-1.8.3.min.js'></script>
<script src='/home/js/login.js'></script>
</html>