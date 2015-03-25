<?php
namespace module\admin;
use View,QI;
class post extends \AdminControllers
{  
	public $table = 'post';
	public $post;
	public $full;
 	function init(){
 		parent::init();
 		\View::$par['active'] = "post"; 
 		$nid = (int)$_GET['nid'];
		if($nid>0){
 			$this->post = QI::from($this->table)->where("id=?",$nid)->one();
			$this->full = unserialize($post->full);
		}
 	}
 	function ajaxAction(){
 		$in = $_POST['cate'];
 		if($in){
 			$in = explode(',', $in);
	 		$field = QI::from("field")->where('cate in ('.QI::in($in).')',$in)->all(); 
	 	}else{
	 	//	$field = QI::from("field")->where('cate ?'," IS NULL")->all(); 
	 	}
	 	if(!$field){
	 		return;
	 	}
 		$dir = WEB.View::themeUrl();

	 	foreach ($field as $v) {
	 		$label = $v->label;
	 		$name = $v->name;
	 		$f = unserialize($v->field);
	 		$file = $f['name']; 
	 		$value = null;
	 		if($file){
		 		$include = $dir."/".$file;
		 		$a =  include $include;
		 		$content .= $a;
		 	}
	 	}
	 	echo $content;
	 	exit;
 	}
	function indexAction(){
		$data = [];
		$nid = (int)$_GET['nid'];
		if($nid>0){
			$data['data'] = $post = $this->post;
			$full = $this->full;
			if($full){
				foreach($full as $k=>$v){
					$data['data']->$k = $v;
				}
			} 
		}else{
			$data = (array)QI::from($this->table)->page(['url'=>url('admin/post/index'),'page'=>10,"order_by"=>"id desc"])?:[];
		}
		$data['op'] = $_GET['op'];
		$c = QI::from("cate")->order_by("sort desc,id asc")->all();
		if($c){ 
			$data['cates'] = $c; 
			$data['incates'] = unserialize($post->cate); 
		} 
		if(is_ajax() && $_POST){
			$title = $_POST['title'];
			$body = $_POST['body'];
			if(!$title || !$body){
				goto error1;
			}
			$value['title'] = $_POST['title'];
			$value['body'] = $_POST['body'];
			$value['lang'] = $_POST['lang'];
			$value['teater'] = $_POST['teater']; 
			$cate = $_POST['cate'];
			if($cate){
				$cate = serialize($cate);
			} 
			$image = $_POST['image'];
			if($image){
				$full['image'] = $image;
			}
			$file = $_POST['file'];
			if($file){
				$full['file'] = $file;
			}
			if($full){
				$full = serialize($full);
			}
			$value['cate'] = $cate;
			if($nid<1){
				$value['created'] = time();
			}else{
				$value['updated'] = time();
			}
			$value['status'] = 1;
			$value['full'] = $full;			
			$value['uid'] = $this->uid;
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
	 
		return $this->make('post',$data);
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
		redirect(url("admin/post/index"));
	}
	
	
}
 

 