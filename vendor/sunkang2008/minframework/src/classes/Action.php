<?php  
/**
*  默认控制器
*  　　
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/  
abstract class Action
{ 
	protected $id;
	protected $action;
	public $theme = 'default'; 
	protected $module; 
	/**
	* 无权限时跳转的URL
	*/
	public $loginUrl = "user/login/index";
	/**
	* 权限控制
	*　值可以为 当前的action也可以是完整的module.id.action或id.action
	*/
	public $access = [];
	/**
	* 可重新定义该函数,实现权限检测
	*/
	function _check(){
		return Auth::check();
	}
	
	function _access(){ 
		if(!$this->access) return true;
		foreach($this->access as $v){
			if($v=='*'){
				if(!$this->_check()){
					redirect(url($this->loginUrl));
				}
				goto End;
			}else{
				
				$arr = explode('.',$v);
				$i = count($arr);
				$module = $this->module;
				$id = $this->id;
				$action = $this->action; 
				switch($i){
					case 1:
						$check1 = $this->module.".".$this->id.".".$arr[0];
						if($arr[0]=="*"){
							$action = "*";
						} 
						break;
					case 2:
						$check1 = $this->module.".".$arr[0].".".$arr[1]; 
						if($arr[1]=="*"){
							$action = "*";
						}
						if($arr[0]=="*"){
							$id = "*";
						}
						break;
					case 3:
						$check1 = $arr[0].".".$arr[1].".".$arr[2];
						if($arr[2]=="*"){
							$action = "*";
						}
						if($arr[1]=="*"){
							$id = "*";
						}
						break;
				}
				
				$check = $module.".".$id.".".$action;   
				if($check == $check1 && !$this->_check() ){ 
					redirect(url($this->loginUrl)); 
				}
			}
			
		}
		End:
		return true;
		
	}
	/**
 	*　构造函数
 	*/
	function __construct(){ 
		 $arr = Route::controller();  
 		 $this->module = $arr['module'];
 		 $this->id = $arr['id'];   
 		 $this->action= $arr['action'];  
 	 	 $this->init(); 
 	 	 
 	}
 	/**
 	*　渲染视图
 	*/
 	protected function  view($view,$data = []){  
 		View::theme($this->theme);
 		$i = substr($view,0,1);
 		if($i=='/'){
 			$view = substr($view,1);
 		}else{
 			$view =  $this->module."/$view"; 
 		}
 		return View::make($view,$data);
 	}
 	/**
 	* 渲染视图
 	*/
 	protected function  make($view,$data = []){  
 		  return $this->view($view,$data);
 	}  
 	/**
 	* URL跳转
 	*/
	function jump($url){
		redirect($url);
	}
	/**
 	* 刷新当前页面
 	*/
	function ref(){
		refresh(); 
	}
	/**
 	* 初始化
 	*/
	function init(){
		$this->_access();
	}
 
}
