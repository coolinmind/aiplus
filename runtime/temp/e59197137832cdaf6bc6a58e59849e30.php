<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:84:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/employ/edit.html";i:1492586239;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/header.html";i:1492571762;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/footer.html";i:1492573186;}*/ ?>
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

<title>微聘后台</title>

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
                                    <li id="open">
                                        <a><i class="icon-list"></i class='bt1'><?php echo $v['menu_name']; ?></a>
                                        <ul>
                                            <?php if(is_array(\think\Session::get('ret')) || \think\Session::get('ret') instanceof \think\Collection || \think\Session::get('ret') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Session::get('ret');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;if($v1['parent_id'] == $v['id']): if($v1['is_show'] == 1): ?>
                                                        <li class='list'><a href="<?php echo $v1['menu_path']; ?>"><?php echo $v1['menu_name']; ?></a></li>
                                                    <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; else: if(is_array(\think\Session::get('menudata')) || \think\Session::get('menudata') instanceof \think\Collection || \think\Session::get('menudata') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Session::get('menudata');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;if(($v2['parent_id'] == 0) && ($v2['is_show'] == 1)): ?>
                                    <li >
                                        <a><i class="icon-list"></i class='bt1'><?php echo $v2['menu_name']; ?></a>
                                        <ul >
                                            <?php if(is_array(\think\Session::get('in_id')) || \think\Session::get('in_id') instanceof \think\Collection || \think\Session::get('in_id') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Session::get('in_id');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;if(in_array(($v1['parent_id']), is_array($v2['id'])?$v2['id']:explode(',',$v2['id']))): if($v1['is_show'] == 1): ?>
                                                        <li class='list'><a href="<?php echo $v1['menu_path']; ?>"><?php echo $v1['menu_name']; ?></a></li>
                                                    <?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?> 
                </ul>
            </div>
        </div>

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

</script>
        
<div id="mws-container" class="clearfix">
	<div class="container">
	    <div class="mws-panel grid_4">
		    <div class="mws-panel-header">
		        <span><i class="icon-comments"></i>需求修改</span>
		    </div>
		    <div class="mws-panel-body no-padding" >
                <form class="mws-form" action="form_layouts.html">
                    <?php if(\think\Session::get('tis11') == 2): ?>
                        <div class="mws-form-message error">
                            操作失败 点击消失
                        </div>
                    <?php endif; ?>
                </form>
            </div>
		    <div class="mws-panel-body no-padding">
		        <form class="mws-form" action="/admin/employ/update" method="post">
		            <div class="mws-form-inline">
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">ID：</label>
		                    <div class="mws-form-item">
		                        <span><?php echo $res['id']; ?></span>
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">雇主ID：</label>
		                    <div class="mws-form-item">
		                        <span><?php echo $res['employ_id']; ?></span>
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">能人ID：</label>
		                    <div class="mws-form-item">
		                        <span><?php echo $res['worker_id']; ?></span>
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">任务名称：</label>
		                    <div class="mws-form-item">
		                        <input type="text" class="large" name="title" value="<?php echo $res['title']; ?>">
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">时间预算：</label>
		                    <div class="mws-form-item">
		                        <input type="text" class="large" name="task_time" value="<?php echo $res['task_time']; ?>">
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">工作地点：</label>
		                    <div class="mws-form-item">
		                        <input type="text" class="large" name="address" value="<?php echo $res['address']; ?>">
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">任务简介：</label>
		                    <div class="mws-form-item">
		                        <!-- <input type="text" class="large" name="description" value="<?php echo $res['description']; ?>"> -->
		                        <textarea name="description"  rows="3" cols="45"><?php echo $res['description']; ?></textarea>
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">雇主要求：</label>
		                    <div class="mws-form-item">
		                        <!-- <input type="text" class="large" name="requirement" value="<?php echo $res['requirement']; ?>"> -->
		                        <textarea name="requirement"  rows="3" cols="45"><?php echo $res['requirement']; ?></textarea>

		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">用人类别：</label>
		                    <div class="mws-form-item">
		                        <select class="large" name="type">
		                        	<?php if($res['type'] == 0): ?>
			                            <option value="0" selected="selected">单独用人</option>
			                            <option value="1">项目用人</option>
		                            <?php elseif($res['type'] == 1): ?>
			                            <option value="1" selected="selected">项目用人</option>
			                            <option value="0">单独用人</option>
		                            <?php endif; ?>
		                        </select>
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">任务标签：</label>
		                    <div class="mws-form-item">
		                        <input type="text" class="large" name="task_tags" value="<?php echo $res['task_tags']; ?>">
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">任务量预算：</label>
		                    <div class="mws-form-item">
		                        <input type="text" class="large" name="task_price" value="<?php echo $res['task_price']; ?>">
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">执行方式：</label>
		                    <div class="mws-form-item">
		                        <input type="text" class="large" name="method" value="<?php echo $res['method']; ?>">
		                    </div>
		                </div>
		                <div class="mws-form-row bordered">
		                    <label class="mws-form-label">任务类型：</label>
		                    <div class="mws-form-item">
		                        <input type="text" class="large" name="task_type" value="<?php echo $res['task_type']; ?>">
		                    </div>
		                </div>
			            <div class="mws-button-row">
			                <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
			                <input type="submit" value="提交" class="btn btn-danger">
			            </div>
			    	</div>
			    </form>
			</div>
		</div>
	</div>
</div>
        
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