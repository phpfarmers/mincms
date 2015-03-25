<?php
namespace module\admin;
use View,QI;
class field extends \AdminControllers
{  
	public $table = 'field';
	public $ext;
 	function init(){
 		parent::init();
 		$this->admin();
 		\View::$par['active'] = "field";
 		$name = "admin/field/";
 		$dir = WEB.View::themeUrl()."/".$name;
 		$list = scandir($dir);
 		foreach ($list as $v) {
 			if(substr($v,-4)=='.php'){
 				$go[substr($v,0,-4)] = $name.$v;
 			}
 		}
 		\View::$par['ext'] = $this->ext = $go;
 		
 	}
 	 
	function indexAction(){
		$data = []; 
		$nid = (int)$_GET['nid'];
		if($nid>0){
			$data['data'] = QI::from($this->table)->where("id=?",$nid)->one(); 
		}else{
			$data = (array)QI::from($this->table)->page(['url'=>url('admin/field/index'),'page'=>20])?:[];
		}
		$data['op'] = $_GET['op'];
		$c = QI::from("cate")->order_by("sort desc,id asc")->all();
		if($c){ 
			$data['cates'] = $c; 
			$data['incates'] = unserialize($post->cate); 
		} 

		if(is_ajax() && $_POST){
			if(!$_POST['label'] || !$_POST['name'] ){
				goto error1;
			}
			$value['label'] = $_POST['label']; 
			$value['name'] = $_POST['name'];
			$cate = $_POST['cate'];
			if($cate){
				$cate = serialize($cate);
			}
			$field = $_POST['field'];
			if($field){
				$field = serialize($field);
			} 
			$value['cate'] = $cate ;		
			$value['field'] = $field;		
			$ext = QI::from($this->table)->where("name=? and field=? and cate=?",[$_POST['name'],$field,$cate])->one();
			if($nid>0 && $ext->id != $nid){
				exit(json_encode([
						'status'=>0,
						'msg'=>["title"=>__('Exists Same Filed')],
					]));
			}elseif(!$nid&&$ext){
				exit(json_encode([
						'status'=>0,
						'msg'=>["title"=>__('Exists Same Filed')],
					]));
			}

			
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
						'data'=>__('Action Success'),
					]));
				}else{
					error1: 
					exit(json_encode([
						'status'=>0,
						'msg'=>["title"=>__('Failed')],
					]));
				}
			}else{
				$rt = QI::update($this->table,$value,'id=?',$nid);
				exit(json_encode([
						'status'=>1,
						'data'=>__('Action Success'),
					]));
			}
			
			exit;
		}
		return $this->make('field',$data);
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
		redirect(url("admin/field/index"));
	}
	
	
}
 

 