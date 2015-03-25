<?php 
abstract class Controllers extends Action
{  
	public $loginUrl = "user/sign/in";  
	public $refer = [];
	public $title;
	function init(){  
		$this->_refer();  
		if(!$this->access){
			$this->access  = Config::get('acl.default');
		}  
		parent::init();
	}
	function _check(){
		return Cookie::get('id');
	} 
	function get_refer(){
		return Cookie::get('refer');
	}
	protected function _refer(){
		$ref = $_SERVER['HTTP_REFERER'];
		if(!$ref) return;
		if($ref)
			$ref = str_replace(host(),"",$ref);
		$httpr = Config::get('app.refer')?:[];
		$rf = $httpr + $this->refer;
		if($rf){
			if(!in_array($ref,$rf)){
				Cookie::set('refer',$ref);
			}
		}
	}
}
abstract class FrontControllers extends Controllers
{ 
	function init(){   
		parent::init();
		$this->uid = Cookie::get('id');
		$this->name = Cookie::get('name');
		View::$par['site_title'] = Config::get('app.site_title')[$this->module.".".$this->id.".".$this->action]?:Config::get('app.site_title')['default'];
		View::$par['menu'] = Config::get('app.menu');
		View::$par['keywords'] = Config::get('seo.keywords');
		View::$par['description'] = Config::get('seo.description');
	}
}
abstract class AdminControllers extends Controllers
{  
	public $loginUrl = "admin/site/login";  
	public $uid;
	public $name;
	public $sid;
	function init(){  
		if(!$this->access){
			$this->access  = Config::get('acl.admin');
		} 
		parent::init();
		$this->uid = Session::get('id');
		$this->name = Session::get('name');
		$this->sid = \Config::get('admin.supuser')?:1;
		View::$par['site_title'] = Config::get('app.admin_site_title')[$this->module.".".$this->id.".".$this->action]?:Config::get('app.admin_site_title')['default'];
		View::$par['menu'] = Config::get('app.admin_menu');
		
	}
	function _check(){
		return Session::get('id');
	} 
	function admin(){ 
 		if($this->sid != $this->uid){
 			throw new \Exception(__('Access Deny'));
 		}
	}
}
  

 
 