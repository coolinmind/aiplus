<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:84:"/data/wwwroot/dev.happyoneplus.com/public/../application/index/view/index/index.html";i:1492998898;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0, minimum-scale=1.0, user-scalable=0, initial-scale=1.0, width=device-width"/>
    <meta name="format-detection" content="telephone=no, email=no, date=no, address=no">
    <title>Hello APP</title>

	<style>
		#con{
			margin: 10px;
			font-size: 24px; 
		}
		ul{
			margin-bottom: 10px;
		}
		ul li{ 
			margin: 5px 10px;
			padding: 5px;
			color: #000;
			word-wrap: break-word;
		}
	</style>
</head>
<body>
	<center>
		<div>
			<div>
			<ul>
			<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?>
			    <li> <?php echo $user['name']; ?></li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			</div>
			<?php echo $list->render(); ?>
			
		</div>
	</center>
</body>