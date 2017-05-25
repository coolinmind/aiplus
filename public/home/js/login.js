	//定时切换
	setTimeout("timeCode()",60000);

	// 遮罩
	function timeCode()
	{
		$('#zezhao').html('<div style="position: absolute;background: #000;filter: alpha(opacity=60);-moz-opacity: .6;opacity: .7;height: 180px;left:0px;top: 0px;width:180px;text-align: center;line-height: 100px;z-index: 9;"></div><p style="color: #fbfbfb;z-index: 19;position: absolute;top: 60px;left: 52px;" class="err-cont">二维码已失效</p><a style="position: absolute;top: 100px;left: 68px;cursor: pointer;z-index:19;color: #fbfbfb;background:#e4393c;width:52px;text-align:center;padding-top:3px;padding-bottom:3px;border-radius:6px;" href="javascript:void(0)"  onclick="renovate()" >刷新</a>');
	}

	// 二维码切换
	function renovate()
	{
		 $.ajax( {
	         type : "get",
	         url  : "/login/renovateCode",
	         timeout : 2000,
	         async:true,
	         success : function(data) {
	         		
	         		// console.log(data);
					$('#code').html('<div><img src="'+data+'" alt=""></div><div id="zezhao"></div>');
	         },
	         error : function() {
				$('#zezhao').html('<div style="position: absolute;background: #000;filter: alpha(opacity=60);-moz-opacity: .6;opacity: .7;height: 180px;left:0px;top: 0px;width:180px;text-align: center;line-height: 100px;z-index: 9;"></div><p style="color: #fbfbfb;z-index: 19;position: absolute;top: 60px;left: 52px;" class="err-cont">二维码发生错误</p><a style="position: absolute;top: 100px;left: 66px;cursor: pointer;z-index:19;color: #fbfbfb;background:#e4393c;width:52px;text-align:center;padding-top:3px;padding-bottom:3px;border-radius:6px;" href="javascript:void(0)"  onclick="renovate()">刷新</a>');
	         }
        });
		setTimeout("timeCode()",60000);
	}

	//点击切换账号登陆页面
	$('#form-data').live('click',function(){
		// console.log(1);
		$('#form-content').html('<div style="width:380px;height:370px;border-radius: 20px;background: white;margin: 0 auto;"><p style="padding-top:36px;font-size: 16px;font-family:Microsoft YaHei;text-align: center;">账号登录微聘助手</p><form style="margin-left: 28px;padding-top:6px" class="form-inline" method="post" onsubmit="return false;"><div  class="form-group"><label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label><div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div><input style="width: 282px;" type="text" class="form-control" id="name" onkeydown="b_onclick()" placeholder="登陆手机号"></div><div><span id="usererror" style="color: #f00;font-size: 13px;"></span></div><div style="margin-top:30px" class="form-group"><label class="sr-only" for="exampleInputAmount"></label><div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div><input type="text" style="width: 190px;" class="form-control" id="pwd" value="" onkeydown="b_onclick()" placeholder="请输入短信验证码"></div><input type="text" value="获取验证码" style="float: right;margin-top: 0px;border-radius: 3px;border: 1px solid #ccc;height: 33px;width: 92px;background: #eee;cursor: pointer;text-align:center;" id="blue"><div><span id="pwderror" style="color: #f00;font-size: 13px;"></span></div></div><div><a style="margin-top:30px;margin-left: 2px;width: 320px;" href="javascript:;" class="btn btn-danger" onclick="submit()">立即登陆</a></div></form><div style="margin-left: 65px;margin-top: 35px;"><a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;" href="javascript:;"  data-toggle="modal" data-target="#myModal" class="dates">扫码登陆</a>&nbsp;&nbsp;<a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;cursor: pointer;"  data-toggle="modal" href="javascript:;" data-target="#myModal">账号登陆</a>&nbsp;&nbsp;</div><div style="margin-top: 25px;margin-left: 110px"><p style="color:#9fa3b0;">没有账号 <a href="javascript:;" id="form-info">立即注册</a></p></div></div>');
	})

	// 点击切换扫描页面
	$('.dates').live('click',function(){
		 $.ajax( {
	         type : "get",
	         url  : "/login/renovateCode",
	         timeout : 2000,
	         async:true,
	         success : function(data) {
				$('#form-content').html('<div style="width:380px;height:410px;border-radius: 20px;background: white;margin: 0 auto;"><p style="padding-top: 20px;font-size: 16px;font-family:Microsoft YaHei;text-align: center;">登录微聘助手</p><div id="code" style="margin-left: 100px;position: relative;"><img  src="'+data+'" alt=""><div id="zezhao"></div></div><div style="margin-top: 15px;"><p style="font-size: 16px;text-align: center;font-family:Microsoft YaHei;">请使用微聘助手扫码一键登录</p><p style="font-size: 16px;text-align: center;font-family:Microsoft YaHei;">AiPlus智能招聘助手</p></div><div style="margin-left: 90px;margin-top: 25px;"><a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;cursor: pointer;" href="javascript:;" data-toggle="modal" data-target="#myModal">扫码登陆</a>&nbsp;&nbsp;<a style="font-size:14px;background: #ffffff;color: #ffca08; padding: 8px 20px;border:1px solid #ffca08; border-radius:20px;cursor: pointer;" href="javascript:;" id="form-data" data-toggle="modal" data-target="#myModal">账号登陆</a>&nbsp;&nbsp;</div><div style="margin-top: 25px;margin-left: 135px"><p style="color:#9fa3b0;">没有账号 <a href="javascript:;" id="form-info">立即注册</a></p></div></div>');
	         },
	         error : function() {
				$('#zezhao').html('<div style="position: absolute;background: #000;filter: alpha(opacity=60);-moz-opacity: .6;opacity: .7;height: 180px;left:0px;top: 0px;width:180px;text-align: center;line-height: 100px;z-index: 9;"></div><p style="color: #fbfbfb;z-index: 19;position: absolute;top: 60px;left: 52px;" class="err-cont">二维码发生错误</p><a style="position: absolute;top: 100px;left: 66px;cursor: pointer;z-index:19;color: #fbfbfb;background:#e4393c;width:52px;text-align:center;padding-top:3px;padding-bottom:3px;border-radius:6px;" href="javascript:void(0)"  onclick="renovate()">刷新</a>');
	         }
        });
		setTimeout("timeCode()",60000);
	})

	// 点击发送验证码
	$('#blue').live('click',function(){
		var name = $('#name').val();
		var names = $('#names').val();
		if(name){
			$.ajax({
				type : "post",
				url  : "/login/SmsCode",
				data : {
						'username':name,
						'status':'login',
					},
				timeout : 2000,
				async:true,
				dataType:'json',
				success : function(data) {
					// console.log(data);	
					if(data.error){
						$('#pwderror').text('');
						$('#usererror').text(data.text);
					}else if(data.msg){
						$('#usererror').text('');
						$('#pwderror').text('验证码发送失败了,请重新尝试！');
					}else if(data.sub_msg){
						$('#usererror').text('');
						$('#pwderror').text(data.sub_msg);
					}else{
						$('#usererror').text('');
						$('#pwderror').text('');
						time();
					}
				},
				error : function() {
					$('#usererror').text('');
					$('#pwderror').text('验证码发送失败了,请重新尝试！');
				}
			});
		}else if(names){
			$.ajax({
				type : "post",
				url  : "/login/SmsCode",
				data : {
						'username':names,
						'status':'register',
					},
				timeout : 2000,
				async:true,
				dataType:'json',
				success : function(data) {
					// console.log(data);	
					if(data.error){
						$('#pwderror').text('');
						$('#usererror').text(data.text);
					}else if(data.code || data.msg){
						$('#usererror').text('');
						$('#pwderror').text('验证码发送失败了,请重新尝试！');
					}else if(data.sub_msg){
						$('#usererror').text('');
						$('#pwderror').text(data.sub_msg);
					}else{
						$('#usererror').text('');
						$('#pwderror').text('');
						time();
					}
				},
				error : function() {
					$('#usererror').text('');
					$('#pwderror').text('验证码发送失败了,请重新尝试！');
				}
			});

		}else{

			$('#usererror').text('用户名不能为空！');
			
		}
	})

	// 验证码倒计时函数
	var wait=60;
	function time(o) {
	    if (wait == 0) {
	      $('#blue').removeAttr("disabled");      
	      $('#blue').val("重新发送");
	      wait = 60;
	    } else {
	      $('#blue').attr("disabled", true);  
	      $('#blue').val("重新发送(" + wait + "s)");
	      wait--;
	      setTimeout(function() {
	        time(o)
	      },
	      1000);
	    }
	  }

	//立即登陆点击提交
	function submit(){
		var name = $('#name').val();
		var pwd  = $('#pwd').val();
		$.ajax( {
		         type : "post",
		         url  : "/login/enter",
		         data : {
							'username':name,
							'pwd':pwd,
						},
		         timeout : 2000,
		         async:true,
		         dataType:'json',
		         success : function(data) {
					// alert(data.error);
					// console.log(data);
					if(data.error && data.text){
						if(data.error == 10000){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10002){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10003){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10004){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10010){

							alert(data.text);

						}else if(data.error == 10011){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}
					}else{
						 location.href =data.success;
						 // var a= "{:url('data.success')}";
						 // console.log(a);
					}
					
		         },
		         error : function() {
		         	$('#usererror').text('');
					$('#pwderror').text('发生未知错误,请重新尝试！');
		         }
	        });
	}
	// 登陆input 回车提交
	function b_onclick()
	{
		var name = $('#name').val();
		var pwd  = $('#pwd').val();
		if(event.keyCode == 13){
			$.ajax( {
		         type : "post",
		         url  : "/login/enter",
		         data : {
							'username':name,
							'pwd':pwd,
						},
		         timeout : 2000,
		         async:true,
		         dataType:'json',
		         success : function(data) {
					// alert(data.error);
					// console.log(data);
					if(data.error && data.text){
						if(data.error == 10000){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10002){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10003){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10004){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10010){

							alert(data.text);

						}else if(data.error == 10011){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}
						
					}else{
						 location.href =data.success;
						 // var a= "{:url('data.success')}";
						 // console.log(a);
					}
					
		         },
		         error : function() {
		         	$('#usererror').text('');
					$('#pwderror').text('发生位置错误,请重新尝试！');
		         }
	        });
		}
	}

	//注册
	$('#form-info').live('click',function(){

		$('#form-content').html('<div style="width:380px;height:320px;border-radius: 20px;background: white;margin: 0 auto;"><p style="padding-top:36px;font-size: 16px;font-family:Microsoft YaHei;text-align: center;color: #F00;font-weight: bold;">注册微聘助手</p><form style="margin-left: 28px;padding-top:6px" class="form-inline" method="post" onsubmit="return false;"><div  class="form-group"><label class="sr-only" for="exampleInputAmount"></label><div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div><input style="width: 282px;" type="text" class="form-control" id="names" onkeydown="b_onclicks()" placeholder="注册手机号"></div><div><span id="usererror" style="color: #f00;font-size: 13px;"></span></div><div style="margin-top:30px" class="form-group"><label class="sr-only" for="exampleInputAmount"></label><div class="input-group"><div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div><input type="text" style="width: 190px;" class="form-control" id="phonecode" value="" onkeydown="b_onclicks()" placeholder="请输入短信验证码"></div><input type="text" value="获取验证码" style="float: right;margin-top: 0px;border-radius: 3px;border: 1px solid #ccc;height: 33px;width: 92px;background: #eee;cursor: pointer;text-align:center;" id="blue"><div><span id="pwderror" style="color: #f00;font-size: 13px;"></span></div></div><div><a style="margin-top:30px;margin-left: 2px;width: 320px;" href="javascript:;" class="btn btn-danger" onclick="submits()">注 册</a></div></form><div style="margin-top: 25px;margin-left: 105px"><p style="color:#9fa3b0;">已有账号 <a href="javascript:;" id="form-data">立即登陆</a></p></div></div>');
		// console.log(1);    
	})

	//注册input 回车提交
	function b_onclicks()
	{
		var names = $('#names').val();
		var phonecode  = $('#phonecode').val();
		if(event.keyCode == 13){
			$.ajax( {
		         type : "post",
		         url  : "/login/register",
		         data : {
							'username':names,
							'phonecode':phonecode,
						},
		         timeout : 2000,
		         async:true,
		         dataType:'json',
		         success : function(data) {
					// alert(data.error);
					// console.log(data);
					if(data.error && data.text){
						if(data.error == 10000){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10002){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10003){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10004){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10010){

							alert(data.text);

						}else if(data.error == 10011){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}
						
					}else{
						 location.href =data.success;
						 // console.log(data);
					}
					
		         },
		         error : function() {
		         	$('#usererror').text('');
					$('#pwderror').text('发生位置错误,请重新尝试！');
		         }
	        });
		}
	}

	//注册提交
	function submits(){
		// alert(1);
		var names = $('#names').val();
		var phonecode  = $('#phonecode').val();
		$.ajax( {
		         type : "post",
		         url  : "/login/register",
		         data : {
							'username':names,
							'phonecode':phonecode,
						},
		         timeout : 2000,
		         async:true,
		         dataType:'json',
		         success : function(data) {
					// alert(data.error);
					// console.log(data);
					if(data.error && data.text){
						if(data.error == 10000){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10002){

							$('#usererror').text(data.text);
							$('#pwderror').text('');
						}else if(data.error == 10003){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10004){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}else if(data.error == 10010){

							alert(data.text);

						}else if(data.error == 10011){

							$('#pwderror').text(data.text);
							$('#usererror').text('');
						}
					}else{
						 location.href =data.success;
						 // console.log(data);
					}
					
		         },
		         error : function() {
		         	$('#usererror').text('');
					$('#pwderror').text('发生位置错误,请重新尝试！');
		         }
	        });
		}