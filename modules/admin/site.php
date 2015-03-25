<?php
namespace module\admin;
use View,Auth,Session;
class site extends \AdminControllers
{  
 	function init(){
 		parent::init();
 		Auth::$save = 'Session'; 
 		 
 	}
 	function logoutAction(){
 		Session::delete(['id','name']);
 		Session::flash('success',__('Action Success'));
 		redirect(url('admin/site/login'));
 	}
	function loginAction(){
		if(is_ajax() && $_POST){
			$name = $_POST['name'];
			$pwd = $_POST['pwd'];
			$verify = $_POST['verify'];
			if(!$verify){
				exit(json_encode([
					'status'=>0,
					'msg'=>["pwd"=>"验证码不能为空"],
				]));
			}

			$v = new \Helper\Verify;
    		if(!$v->check($verify)){
    			exit(json_encode([
					'status'=>0,
					'msg'=>["pwd"=>"验证码错误"],
				]));
    		}

			$rt = Auth::login($name,$pwd);
			if($rt){
			//	$url = $this->get_refer()?:url('admin/post/index');
				$url = url('admin/post/index');
				exit(json_encode([
					'status'=>1,
					'data'=>"登录成功",
					'url'=>$url
				]));
			}else{
				exit(json_encode([
					'status'=>0,
					'msg'=>["pwd"=>"登录失败"],
				]));
			}
			exit;
		}
	 
		return $this->make('login');
	} 
	
	
	
}
 

 