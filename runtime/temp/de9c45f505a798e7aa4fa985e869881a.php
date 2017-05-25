<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"/data/wwwroot/dev.happyoneplus.com/public/../application/home/view/register/index.html";i:1492573472;}*/ ?>
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
		<div class="content"  id="form-content">
			<div style="width:380px;height:330px;border-radius: 20px;background: white;margin: 0 auto;">
		    <p style="padding-top:36px;font-size: 16px;font-family:Microsoft YaHei;text-align: center;color: #F00;font-weight: bold;">
		        注册微聘助手
		    </p>
		    <form style="margin-left: 28px;padding-top:6px" class="form-inline" method="post"
		    onsubmit="return false;">
		        <div class="form-group">
		            <label class="sr-only" for="exampleInputAmount">
		            </label>
		            <div class="input-group">
		                <div class="input-group-addon">
		                    <span class="glyphicon glyphicon-user">
		                    </span>
		                </div>
		                <input style="width: 282px;" type="text" class="form-control" id="names"
		                onkeydown="b_onclicks()" placeholder="注册手机号">
		            </div>
		            <div>
		                <span id="usererror" style="color: #f00;font-size: 13px;">
		                </span>
		            </div>
		            <div style="margin-top:30px" class="form-group">
		                <label class="sr-only" for="exampleInputAmount">
		                </label>
		                <div class="input-group">
		                    <div class="input-group-addon">
		                        <span class="glyphicon glyphicon-lock">
		                        </span>
		                    </div>
		                    <input type="text" style="width: 190px;" class="form-control" id="phonecode"
		                    value="" onkeydown="b_onclicks()" placeholder="请输入短信验证码">
		                </div>
		                <input type="text" value="获取验证码" style="float: right;margin-top: 0px;border-radius: 3px;border: 1px solid #ccc;height: 33px;width: 92px;background: #eee;cursor: pointer;text-align:center;"
		                id="blue">
		                <div>
		                    <span id="pwderror" style="color: #f00;font-size: 13px;">
		                    </span>
		                </div>
		            </div>
		            <div>
		                <a style="margin-top:30px;margin-left: 2px;width: 320px;" href="javascript:;"
		                class="btn btn-danger" onclick="submits()">
		                    注 册
		                </a>
		            </div>
		    </form>
		    <div style="margin-top: 20px;margin-left: 105px">
		        <p style="color:#9fa3b0;">
		            已有账号
		            <a href="javascript:;" id="form-data">
		                立即登陆
		            </a>
		        </p>
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