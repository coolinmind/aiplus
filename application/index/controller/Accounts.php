<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Common;
class Accounts
{
	public function insert(Request $request)
	{
		date_default_timezone_set('PRC');
		$data = json_decode(input('DataJson'),true);
		$uid = json_decode(input('uid'),true)['id'];
		$mod = new Common;
		$id = rand_str();
		$data['uid'] = $uid;
		$data['id'] = $id;
		if(array_key_exists('account',$data))
		{
			$account = $data['account'];

			//查询钱包数据
			$wallet = $mod -> select('wallet',['uid' => $uid]);
			$walletId = $wallet[0]['id'];
			$data['wallet_id'] = $walletId;

			if($account < $wallet[0]['account'])
			{
				//添加错误日志
				$arr = [
					'id' => rand_str(),
					'error_id' => $uid,
					'add_time' => date('Y-m-d H:i:s'),
					'description' => '余额不足',
					'type' => '提现异常',
				];

				$mod -> insert('error_log',$arr);
				return json(['error' => false]);
			}else
			{
				$res = $mod -> insert('accounts',$data);
				if($res)
				{
					return json(['success' => true]);
				}else
				{
					return json(['error' => false]);
				}
			}
		}else
		{
			$res = $mod -> insert('accounts',$data);
			if($res)
			{
				return json(['success' => true,'id' => $id,'type' => $data['institution']]);
			}else
			{
				return json(['error' => false]);
			}
		}

		
	}

	public function get(Request $request)
	{
		$uid = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$data = $mod -> select('accounts',['uid' => $uid,'is_delete' => 0]);
		if($data)
		{
			return json($data);
		}else
		{
			return json(['error' => false]);
		}
	}

	public function update(Request $request)
	{
		$data = json_decode(input('DataJson'),true);
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;

		//查询原有数据
		$arr = $mod -> select('accounts',['id' => $id]);

		//修改原有数据删除状态
		$mod -> saves('accounts',['id' => $id],['is_delete' => 1]);

		//添加一条新数据
		$newId = rand_str();
		$arr[0]['id'] = $newId;
		$mod -> insert('accounts',$arr[0]);

		$res = $mod -> saves('accounts',['id' => $newId],$data);
		if($res)
		{
			return json(['success' => true]);
		}else
		{
			return json(['error' => false]);
		}
	}

	//查询单条数据
	public function find(Request $request)
	{
		$id = json_decode(input('id'),true)['id'];
		$mod = new Common;
		$arr = $mod -> select('accounts',['id' => $id]);
		if($arr)
		{
			return json($arr[0]);
		}else
		{
			return json(['error' => false]);
		}
	}
}