<?php
namespace module\admin;
use View,QI;
class cate extends \AdminControllers
{  
	public $table = 'cate';
 	function init(){
 		parent::init();
 		\View::$par['active'] = "cate";
 	}
 	 
	function indexAction(){
		$data = []; 
		$nid = (int)$_GET['nid'];
		if($nid>0){
			$data['data'] = QI::from($this->table)->where("id=?",$nid)->one(); 
		}else{
			$data = (array)QI::from($this->table)->page(['url'=>url('admin/cate/index'),'page'=>10000])?:[];
		}
		$data['op'] = $_GET['op'];
		if(is_ajax() && $_POST){
			$title = $_POST['title'];
			if(!$title ){
				goto error1;
			}
			$value['title'] = $_POST['title']; 
			$value['lang'] = $_POST['lang'];
			$value['status'] = 1;
			$value['sort'] = 1;
			$value['menu'] = $_POST['menu']?:0;		
			if($nid<1){
				$value['created'] = time();
			}else{
				$value['updated'] = time();
			}	
			if($nid < 1){
				$rt = QI::insert($this->table,$value);
				if($rt){
					exit(json_encode([
						'status'=>1,
						'data'=>"保存成功",
					]));
				}else{
					error1: 
					exit(json_encode([
						'status'=>0,
						'msg'=>["title"=>"保存失败"],
					]));
				}
			}else{
				$rt = QI::update($this->table,$value,'id=?',$nid);
				exit(json_encode([
						'status'=>1,
						'data'=>"保存成功",
					]));
			}
			
			exit;
		}
		return $this->make('cate',$data);
	} 
	
	function removeAction(){
		$nid = (int)$_GET['nid'];
		if($nid>0){
			$status = 1;
			$post = QI::from($this->table)->where("id=?",$nid)->one();
			if($post->status == 1){
				$status = 0;
			}
			\Session::flash("success",__('Action Success'));
			QI::update($this->table,['status'=>$status],'id=?',$nid);
		}
		redirect(url("admin/cate/index"));
	}
	
	
}
 

 