<?php 
namespace app\admin\controller;
use think\View;
use app\admin\model\Common;
use think\Db;
use think\Paginator;
use think\Controller;
use think\Session;
use app\admin\controller\CommonsController;
use think\Request;

class WalletDetails extends CommonsController
{
	/**
	 * 交易明细列表
	 */
	public function index()
	{
		$db = new Common;

		$list = Db::table('wallet_details')
		->where('type','<>',1)
		->select();
		
		// dump($list);	
		return view('WalletDetails/index',['list'=>$list]);
	}

	public function accounts()
	{
		$list = Db::table('wallet_details')	
		->alias('a')
		->field('a.id,a.uid,a.transaction_account,a.balance,a.transaction_time,a.type,a.account_id,b.institution,b.name,b.num')
		->join('accounts b ','a.account_id = b.id') 
		// ->order('transaction_time desc')
		->select();
		// dump($list);
		return view('WalletDetails/accounts',['list'=>$list]);

	}

	//打款后确认
	public function pay(Request $request)
	{
		$id = $request->param('id');
		if($id){

			$res = Db::table('wallet_details')->where('id',$id)->update(['type'=>4]);

			if($res){
				session::flash('tis',1); 

            	return $this->redirect("/admin/WalletDetails/accounts"); 
			}else{
				session::flash('tis',2); 

            	return $this->redirect("/admin/WalletDetails/accounts"); 
			}
		}
	}
}