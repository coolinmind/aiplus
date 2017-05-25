<?php
namespace app\home\controller;
use think\Request;
use think\Db;
use app\home\model\EmployModel;
use think\Session;
use think\Controller;
use think\View;
class Employ extends controller
{
	//首页遍历
	public function index()
	{
		$mod = new EmployModel;
		$data = $mod -> select();
		$city = Db::table('provinces') -> select();
		$cate = Db::table('cate') -> where('pid',0) -> select();

		return view('',['city' => $city,'cate' => $cate,'data' => $data]);
		
	}

	//条件查询
	public function condition(Request $request)
	{	
		$data = input();

		$address = [];
		if($data['city'] == '全国')
		{
			$address['address'] = ['like','%%'];
		}else
		{
			$address = ['address' => $data['city']];
		}

		$type = [];
		if($data['type'] == '不限' || $data['type'] == '')
		{
			$type['skill_type'] = ['like','%%'];
		}else
		{
			$type = ['skill_type' => $data['type']];
		}

		//判断是否有符合条件技能
		$r = Db::table('skill') -> where($address) -> where($type) -> find();
		if(!$r)
		{
			return false;exit;
		}

		//查询分页
		$res = Db::table('skill') -> where($address) -> where($type) -> paginate(1);

		foreach ($res as $k => $v) 
		{
			$info = Db::table('userinfo') -> where('uid',$v['uid']) -> find();
			$v['icon'] = $info['icon'];
			$res[$k] = $v;
		}
		
		$page = $res -> render();
		
		$str = '';
		foreach ($res as $k => $v) 
		{
			$str .= "<!-- 攻城狮信息 start -->
			  <div class="."engineer".">
			  <div class="."engineer-info no_underline".">
			    <a target="."_blank"." href="."/consultants/22693".">
			      <dl>
			        <dd>
			          <span class="."company-tag normal".">
			            <img src=".$v['icon'].">
			          </span>
			        </dd>
			        <dd class="."job".">
			          <i class="."icon-shixian-job"."></i>
			          <b>".$v['skill_name']."</b>
			        </dd>
			        
			        <dd class="."user-header".">
			          <img alt="."小虾"." itemprop="."image"." src=".""." />
			        </dd>

			        <dd class="."date".">
			          <i class="."icon-shixian-bag"."></i>
			          <b>10年</b>
			        </dd>
			      </dl>

			      <h5>擅长技能</h5>

			      <p class="."limit-line-5".">
			        {$v['skill_description']}
			      </p>
			</a>  </div>

			  <div class="."about".">
			    <h4>
			        <span>￥".$v['skill_price']."</span> / <i>8小时</i>
			    </h4>

			      <p>
			        <span>被预约次数</span>3
			      </p>

			    <p>
			      <span>可兼职时间</span>
			      周六、周日、工作日
			    </p>

			    <p>
			      <span>可兼职地点</span>
			      <b>海淀 所有区域</b>
			    </p>

			    
			    <!-- 剩下的这是 default 状态 -->
			    <a class="."just shixian-anim check-appointment-programmer"." id="."check-appointment_programmer_22693"." role="."button"." data-programmer-id="."22693"." href="."javascript:void(0);".">立即预约</a>

			  </div>
			</div>";
			$arr = ['page' => $page,'str' => $str];

			return json($arr);
			
		}
	}

	//添加 
	public function insert(Request $request)
	{
		$data = $request->post();
		//添加默认值
		$data['id'] = random();
		$data['is_delete'] = 0;
		$data['add_time'] = date('Y-m-d H:i:s',time());

		//实例化model 
		$Employ = new EmployModel;
		$Employ ->data($data);
		$res = $Employ->save();

		if($res){
			// 成功胡跳转页面
			return $this->redirect('login/index');

		}else{
			// 失败后跳转页面
			$this->error();
		}
		
	}

	//修改
	public function update()
	{

	}

	//删除
	public function delete()
	{
		
	}
}