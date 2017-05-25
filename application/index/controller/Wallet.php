<?php
namespace app\index\controller;
use think\Db;
use think\Request;
use app\index\model\Common;
class wallet
{
	//添加交易详情
	public function insert(Request $request)
	{
		date_default_timezone_set('PRC');
		$data = json_decode(input('DataJson'),true);
		$uid = json_decode(input('uid'),true)['id'];
		$type = $data['type'];
		$wallet = model('Wallet');

		//查询钱包数据
		$arr = $wallet -> where('uid',$uid) -> find();
		$account = $arr['account'];
		
		//判断金额增加还是减少
		if($type == 0 || $type == 3)
		{
			//准备钱包数据
			$newData = [
				'account' => $account + $data['transaction_account'],
			];

			$r = $wallet -> update($newData,['uid' => $uid]);

			//添加交易明细
			$mod = new Common;
			
			//准备交易明细数据
			$detailData = [
				'id' => rand_str(),
				'uid' => $uid,
				'transaction_account' => '+'.$data['transaction_account'],
				'balance' => $account + $data['transaction_account'],
				'transaction_time' => date('Y-m-d H:i:s'),
				'type' => $type,
				'description' => '充值',
			];

			if(array_key_exists('account_id',$data))
			{
				$detailData['account_id'] = $data['account_id'];
			}

			$res = $mod -> insert('wallet_details',$detailData);
		}else
		{

			if($account < $data['transaction_account'])
			{
				//添加错误日志
				//准备数据
				$errorData = [
					'id' => rand_str(),
					'add_time' => date('Y-m-d H:i:s'),
					'error_id' => $uid,
					'description' => '余额不足',
					'error_type' => '提现异常',
				];
				$mod -> insert('error_log',$data);

				return json(['error' => 'account_error']);exit;
			}

			//准备钱包数据
			$newData = [
				'account' => $account - $data['transaction_account'],
			];

			$r = $wallet -> update($newData,['uid' => $uid]);

			//添加交易明细
			$mod = new Common;

			//准备交易明细数据
			$detailData = [
				'id' => rand_str(),
				'uid' => $uid,
				'transaction_account' => '-'.$data['transaction_account'],
				'balance' => $account - $data['transaction_account'],
				'transaction_time' => date('Y-m-d H:i:s'),
				'type' => $type,
				'description' => '提现',
			];
			if(array_key_exists('account_id',$data))
			{
				$detailData['account_id'] = $data['account_id'];
			}
			$res = $mod -> insert('wallet_details',$detailData);
		}

		if($res && $r)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;

		//获取钱包数据
		$wallet = $mod -> select('wallet',['uid' => $uid]);
		if($wallet)
		{
			return json($wallet[0]);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function update(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$data = json_decode(input('DataJson'),true);

		//支付密码加密
		if(array_key_exists('PayPassword',$data))
		{
			$data['PayPassword'] = sha1($data['PayPassword']);
		}

		$mod = new Common;

		$res = $mod -> saves('wallet',['uid' => $uid],$data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//判断支付密码是否正确
	public function pay(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];//用户ID
		$data = json_decode(input('DataJson'),true);
		$mod = new Common;

		//查询用户钱包
		$arr = $mod -> select('wallet',['uid' => $id]);
		$password = $arr[0]['PayPassword'];
		
		$newPass = sha1($data['password']);
		if($newPass == $password)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}

	}

	//判断支付密码是否存在
	public function isExists(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;

		$data = $mod -> select('wallet',['uid' => $uid]);

		$pass = $data[0]['PayPassword'];
		if($pass)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}

	}
}