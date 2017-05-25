<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//字符串随机函数
function rand_str(){
    date_default_timezone_set('PRC');
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

/**
 * 随机字符
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string
 */
function random($length=24, $type='string', $convert=-1){

    $config = array(
        'number'=>'1234567890',
        'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );
    
    if(!isset($config[$type])) $type = 'string';
    $string = $config[$type];
    
    $code = '';
    $strlen = strlen($string) -1;
    for($i = 0; $i < $length; $i++){
        $code .= $string{mt_rand(0, $strlen)};
    }
    if(!empty($convert)){
        $code = ($convert > 0)? strtoupper($code) : strtolower($code);
    }
    return $code;
}

//随机订单号函数
function order_num()
{
	date_default_timezone_set('PRC');
	$date = date('Ymd');
	$data = '1234567890';
	$str = '';
	for($i = 0;$i < 14;$i ++)
	{
		$num = rand(0,9);
		$str .= $data[$num];
	}
	return $date.$str;
}


/**

 * 友好时间显示

 * @param $time

 * return bool|string

 */

function friend_date($time)
{
	date_default_timezone_set('PRC');
	if (!$time)
	return false;
    $fdate = '';
    $d = time() - intval($time);
    $day = 24*60*60; //一天的秒数
    $month = date('m') - date('m',$time); //相隔月数
    $year = date('Y') - date('Y',$time); //相隔年数
    $ddif = date('d') - date('d',$time);//相隔天数
    $H = date('H') - date('H',$time);//相隔小时数
    $i = date('i') - date('i',$time);//相隔分钟数
    $s = date('s') - date('s',$time);//相隔描述
   
    switch ($d) {

    	case $d < 10:
    			$fdate = '刚刚';
    		break;

        case $d < 60:
            	$fdate = $d . '秒前';
            break;

        case $d < 3600:
            	$fdate = floor($d / 60) . '分钟前';
            break;

        case $d < $day:
            	$fdate = floor($d / 3600) . '小时前';
            break;

        default:
            if($year < 1)
            {
               if($month < 1)
                {
                    $num = floor($d / $day);
                    $fdate = $num.'天前'; 
                }else if($month == 1)
                {
                    if($ddif < 1)
                    {
                        $num = floor($d / $day);
                        $fdate = $num.'天前'; 
                    }else
                    {
                        $fdate = $month.'月前';
                    }
                    
                }else
                {
                    $fdate = $month.'月前';
                }
            }else
            {
                $fdate = $year.'年前';
            }
            break;
    }

    return $fdate;
}

/**

 * 友好时间显示

 * @param $time

 * return bool|string

 */

function visitor_time($time)
{
    date_default_timezone_set('PRC');
    if (!$time)
    return false;
    $fdate = '';
    $d = time() - intval($time);
    $day = 24*60*60; //一天的秒数
    $month = date('m') - date('m',$time); //相隔月数
    $year = date('Y') - date('Y',$time); //相隔年数
    $ddif = date('d') - date('d',$time);//相隔天数
    $H = date('H') - date('H',$time);//相隔小时数
    $i = date('i') - date('i',$time);//相隔分钟数
    $s = date('s') - date('s',$time);//相隔描述
    switch ($d) {

        case $d < 10:
                $fdate = '刚刚';
            break;

        case $d < 60:
                $fdate = $d . '秒前';
            break;

        case $d < 3600:
                $fdate = floor($d / 60) . '分钟前';
            break;

        case $d < $day:
                $fdate = floor($d / 3600) . '小时前';
            break;

        default:
            if($year < 1)
                {
                   if($month < 1)
                    {
                        $num = floor($d / $day);
                        $fdate = $num.'天前'; 
                    }else if($month == 1)
                    {
                        if($ddif < 1)
                        {
                            $num = floor($d / $day);
                            $fdate = $num.'天前'; 
                        }else
                        {
                            $fdate = date('m'.'月'.'d'.'日',$time);
                        }
                        
                    }else
                    {
                        $fdate = date('m'.'月'.'d'.'日',$time);
                    }
                }else
                {
                    $fdate = date('Y'.'年'.'m'.'月'.'d'.'日',$time);
                }
            break;
    }

    return $fdate;
}

/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 */
function friendlyDate($sTime,$type = 'normal',$alt = 'false') {
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime        =    time();
    $dTime        =    $cTime - $sTime;
    $dDay        =    intval(date("z",$cTime)) - intval(date("z",$sTime));
    //$dDay        =    intval($dTime/3600/24);
    $dYear        =    intval(date("Y",$cTime)) - intval(date("Y",$sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if($type=='normal'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        //今天的数据.年份相同.日期相同.
        }elseif( $dYear==0 && $dDay == 0  ){
            //return intval($dTime/3600)."小时前";
            return '今天'.date('H:i',$sTime);
        }elseif($dYear==0){
            return date("m月d日 H:i",$sTime);
        }else{
            return date("Y-m-d H:i",$sTime);
        }
    }elseif($type=='mohu'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif( $dDay > 0 && $dDay<=7 ){
            return intval($dDay)."天前";
        }elseif( $dDay > 7 &&  $dDay <= 30 ){
            return intval($dDay/7) . '周前';
        }elseif( $dDay > 30 ){
            return intval($dDay/30) . '个月前';
        }
    //full: Y-m-d , H:i:s
    }elseif($type=='full'){
        return date("Y-m-d , H:i:s",$sTime);
    }elseif($type=='ymd'){
        return date("Y-m-d",$sTime);
    }else{
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif($dYear==0){
            return date("Y-m-d H:i:s",$sTime);
        }else{
            return date("Y-m-d H:i:s",$sTime);
        }
    }
}