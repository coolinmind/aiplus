<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/userinfo/edit.html";i:1490854134;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/header.html";i:1492504794;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/footer.html";i:1490859504;}*/ ?>
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
        <div class="mws-panel grid_4" >
            <div class="mws-panel-header">
                <span>修改用户信息</span>
            </div>
            <div class="mws-panel-body no-padding">
                <form class="mws-form" action="/admin/userinfo/update" method="post" enctype="multipart/form-data">
                    <div class="mws-form-inline">
                       <div class="mws-form-row bordered">
                            <label class="mws-form-label">用户名：</label>
                            <div class="mws-form-item">
                                <!-- <input type="text" class="large" name="phone" value="<?php echo $data['phone']; ?>"> -->
                                <span><?php echo $data['phone']; ?></span>
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">昵称：</label>
                            <div class="mws-form-item">
                                <input type="text" class="large" name="nickname" value="<?php echo $data['nickname']; ?>">
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">真实姓名：</label>
                            <div class="mws-form-item">
                                <input type="text" class="large" name="realname" value="<?php echo $data['realname']; ?>">
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">性别：</label>
                            <div class="mws-form-item">
                                <select class="large" name="sex">
                                    <?php if($data['sex'] == 0): ?>
                                        <option value="0">女</option>
                                        <option value="1">男</option>
                                        <option value="2">保密</option>
                                    <?php elseif($data['sex'] == 1): ?>
                                        <option value="1">男</option>
                                        <option value="2">保密</option>
                                        <option value="0">女</option>
                                    <?php elseif($data['sex'] == 2): ?>
                                        <option value="2">保密</option>
                                        <option value="1">男</option>
                                        <option value="0">女</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">头像：</label>
                            <div class="mws-form-item">
                                <img src="<?php echo $data['icon']; ?>" width="100">
                                <input type="file" class="large" name="icon" >
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">实名认证：</label>
                            <div class="mws-form-item">
                                <select class="large" name="Verify">
                                    <?php if($data['Verify'] == 0): ?>
                                        <option value="0" selected="selected">未认证</option>
                                        <option value="1">已认证</option>
                                    <?php elseif($data['Verify'] == 1): ?>
                                        <option value="1" selected="selected">已认证</option>
                                        <option value="0">未认证</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">邮寄地址：</label>
                            <div class="mws-form-item">
                                <input type="text" class="large" name="address" value="<?php echo $data['address']; ?>">
                            </div>
                        </div>
                        <div class="mws-form-row bordered">
                            <label class="mws-form-label">就职状态：</label>
                            <div class="mws-form-item">
                                <select class="large" name="status">
                                    <?php if($data['status'] == 0): ?>
                                        <option value="0" selected="selected">在校</option>
                                        <option value="1">在职</option>
                                        <option value="2">自由职业</option>
                                        <option value="3">待业</option>
                                    <?php elseif($data['status'] == 1): ?>
                                        <option value="1" selected="selected">在职</option>
                                        <option value="2">自由职业</option>
                                        <option value="3">待业</option>
                                        <option value="0">在校</option>
                                    <?php elseif($data['status'] == 2): ?>
                                        <option value="2" selected="selected">自由职业</option>
                                        <option value="3">待业</option>
                                        <option value="0">在校</option>
                                        <option value="1">在职</option>
                                    <?php elseif($data['status'] == 3): ?>
                                        <option value="3" selected="selected">待业</option>
                                        <option value="0">在校</option>
                                        <option value="1">在职</option>                                       
                                        <option value="2">自由职业</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mws-button-row">
                            <input type="hidden" value="<?php echo $data['id']; ?>" name="id">
                            <input type="submit" value="提交" class="btn btn-danger">
                            <input type="reset" value="重置" class='btn'>
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