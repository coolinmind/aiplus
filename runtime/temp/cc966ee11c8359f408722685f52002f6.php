<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/menu/menu.html";i:1493000237;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/header.html";i:1493201256;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/footer.html";i:1492573186;}*/ ?>
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
        
        <div id="mws-container" class="clearfix">
            <div class="container">

                <div class="mws-panel grid_8 mws-collapsible" style="position:relative">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>菜单管理</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <form class="mws-form" action="form_layouts.html">
                            <?php if(\think\Session::get('tishi') == 1): ?>
                                <div class="mws-form-message success">
                                    操作成功 点击消失
                                </div>

                            <?php elseif(\think\Session::get('tishi') == 2): ?>
                                <div class="mws-form-message error">
                                    操作失败 点击消失
                                </div>
                            <?php elseif(\think\Session::get('tishi') == 3): ?>
                                <div class="mws-form-message error">
                                    该菜单下还有其他子菜单！
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="mws-panel-body no-padding">

                        <table class="mws-table mws-datatable" >
                            <thead>
                                <tr>
                                    <td><input type="button" id="mws-jui-dialog-mdl-btn" class="btn btn-primary bkform" id='bkform' value="  添加一级菜单  "></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>分  类：</th>
                                    <th>操  作：</th>                               
                                </tr>
                            </thead>
                            <tbody align='center'>
                               <?php if(is_array($res) || $res instanceof \think\Collection || $res instanceof \think\Paginator): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v['parent_id'] == 0 and $v['is_show'] == 1): ?>
                                    <tr>
                                        <td style="background: #eee;"><?php echo $v['menu_name']; ?></td> 
                                        <td style="background: #eee;">
                                            <span class="btn-group">
                                                <a class="btn btn-small samll" is="<?php echo $v['id']; ?>"><i class='icon-plus-sign'></i></a>
                                                <a class="btn btn-small btns" i="<?php echo $v['id']; ?>"><i class="icon-pencil"></i></a>
                                                <a class="btn btn-small" href='/admin/menu/set?id=<?php echo $v['id']; ?>'><i class='icon-cog'></i></a>
                                                <a href="/admin/menu/delete?menu_id=<?php echo $v['id']; ?>" onclick="return confirm('确定要删除么?');" class="btn btn-small"><i class="icon-trash"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                     <?php if(is_array($res) || $res instanceof \think\Collection || $res instanceof \think\Paginator): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;if($v1['is_show'] == 1): if($v1['parent_id'] == $v['id']): ?>
                                                <tr>
                                                    <td style="background: #FFF;">|——<?php echo $v1['menu_name']; ?></td>
                                                    <td style="background: #FFF;">
                                                    <span class="btn-group">
                                                        <a class="btn btn-small btns1" is='<?php echo $v1['id']; ?>' path='<?php echo $v1['menu_path']; ?>' names='<?php echo $v1['menu_name']; ?>' ><i class="icon-pencil"></i></a>
                                                        <a href="/admin/menu/delete?menu_id=<?php echo $v1['id']; ?>" onclick="return confirm('确定要删除么?');" class="btn btn-small"><i class="icon-trash"></i></a>
                                                </span>
                                            </td>
                                                </tr>
                                            <?php endif; endif; endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>  
                <div id="zhezhao"></div>
                <div class="mws-panel grid_4" id='dis' style="display: none;position:absolute;left:260px;top:130px">
                    <div class="mws-panel-header">
                        <span>菜单添加</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <form class="mws-form" action="/admin/menu/insert" method="post">
                            <div class="mws-form-inline">
                                <div class="mws-form-row bordered">
                                    <label class="mws-form-label">一级菜单：</label>
                                    <div class="mws-form-item">
                                        <select class="large" name='id'>
                                                    <option >一级菜单</option>
                                            <?php if(is_array($res) || $res instanceof \think\Collection || $res instanceof \think\Paginator): $i = 0; $__LIST__ = $res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v['parent_id'] == 0): ?>
                                                    <option value="$v.id"><?php echo $v['menu_name']; ?></option>
                                                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </div>
                                </div>
                               <div class="mws-form-row bordered">
                                    <label class="mws-form-label">添加菜单：</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="large" name='menu_name'>
                                    </div>
                                </div>
                                <div class="mws-button-row">
                                <input type="submit" value="提交" class="btn btn-danger">
                                <a href=""><input type="button" value="取消" class="btn " id='ol'></a>
                                </div>
                            </div>
                        </form>
                    </div>      
                </div>  
                <div class="mws-panel grid_4" id='divs1' style="display: none;position:absolute;left:260px;">
                    <div class="mws-panel-header">
                        <span>二级菜单添加</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <form class="mws-form" action="/admin/menu/insert" method="post">
                            <div class="mws-form-inline">
                               <div class="mws-form-row bordered">
                                    <label class="mws-form-label">添加二菜单：</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="large" name='menu_name'>
                                    </div>
                                </div>
                            <div class="mws-button-row">
                                <input type="hidden" value='' name='id' id='mids'>
                                <input type="submit" value="提交" class="btn btn-danger">
                                <a href=""><input type="button" value="取消" class="btn " id='ol'></a>
                            </div>
                            </div>
                        </form>
                    </div>      
                </div>    
                <div class="mws-panel grid_4" id='divs' class="test" style="display: none;position:absolute;left:260px;">
                    <div class="mws-panel-header">
                        <span>菜单名称修改</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <form class="mws-form" action="/admin/menu/edit" method="post">
                            <div class="mws-form-inline">
                               <div class="mws-form-row bordered">
                                    <label class="mws-form-label">修改名称：</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="large" name='menu_name'>
                                    </div>
                                </div>
                            <div class="mws-button-row">
                                <input type="hidden" value='' name='id' id='mid'>
                                <input type="submit" value="提交" class="btn btn-danger">
                                <a href=""><input type="button" value="取消" class="btn " id='oli'></a>
                            </div>
                            </div>
                        </form>
                    </div>      
                </div> 
                <div class="mws-panel grid_4" id='div1' class="test" style="display: none;position:absolute;left:260px;top:240px">
                    <div class="mws-panel-header">
                        <span>添加及修改</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <form class="mws-form" action="/admin/menu/pathedit" method="post">
                            <div class="mws-form-inline">
                               <div class="mws-form-row bordered">
                                    <label class="mws-form-label">修改名称：</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="large" name='menu_name' id='names'>
                                    </div>
                                </div>
                                <div class="mws-form-row bordered">
                                    <label class="mws-form-label">添加路径：</label>
                                    <div class="mws-form-item">
                                        <input type="text" class="large" name='menu_path' id='path'>
                                    </div>
                                </div>
                                <div class="mws-button-row">
                                    <input type="hidden" value='' name='id' id='mid1'>
                                    <input type="submit" value="提交" class="btn btn-danger">
                                    <a href=""><input type="button" value="取消" class="btn " id='oli1'></a>
                                </div>
                            </div>
                        </form>
                    </div>      
                </div> 
            </div>  
        </div>   

<script src="/Backstage/js/libs/jquery-1.8.3.min.js"></script>    
<script>
$('.bkform').click(function(){
    // $('#mws-container').css({'left': '0px','top': '0px','background':'#000','z-index': '9999','opacity': '0.7'});

    $("#dis").css({'display':'block','z-index': '9999'}); 
    $('#zhezhao').css({'width':'1200px','height':'1290px','background': 'rgb(0, 0, 0)','opacity': '0.7','z-index': '1','position':'absolute','left':'-48px','top':'-8px'});
})

$('#ol').click(function(){
    $("#dis").css({'display':'none'}); 
    $('#zhezhao').css({'display':'none'});

})


$('.samll').click(function(){
   
    var id =  $(this).attr('is');

    $('#mids').val(id);

    $("#divs1").css({'display':'block','z-index':'9999'}); 

    $("#divs1").css("top", $(document).scrollTop()+150 );
    
    $('#zhezhao').css({'width':'1200px','height':'1290px','background': 'rgb(0, 0, 0)','opacity': '0.7','z-index': '1','position':'absolute','left':'-48px','top':'-8px'});

  
})

$('#ol').click(function(){
    $("#divs1").css({'display':'none'}); 

})


$('.btns').click(function(){

    var id =  $(this).attr('i');

    $('#mid').val(id);

    $("#divs").css({'display':'block','z-index':'9999'}); 


    $("#divs").css("top", $(document).scrollTop()+150 );

    $('#zhezhao').css({'width':'1200px','height':'1290px','background': 'rgb(0, 0, 0)','opacity': '0.7','z-index': '1','position':'absolute','left':'-48px','top':'-8px'});

})


$('#oli').click(function(){

    $("#divs").css({'display':'none'}); 

})

$('.btns1').click(function(){

    var id =  $(this).attr('is');

    var name = $(this).attr('names');

    var path = $(this).attr('path');

    $('#mid1').val(id);

    $('#names').val(name);

    $('#path').val(path);

    $("#div1").css("top", $(document).scrollTop()+150 );

    $("#div1").css({'display':'block','z-index':'9999'}); 

    $('#zhezhao').css({'width':'1200px','height':'1290px','background': 'rgb(0, 0, 0)','opacity': '0.7','z-index': '1','position':'absolute','left':'-48px','top':'-8px'});


})

$('#oli1').click(function(){

    $("#div1").css({'display':'none'}); 


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