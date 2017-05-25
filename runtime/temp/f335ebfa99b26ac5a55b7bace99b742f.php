<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/task_type/task_type.html";i:1492740438;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/header.html";i:1492588117;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/footer.html";i:1492573186;}*/ ?>
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
        
<!--图标样式-->
<link rel="stylesheet" type="text/css" href="/tree/css/bootstrap.min.css">

<!--主要样式-->
<link rel="stylesheet" type="text/css" href="/tree/css/style.css">

<script type="text/javascript" src="/tree/js/jquery-1.7.2.min.js"></script>
<!-- <script type="text/javascript" src="/tree/js/test.js"></script> -->
<div id="mws-container" class="clearfix">
    <div class="container">
        <div id="block" class="mws-panel grid_8">
            <div class="mws-panel-header">
                <span><i class="icon-table"></i>任务类型列表</span>
            </div>
            <div class="mws-panel-body no-padding">
                <form class="mws-form" action="form_layouts.html">
                    <?php if(\think\Session::get('tis') == 1): ?>
                        <div class="mws-form-message success">
                            操作成功 点击消失
                        </div>

                    <?php elseif(\think\Session::get('tis') == 2): ?>
                        <div class="mws-form-message error">
                            操作失败 点击消失
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            <div class="mws-panel-body no-padding">
                <div class="tree well">
    <form>
    <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px" style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF; text-align:center;">
        <tbody>
        <tr bgcolor="#F5F6FA" height="35px;" style="color:#333; font-size:16px; line-height:35px;">
            <td>分类</td>
            <td>排序</td>
            <td>操作</td>
        </tr>
        <?php foreach($list as $v): ?>
        <tr class="parent" bgcolor="#f1f1f1" height="48px" style="font-size:14px; color:#545454; text-align:left; line-height:48px;">
            <td style="padding-left:20px;"><?php echo $v['name']; ?></td>
            <td style="padding-left:70px;"><input name="orderby[1]" value="<?php echo $v['id']; ?>" type="text" class="remberinput w80"></td>
            <td style="text-align:center;">
                <a class="add" href="#" mini="load" class="remberBtn " w="600 " h="280 ">添加</a>                                    <a class="edit" href="#" mini="load" class="remberBtn " w="600 " h="280 ">编辑</a>                                    <a href="/admin/task_type/delete?id=<?php echo $v['id']; ?>" mini="act" class="remberBtn ">删除</a>                                </td>
        </tr>
        <?php foreach($v['son'] as $v): ?>
        <tr height="48px" style="font-size:14px; color:#545454; text-align:center; line-height:48px;">
                <td><?php echo $v['name']; ?></td>
                <td><input name="orderby[11]" value="<?php echo $v['id']; ?>" type="text" class="remberinput w80"></td>
                <td>                                        <a class="edit" href="#" mini="load" class="remberBtn " w="600 " h="280 ">编辑</a>                                        <a href="/admin/task_type/delete?id=<?php echo $v['id']; ?>" mini="act" class="remberBtn ">删除</a>                                    </td>
            </tr>
            <?php endforeach; endforeach; ?>
    </tbody>
    </table>
    </form>
</div>
            </div>
        </div>
<div id="none" class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>添加分类</span>
    </div>
    <div class="mws-panel-body no-padding">
        <form class="mws-form" action="/admin/task_type/insert" method="post">
            <div class="mws-form-inline">
                <div class="mws-form-row">
                    <label class="mws-form-label">分类名称</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" name="select">
                        <input id="pid" type="hidden" class="small" name="pid">
                    </div>
                </div>
            </div>
            <div class="mws-button-row">
                <input type="submit" value="提交" class="btn btn-danger">
                <input id="bak" type="reset" value="返回" class="btn ">
            </div>
        </form>
    </div>      
</div>
<div id="edit" class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>编辑分类</span>
    </div>
    <div class="mws-panel-body no-padding">
        <form class="mws-form" action="/admin/task_type/insert" method="post">
            <div class="mws-form-inline">
                <div class="mws-form-row">
                    <label class="mws-form-label">分类名称</label>
                    <div class="mws-form-item">
                        <input id="old" type="text" class="small" name="select">
                        <input id="id" type="text" class="small" name="pid">
                    </div>
                </div>
            </div>
            <div class="mws-button-row">
                <input type="submit" value="提交" class="btn btn-danger">
                <input id="editbak" type="reset" value="返回" class="btn ">
            </div>
        </form>
    </div>      
</div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#none').attr('style','display:none');
        $(".add").on('click',function(){
            var pid = $(this).parent().prev().children().val();
            $('#none').attr('style','display:block');
            $('#block').attr('style','display:none');
            $("#pid").val(pid);
        })
        $(".edit").on('click',function(){
            var id = $(this).parent().prev().children().val();
            var old = $(this).parent().prev().prev().html();
            $('#edit').attr('style','display:block');
            $('#block').attr('style','display:none');
            $("#id").val(id);
            $("#old").val(old);
        })
        $("#bak").on('click',function(){
            $('#none').attr('style','display:none');
            $('#block').attr('style','display:block');
        })
        $("#editbak").on('click',function(){
            $('#edit').attr('style','display:none');
            $('#block').attr('style','display:block');
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
