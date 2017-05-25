<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
use think\Db;
class Walletdetails
{
	public function get(Request $request)
	{
		//获取交易详情
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;

		$data = Db::table('wallet_details') -> where('uid',$uid) -> order('transaction_time desc') -> select();

		if($data)
		{
			foreach ($data as $k => $v) 
			{
				//查询提现账户
				$arr = Db::table('accounts') -> where('id',$v['account_id']) -> find();
				$data[$k]['name'] = $arr['type'];
			}
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	/**
	* 	@param  $data[$k]['total_account'] 全部收益
	* 	@param  $data[$k]['m'] 月份
	* 	@param  $data[$k]['account'] 每月收入
	**/
	//获取全部收益
	public function getAll(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];

		$data = Db::query("SELECT sum(transaction_account) account, MONTH(transaction_time) m FROM `wallet_details` WHERE `uid` = '{$id}' AND `type` = 3 GROUP BY m ORDER BY transaction_time DESC");

		$data = array_slice($data, 0,12);
		$num = count($data);
		
		//查询总收益及描述信息
		$totalAccount = Db::query("SELECT description , sum(transaction_account) total_account FROM `wallet_details` WHERE `uid` = '{$id}' AND `type` = 3");
		foreach ($data as $k => $v) 
		{
			$percent = ($v['account']/$totalAccount[0]['total_account'])*100;
			$percent = round($percent);
			$data[$k]['percent'] = $percent;
			$data[$k]['total_account'] = $totalAccount[0]['total_account'];//全部收益
			$data[$k]['num'] = $num;
			$v['m'] = $v['m'].'月';
			$data[$k]['m'] = $v['m'];
		}
		
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	//获取全部支出
	public function getAllpay(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];

		$data = Db::query("SELECT sum(transaction_account) account, MONTH(transaction_time) m FROM `wallet_details` WHERE `uid` = '{$id}' AND `type` = 2 GROUP BY m ORDER BY transaction_time DESC");

		$data = array_slice($data, 0,12);
		$num = count($data);
		
		//查询总支出及描述信息
		$totalAccount = Db::query("SELECT description , sum(transaction_account) total_account FROM `wallet_details` WHERE `uid` = '{$id}' AND `type` = 2");
		foreach ($data as $k => $v) 
		{
			$percent = ($v['account']/$totalAccount[0]['total_account'])*100;
			$percent = round($percent);
			$data[$k]['percent'] = $percent;
			$data[$k]['total_account'] = $totalAccount[0]['total_account'];//全部收益
			$data[$k]['num'] = $num;
			$v['m'] = $v['m'].'月';
			$data[$k]['m'] = $v['m'];
		}
		
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}
}