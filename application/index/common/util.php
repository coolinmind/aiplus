<?php
// 随机字符串函数
function st(){
	$time = time();
	$time = substr($time,4);
	$data = md5($time);
	$str = '';
	for($i=0;$i<18;$i++){
		$num = rand(0,31);
		$str .= $data[$num];
	}
	return $time.$str;
}