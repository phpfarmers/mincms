<?php
namespace module\admin;
use View,QI;
class user extends \AdminControllers
{  
	public $table = 'user';
	
 	function init(){
 		parent::init();
 		$nid = (int)$_GET['nid']; 
 		\View::$par['supuser'] = $this->sid;
 		\View::$par['uid'] = $this->uid;
 		\View::$par['nid'] = $nid; 
 		\View::$par['active'] = "user";
 	}
 	 
	function indexAction(){
		$data = []; 
		$nid = (int)$_GET['nid'];
		
		if($nid>0){
			$data['data'] = QI::from($this->table)->where("id=?",$nid)->one(); 
		}else{
			$data = (array)QI::from($this->table)->page(['url'=>url('admin/user/index'),'page'=>100])?:[];
		}
		$data['op'] = $_GET['op'];
		if(is_ajax() && $_POST){
			$title = $_POST['name'];
			$pwd = $_POST['pwd'];
			$pwd_new = $_POST['pwd_new'];
			if(!$title || !$pwd){
				exit(json_encode([
					'status'=>0,
					'msg'=>["title"=>__("Failed")],
				]));
			} 
			if($nid>0){
				if($this->uid == $this->sid && !$pwd){
					$r = Auth::change_password_on($title,$pwd);  
				}else{
					if(!$pwd && !$pwd_new){
 			    		$r = Auth::change_password($title,$pwd,$pwd_new);
 			    	}
 			    }
 			    goto end;
			}else{
		    	$r = Auth::create($title,$pwd);
		    }
		    if(!$r){
		    	exit(json_encode([
					'status'=>0,
					'msg'=>["title"=>__("User Exists")],
				]));
		    }
			\Session::flash("success",__('Action Success'));		
			end:
			exit(json_encode([
					'status'=>1,
					'data'=>__('Action Success'),
				])); 
		}
		return $this->make('user',$data);
	} 
	  
	
}
 

 