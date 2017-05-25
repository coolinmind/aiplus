<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/cate/index.html";i:1495439968;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/header.html";i:1495437469;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/footer.html";i:1495437469;}*/ ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0">

<!-- Plugin Stylesheets first to ease overrides -->
<link rel="stylesheet" type="text/css" href="/Backstage/plugins/colorpicker/colorpicker.css" media="screen">
<link rel="stylesheet" type="text/css" href="/Backstage/custom-plugins/wizard/wizard.css" media="screen">

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="/Backstage/bootstrap/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" type="text/css" href="/Backstage/css/fonts/ptsans/stylesheet.css" media="screen">
<link rel="stylesheet" type="text/css" href="/Backstage/css/fonts/icomoon/style.css" media="screen">

<link rel="stylesheet" type="text/css" href="/Backstage/css/mws-style.css" media="screen">
<link rel="stylesheet" type="text/css" href="/Backstage/css/icons/icol16.css" media="screen">
<link rel="stylesheet" type="text/css" href="/Backstage/css/icons/icol32.css" media="screen">

<!-- Demo Stylesheet -->
<link rel="stylesheet" type="text/css" href="/Backstage/css/demo.css" media="screen">

<!-- jQuery-UI Stylesheet -->
<link rel="stylesheet" type="text/css" href="/Backstage/jui/css/jquery.ui.all.css" media="screen">
<link rel="stylesheet" type="text/css" href="/Backstage/jui/jquery-ui.custom.css" media="screen">

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="/Backstage/css/mws-theme.css" media="screen">
<link rel="stylesheet" type="text/css" href="/Backstage/css/themer.css" media="screen">

<title>AiPlus助手后台</title>

</head>

<body>
    <!-- Header -->
    <div id="mws-header" class="clearfix">
    
        <!-- Logo Container -->
        <div id="mws-logo-container">
        
            <!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
            <div id="mws-logo-wrap">
                <img src="/Backstage/images/title.png" >
            </div>
        </div>
        
        <!-- User Tools (notifications, logout, profile, change password) -->
        <div id="mws-user-tools" class="clearfix">
            
            <!-- User Information and functions section -->
            <div id="mws-user-info" class="mws-inset">
            
                <!-- User Photo -->
                <div id="mws-user-photo">
                    <img id='pic' src="" >
                </div>
                
                <!-- Username and Functions -->
                <div id="mws-user-functions">
                    <div id="mws-username">
                        <?php if(\think\Session::get('admin')): ?>
                            <?php echo \think\Session::get('admin.name'); else: ?>
                            <a href='/admin/login'>请登录</a>
                        <?php endif; ?>
                    </div>
                    <ul>
                        <li><a href="/admin/detail">个人资料</a></li>
                        <li><a href="/admin/password">修改密码</a></li>
                        <li><a href="/admin/logout">退出</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
     <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
        <!-- Necessary markup, do not remove -->
        <div id="mws-sidebar-stitch"></div>
        <div id="mws-sidebar-bg"></div>
        
        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
        
            <!-- Hidden Nav Collapse Button -->
            <div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
           
            <!-- Main Navigation -->
            <div id="mws-navigation">
                <ul id='menu'>
                    <li class="active">
                        <a href="/admin"><i class="icon-home"></i> 首页</a>
                    </li> 
                        <?php if(\think\Session::get('arrs.name') == 'admin'): if(is_array(\think\Session::get('ret')) || \think\Session::get('ret') instanceof \think\Collection || \think\Session::get('ret') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Session::get('ret');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if(($v['parent_id'] == 0) && ($v['is_show'] == 1)): ?>
                                    <li class="open">
                                        <a><i class="icon-archive"></i class='bt1'><?php echo $v['menu_name']; ?></a>
                                        <ul style="display: none">
                                            <?php if(is_array(\think\Session::get('ret')) || \think\Session::get('ret') instanceof \think\Collection || \think\Session::get('ret') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Session::get('ret');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;if($v1['parent_id'] == $v['id']): if($v1['is_show'] == 1): ?>
                                                        <li class='list'><a url="<?php echo $v1['menu_path']; ?>" ids="<?php echo $v1['id']; ?>" href="javascript:;"><?php echo $v1['menu_name']; ?></a></li>
                                                    <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; else: if(is_array(\think\Session::get('menudata')) || \think\Session::get('menudata') instanceof \think\Collection || \think\Session::get('menudata') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Session::get('menudata');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;if(($v2['parent_id'] == 0) && ($v2['is_show'] == 1)): ?>
                                    <li class="open">
                                        <a><i class="icon-archive"></i class='bt1'><?php echo $v2['menu_name']; ?></a>
                                        <ul style="display: none">
                                            <?php if(is_array(\think\Session::get('in_id')) || \think\Session::get('in_id') instanceof \think\Collection || \think\Session::get('in_id') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Session::get('in_id');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;if(in_array(($v1['parent_id']), is_array($v2['id'])?$v2['id']:explode(',',$v2['id']))): if($v1['is_show'] == 1): ?>
                                                        <li class='list'><a url="<?php echo $v1['menu_path']; ?>" ids="<?php echo $v1['id']; ?>" href="javascript:;"><?php echo $v1['menu_name']; ?></a></li>
                                                    <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?> 
                </ul>
            </div>
        </div>
        <!-- <iframe src="" frameborder="0" id="if"></iframe> -->
<script src="/Backstage/js/libs/jquery-1.8.3.min.js"></script>      
<script>
    $(document).ready(function(){
        $("#open ul").not("#open ul:first").attr('class','closed');
        $("#open ul").not("#open ul:first").attr('style','display:none');
        $.ajax({
            url:'/info',
            type:'get', 
            async:true, 
            timeout:5000,    
            dataType:'json',   
            success:function(data){
                if(data.pic){
                    // console.log(data);
                    $('#pic').attr('src',data.pic);
                }else{
                    $('#pic').attr('src','/Backstage/example/profile.jpg');
                }
            },
            error:function(xhr,textStatus){
                // console.log('错误')
                // console.log(xhr)
                // console.log(textStatus)
            },
        })
    });

    $('.open').click(function(){

        $(this).find('ul').css('display','block');

    })

     function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    }

    var relft = getUrlParam('relft');
    
    if(relft){
        var aids = $("a[ids='"+relft+"']");
        var id1 =aids.parents('ul').css('display','block');
        var title =aids.text();
        aids.html('<i class="icon-reply-to-all" style="transform:rotate(180deg);-ms-transform:rotate(180deg);-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);-o-transform:rotate(180deg);"></i>'+title);
    }


    $('.list').click(function(){
        var url = $(this).find('a').attr('url');
        var ids = $(this).find('a').attr('ids');
        var href = url+"?relft="+ids;

        $(this).parent('li').css('display','block');
        // $('#if').attr('src',url)
        location.href = href;
    })
</script>
        
<div class="clearfix" id="mws-container">
	<div class="container">
		<div id="block" class="mws-panel grid_8">
			<div class="mws-panel-header">
		    	<span><i class="icon-table"></i> Simple Table</span>
		    </div>
		    <div class="mws-panel-body no-padding">
		        <table class="mws-table">
		            <thead>
		            	<tr align="center">
			            	<td colspan="3">
			            		<div class="mws-button-row">
                                    <input style="font-size:16px;" id="father" type="button" value="添加父分类" class="btn btn-danger">
                                </div>
			            	</td>
		            	</tr>
		                <tr>
		                    <th>ID</th>
		                    <th>分类名称</th>
		                    <th>操作</th>
		                </tr>
		            </thead>
		            <tbody>
		            	<?php foreach($list as $k => $v): ?>
		                <tr>
		                    <td><?php echo $v['id']; ?></td>
							<?php if($v['pid'] == 0): ?>
		                    <td style="color:#BF4545;font-size:18px;font-weight:bold"><?php echo $v['name']; ?></td>
		                    <?php elseif(substr_count($v['path'],',') == 1): ?>
							<td style="color:green;font-size:16px;font-weight:800"><?php echo $v['name']; ?></td>
							<?php else: ?>
							<td style="font-weight:bold"><?php echo $v['name']; ?></td>
							<?php endif; ?>
		                    <input class="pid" type="hidden" value="<?php echo $v['id']; ?>">
		                    <input class="path" type="hidden" value="<?php echo $v['path']; ?>">
		                    <td style="font-size:16px;text-align: center">
		                    	<a class="add" href="javascript:return false;">添加</a>
								<a class="edit" href="javascript:return false;">编辑</a>
								<a class="delete" href="javascript:return false;">删除</a>
		                    </td>
		                </tr>
		                <?php endforeach; ?>
		            </tbody>
		        </table>
		    </div>
		    
		</div>
		<div id="none" style="display:none" class="mws-panel grid_4">
            <div class="mws-panel-header">
                <span>添加分类</span>
            </div>
            <div class="mws-panel-body no-padding">
                <form class="mws-form" action="/admin/cate/insert" method="post">
                    <div class="mws-form-inline">
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">pid</label>
                            <div class="mws-form-item">
                                <input name="pid" id="pid" readonly type="text" class="large">
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">path</label>
                            <div class="mws-form-item">
                                <input name="path" id="path" readonly type="text" class="large">
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">父分类名</label>
                            <div class="mws-form-item">
                                <input id="pname" readonly type="text" class="large">
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">分类名称</label>
                            <div class="mws-form-item">
                                <input name="name" type="text" class="large">
                            </div>
                        </div>
                    </div>
                    <div class="mws-button-row">
                        <input type="submit" value="提交" class="btn btn-danger">
                        <input id="bak" type="button" value="返回" class="btn ">
                    </div>
                </form>
            </div>      
        </div>
        <div id="enone" style="display:none" class="mws-panel grid_4">
            <div class="mws-panel-header">
                <span>编辑分类</span>
            </div>
            <div class="mws-panel-body no-padding">
                <form class="mws-form" action="/admin/cate/doedit" method="post">
                    <div class="mws-form-inline">
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">id</label>
                            <div class="mws-form-item">
                                <input name="id" id="epid" readonly type="text" class="large">
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">选择父分类</label>
                            <div class="mws-form-item">
                                <select id="select" class="large" name="pid">
                                	<option value="0">根分类</option>
                                	<?php foreach($list as $k => $v): ?>
                                    <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                	<?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">分类名称</label>
                            <div class="mws-form-item">
                                <input id="ename" name="name" type="text" class="large">
                            </div>
                        </div>
                    </div>
                    <div class="mws-button-row">
                        <input type="submit" value="提交" class="btn btn-danger">
                        <input id="ebak" type="button" value="返回" class="btn ">
                    </div>
                </form>
            </div>      
        </div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		//添加
		$('.add').on('click',function(){
			var pid = $(this).parent().prev().prev().val();
			var path = $(this).parent().prev().val();
			var pname = $(this).parent().prev().prev().prev().html();
			var num = pname.indexOf('|');
			pname = pname.slice(num);
			$('#block').attr('style','display:none');
			$('#none').attr('style','display:block');
			$('#pid').val(pid);
			$('#path').val(path);
			$('#pname').val(pname);
			$('#pname').parent().parent().attr('style','display:block');
		})
		//返回
		$('#bak').on('click',function(){
			$('#block').attr('style','display:block');
			$('#none').attr('style','display:none');
		})

		//编辑
		$('.edit').on('click',function(){
			var epid = $(this).parent().prev().prev().val();
			var epath = $(this).parent().prev().val();

			$.ajax({
			    type: 'POST',
			    url: '/admin/cate/edit' ,
			    data: {"id":epid} ,
			    dataType: 'json',
			    success:function(data) {    
			        $('#ename').val(data.name);
			        
			        $('#select option').each(function(){
			        	if($(this).val() == data.pid)
			        	{
			        		$(this).attr('selected','selected');
			        	}
			        	if($(this).val() == epid)
			        	{
			        		$(this).attr('disabled','disabled');
			        	}
			        })
			    },    
			    error : function() {       
			        alert("异常！");    
			    }   
			});

			$('#block').attr('style','display:none');
			$('#enone').attr('style','display:block');
			$('#epid').val(epid);
			$('#epath').val(epath);
		})
		$('#ebak').on('click',function(){
			$('#block').attr('style','display:block');
			$('#enone').attr('style','display:none');
			$('#select option').each(function(){
	        	$(this).removeAttr('disabled');
	        })
		})
		$('#father').on('click',function(){
			$('#block').attr('style','display:none');
			$('#none').attr('style','display:block');
			$('#pid').val(0);
			$('#path').val(0);
			$('#pname').parent().parent().attr('style','display:none');
		})

		//删除
		$('.delete').on('click',function(){
			var id = $(this).parent().prev().prev().prev().prev().html();
			var obj = $(this).parent().parent();
			var msg = "您真的确定要删除吗？\n\n请确认！"; 
			if (confirm(msg)==true)
			{ 
				$.ajax({
				    type: 'POST',
				    url: '/admin/cate/delete' ,
				    data: {"id":id} ,
				    dataType: 'json',
				    success:function(data) {
				    	
				    	if(data.info != '有子分类,无法删除')
				    	{
				    		if(data.info == '删除成功')
					    	{
					    		obj.remove();
					    	} 	
				    	}
				    	alert(data.info);
				    },    
				    error : function() {       
				        alert("异常！");    
				    }   
				});
			}
		})
	})
</script>
            <!-- Footer -->
            <div id="mws-footer">
            	微聘后台 - 2017
            </div>
            
        </div>
        <!-- Main Container End -->
        
    </div>

    <!-- JavaScript Plugins -->
    <script src="/Backstage/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/Backstage/js/libs/jquery.mousewheel.min.js"></script>
    <script src="/Backstage/js/libs/jquery.placeholder.min.js"></script>
    <script src="/Backstage/custom-plugins/fileinput.js"></script>
    
    <!-- jQuery-UI Dependent Scripts -->
    <script src="/Backstage/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="/Backstage/jui/jquery-ui.custom.min.js"></script>
    <script src="/Backstage/jui/js/jquery.ui.touch-punch.js"></script>

    <!-- Plugin Scripts -->
    <!-- <script src="/Backstage/plugins/datatables/jquery.dataTables.min.js"></script> -->
    <!--[if lt IE 9]>
    <script src="js/libs/excanvas.min.js"></script>
    <![endif]-->
    <script src="/Backstage/plugins/flot/jquery.flot.min.js"></script>
    <script src="/Backstage/plugins/flot/plugins/jquery.flot.tooltip.min.js"></script>
    <script src="/Backstage/plugins/flot/plugins/jquery.flot.pie.min.js"></script>
    <script src="/Backstage/plugins/flot/plugins/jquery.flot.stack.min.js"></script>
    <script src="/Backstage/plugins/flot/plugins/jquery.flot.resize.min.js"></script>
    <script src="/Backstage/plugins/colorpicker/colorpicker-min.js"></script>
    <script src="/Backstage/plugins/validate/jquery.validate-min.js"></script>
    <script src="/Backstage/custom-plugins/wizard/wizard.min.js"></script>

    <!-- Core Script -->
    <script src="/Backstage/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Backstage/js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script src="/Backstage/js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script src="/Backstage/js/demo/demo.dashboard.js"></script>
    <script src="/Backstage/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/Backstage/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="/Backstage/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/Backstage/plugins/colorpicker/colorpicker-min.js"></script>
    <script src="/Backstage/js/demo/demo.table.js"></script>  
</body>
</html>