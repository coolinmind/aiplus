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

class Category extends CommonsController
{
	/**
	 * 待审核列表 category_review
	 * 
	 */
	public function category_review()
	{	
		$db = new Common;

		$res = $db::select('category_review');

		// dump($res[0]);
		return view('/category/category_review',['res'=>$res]);
	}

	/**
	 *  提交待审数据到category表
	 */
	public function submit(Request $request)
	{
		$ids = $request->param('id');

		if(!$ids){

			session::flash('tis',2); 

            return $this->redirect("/admin/category_review/list"); 
		}

		$db = new Common;

		$res = $db::select('category_review',array('id'=>$ids));
		// dump($res);
		if($res[0]['type'] == 0){

			$sql = $db::select('category');

			foreach ($sql as $k => $v) {
				// dump($v['general']);
				if($v['general'] == ''){
					// echo $k;
						$name = $res[0]['name'];

						$data = [
							'general'=>$name,
						];
						
						$info = $db::saves('category',array('id'=>$k+1),$data);

						if($info){
							
							$del = $db::del('category_review',array('id'=>$ids));

							if($del){

								session::flash('tis',1); 

			            		return $this->redirect("/admin/category_review/list"); 

							}else{

								session::flash('tis',2); 

			            		return $this->redirect("/admin/category_review/list"); 
							}

						}else{

							session::flash('tis',2); 

			            	return $this->redirect("/admin/category_review/list"); 

						}
					}	
				}

				$name = $res[0]['name'];

				$data = [
					'general'=>$name,
				];
				
				$info = $db::insert('category',$data);

				if($info){
					
					$del = $db::del('category_review',array('id'=>$ids));

					if($del){

						session::flash('tis',1); 

	            		return $this->redirect("/admin/category_review/list"); 

					}else{

						session::flash('tis',2); 

	            		return $this->redirect("/admin/category_review/list"); 
					}

				}else{

					session::flash('tis',2); 

	            	return $this->redirect("/admin/category_review/list"); 

				}

		}elseif($res[0]['type'] == 1){

			$sql = $db::select('category');

			foreach ($sql as $k => $v) {
				// dump($v['general']);
				if($v['experience'] == ''){

						$name = $res[0]['name'];

						$data = [
							'experience'=>$name,
						];
						
						$info = $db::saves('category',array('id'=>$k+1),$data);

						if($info){
							
							$del = $db::del('category_review',array('id'=>$ids));

							if($del){

								session::flash('tis',1); 

			            		return $this->redirect("/admin/category_review/list"); 

							}else{

								session::flash('tis',2); 

			            		return $this->redirect("/admin/category_review/list"); 
							}

						}else{

							session::flash('tis',2); 

			            	return $this->redirect("/admin/category_review/list"); 

						}
					}
				}

				$name = $res[0]['name'];

				$data = [
					'experience'=>$name,
				];
				
				$info = $db::insert('category',$data);

				if($info){
					
					$del = $db::del('category_review',array('id'=>$ids));

					if($del){

						session::flash('tis',1); 

	            		return $this->redirect("/admin/category_review/list"); 

					}else{

						session::flash('tis',2); 

	            		return $this->redirect("/admin/category_review/list"); 
					}

				}else{

					session::flash('tis',2); 

	            	return $this->redirect("/admin/category_review/list"); 

				}
				
			

		}elseif($res[0]['type'] == 2){

			$sql = $db::select('category');

			foreach ($sql as $k => $v) {
				// dump($v['general']);
				if($v['certificate'] == ''){

						$name = $res[0]['name'];

						$data = [
							'certificate'=>$name,
						];
						
						$info = $db::saves('category',array('id'=>$k+1),$data);

						if($info){
							
							$del = $db::del('category_review',array('id'=>$ids));

							if($del){

								session::flash('tis',1); 

			            		return $this->redirect("/admin/category_review/list"); 

							}else{

								session::flash('tis',2); 

			            		return $this->redirect("/admin/category_review/list"); 
							}

						}else{

							session::flash('tis',2); 

			            	return $this->redirect("/admin/category_review/list"); 

						}
					}
				}

				$name = $res[0]['name'];

				$data = [
					'certificate'=>$name,
				];
				
				$info = $db::insert('category',$data);

				if($info){
					
					$del = $db::del('category_review',array('id'=>$ids));

					if($del){

						session::flash('tis',1); 

	            		return $this->redirect("/admin/category_review/list"); 

					}else{

						session::flash('tis',2); 

	            		return $this->redirect("/admin/category_review/list"); 
					}

				}else{

					session::flash('tis',2); 

	            	return $this->redirect("/admin/category_review/list"); 

				}
			}
	}

	/**
	 * 技能类型列表展示
	 */
	public function category()
	{
		$db = new Common;

		$list = $db::select('category');

		return view('/category/category',['list'=>$list]);

	}

	/**
	 * 技能类型修改页面
	 */
	public function edit(Request $request)
	{
		$id = $request->param('id');

		if(!$id){

			session::flash('tis',2); 

            return $this->redirect("/admin/category/list"); 

		}

		$db = new Common;

		$content = $db::select('category',array('id'=>$id));

		if($content){

			return view('/category/edit',['data'=>$content[0]]);

		}
	}

	/**
	 * 技能类型数据修改
	 */
	public function update(Request $request)
	{
		$content = $request->param();

		if(!$content){

			session::flash('tis',2); 

            return $this->redirect("/admin/category/list");

		}

		$db = new Common;

		$data = [
			'general'=>$content['general'],
			'experience'=>$content['experience'],
			'certificate'=>$content['certificate']
		];

		$res = $db::saves('category',array('id'=>$content['id']),$data);

		if($res){

			session::flash('tis',1); 

        	return $this->redirect("/admin/category/list"); 

		}else{

			session::flash('tis',2); 

        	return $this->redirect("/admin/category/list"); 
		}
	}

	public function check(Request $request)
	{
		$data = $request->param();
		if(!$data['id']){
			session::flash('tis',2); 

            return $this->redirect("/admin/category_review/list");
		}
		$id = $data['id'];
	}
}