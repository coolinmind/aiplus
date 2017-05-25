<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/agreement/index.html";i:1492419869;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/header.html";i:1493201256;s:79:"/data/wwwroot/dev.happyoneplus.com/public/../application/admin/view/footer.html";i:1492573186;}*/ ?>
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
   <div class="mws-panel grid_8 mws-collapsible">
    	<div class="mws-panel-header">
        	<span><i class="icon-table"></i> 合同列表</span>
        <div class="mws-collapse-button mws-inset">
        <span></span>
        </div>
        </div>
        <div class="mws-panel-inner-wrap">
        <div class="mws-panel-body no-padding">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
            <div id="DataTables_Table_0_length" class="dataTables_length"></div>
            <table class="mws-table mws-datatable dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row">
                    <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 125px;">合同ID
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 172px;">合同名称
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 159px;">合同编号
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 105px;">发起时间
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 75px;">甲方姓名
                    </th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 75px;">乙方姓名
                    </th>
                    <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 126px;">
                    操作
                    </th>
                    </tr>
                </thead>
                
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): if( count($data)==0 ) : echo "" ;else: foreach($data as $key=>$vo): ?>
            <tr class="odd">
                <td class="  sorting_1"><?php echo $vo['id']; ?></td>
                <td class=" "><?php echo $vo['title']; ?></td>
                <td class=" "><?php echo $vo['num']; ?></td>
                <td class=" "><?php echo $vo['add_time']; ?></td>
                <td class=" "><?php echo $vo['first_party']; ?></td>
                <td class=" "><?php echo $vo['second_party']; ?></td>
                <td class=" ">
                    <span class="btn-group">
                        <a href="/admin/agreement/details?id=<?php echo $vo['id']; ?>" class="btn btn-small"><i class="icon-search"></i></a>
                        <a href="/admin/agreement/details/id/<?php echo $vo['id']; ?>" class="btn btn-small"><i class="icon-pencil"></i></a>
                        <a href="/admin/agreement/details/id/<?php echo $vo['id']; ?>" class="btn btn-small"><i class="icon-trash"></i></a>
                    </span>
                </td>
            </tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
            </table>
            </div>
        </div>
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