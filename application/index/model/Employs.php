<?php 
namespace app\index\model;
use think\Db;
use think\Model;
// use app\admin\model\Common;
class Employs extends Model
{
	public function zuire($str1 ='',$str2 ='',$str3 ='',$str4 ='',$uid=''){
		$mod = new Common;
		if($str1 == '' && $str2 == '' && $str3 == ''){
							$res = Db::table('employ')
								->where('title','in',$str4)
								->order('review_times desc')
								->select();

							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

							return json($res);
					}

					if($str1 == '' && $str2 == '' && $str4 == ''){
							$res = Db::table('employ')
								->where('settlement_type','in',$str3)
								->order('review_times desc')
								->select();

							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

							return json($res);
					}

					if($str1 == '' && $str3 == '' && $str4 == ''){
							$res = Db::table('employ')
								->where('task_type','in',$str2)
								->order('review_times desc')
								->select();

							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

							return json($res);
					}

					if($str2 == '' && $str3 == '' && $str4 == ''){
							$res = Db::table('employ')
								->where('address','in',$str1)
								->order('review_times desc')
								->select();

							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

							return json($res);
					}


					if($str1 == '' && $str3 == '' ){
							$res = Db::table('employ')
								->where('task_type','in',$str2)
								->where('title','in',$str4)
								->order('review_times desc')
								->select();

							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

							return json($res);
					}

					if($str1 == '' && $str4 == '' ){
							$res = Db::table('employ')
								->where('task_type','in',$str2)
								->where('settlement_type','in',$str3)
								->order('review_times desc')
								->select();

							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

							return json($res);
					}

					if($str1 == '' && $str2 == '' ){
							$res = Db::table('employ')
								->where('title','in',$str4)
								->where('settlement_type','in',$str3)
								->order('review_times desc')
								->select();
							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

							return json($res);
					}

					if($str3 == '' && $str2 == '' ){
							$res = Db::table('employ')
								->where('address','in',$str1)
								->where('title','in',$str4)
								->order('review_times desc')
								->select();

							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}

						return json($res);
					}

					if($str4 == '' && $str2 == '' ){
							$res = Db::table('employ')
								->where('address','in',$str1)
								->where('settlement_type','in',$str3)
								->order('review_times desc')
								->select();
							foreach ($res as $k => $v) {

							if($uid == $v['employ_id']){

							 	unset($res[$k]);

							}

						foreach ($res as $keys => $val) {

							$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
							// dump($info);

							if($info){

								foreach ($info as $key => $value) {

									$res[$keys]['photo'] = $value['icon'];

									}

								}

							}
							
						}

						return json($res);

					}

					if($str3 == '' && $str4 == '' ){
							$res = Db::table('employ')
								->where('address','in',$str1)
								->where('task_type','in',$str2)
								->order('review_times desc')
								->select();
							// dump($res);exit;
							foreach ($res as $k => $v) {

								if($uid == $v['employ_id']){

								 	unset($res[$k]);

								}

							foreach ($res as $keys => $val) {

								$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
								// dump($info);

								if($info){

									foreach ($info as $key => $value) {

										$res[$keys]['photo'] = $value['icon'];

										}

									}

								}
								
							}
						// echo 1;
						return json($res);
					}

					if($str1 == ''){
						$res = Db::table('employ')
								->where('task_type','in',$str2)
								->where('settlement_type','in',$str3)
								->where('title','in',$str4)
								->order('review_times desc')
								->select();
						foreach ($res as $k => $v) {

							if($uid == $v['employ_id']){

							 	unset($res[$k]);

							}

						foreach ($res as $keys => $val) {

							$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
							// dump($info);

							if($info){

								foreach ($info as $key => $value) {

									$res[$keys]['photo'] = $value['icon'];

									}

								}

							}
							
						}

						return json($res);
					}	

					if($str2 == ''){
						$res = Db::table('employ')
								->where('address','in',$str1)
								->where('settlement_type','in',$str3)
								->where('title','in',$str4)
								->order('review_times desc')
								->select();
						foreach ($res as $k => $v) {

							if($uid == $v['employ_id']){

							 	unset($res[$k]);

							}

						foreach ($res as $keys => $val) {

							$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
							// dump($info);

							if($info){

								foreach ($info as $key => $value) {

									$res[$keys]['photo'] = $value['icon'];

									}

								}

							}
							
						}

						return json($res);
					}


					if($str3 == ''){
						$res = Db::table('employ')
								->where('address','in',$str1)
								->where('task_type','in',$str2)
								->where('title','in',$str4)
								->order('review_times desc')
								->select();

						foreach ($res as $k => $v) {

							if($uid == $v['employ_id']){

							 	unset($res[$k]);

							}

						foreach ($res as $keys => $val) {

							$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
							// dump($info);

							if($info){

								foreach ($info as $key => $value) {

									$res[$keys]['photo'] = $value['icon'];

									}

								}

							}
							
						}

						return json($res);
					}


					if($str4 == '' ){
						$res = Db::table('employ')
								->where('address','in',$str1)
								->where('task_type','in',$str2)
								->where('settlement_type','in',$str3)
								->order('review_times desc')
								->select();
						foreach ($res as $k => $v) {

							if($uid == $v['employ_id']){

							 	unset($res[$k]);

							}

						foreach ($res as $keys => $val) {

							$info = $mod::select('userinfo',array('uid'=>$val['employ_id']));
							// dump($info);

							if($info){

								foreach ($info as $key => $value) {

									$res[$keys]['photo'] = $value['icon'];

									}

								}

							}
							
						}

						return json($res);
					}

	}
}