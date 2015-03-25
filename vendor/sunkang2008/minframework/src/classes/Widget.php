<?php  
/**
*  Widget挂件
*  
*  　　
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
/** 
*	　
* 	
*<code>
* widget\Ckeditor\Ckeditor.php
*
* <?php namespace Widget\Ckeditor;
*			use Form,Html;
*			use Widget;
*			class Ckeditor extends Widget{ 
*			 
*			 	function run(){
*					$this->publish( __DIR__.'/xheditor');
*				//	echo $this->url;exit;
*					$s = Form::text($this->name);
*					Html::code("$('#".$this->name."').xheditor();");
*				 	Html::link('a.js?');
*				 	Html::link('aa.js');
*			 	 	return $s;
*				}
*
*}
*
*</code>
*/
class Widget
{ 
 	//要发布到的目录
	static $to;
	//相对URL
	public $base;
	static $_url; 
	public $r;
	public $url;
	static $view  = "views";
	/**
	*  构造函数
	*/
	function __construct($to=null,$url=null,$named=null){ 
		if($to) static::$to  = $to;
		if($to) static::$_url  = $url;
		if($to) static::$named  = $named;
		if(!isset(static::$to))
			static::$to = WEB.'/assets'; 
		if(!isset(static::$_url))
			static::$_url = 'assets'; 
		if(!is_writable(static::$to)){
			 throw new Exception("widget文件目录不可写:".static::$to);
		 } 
	}
	 
	/**
	* 发布资源到指定目录 
	*
	* @param array $dir 　 
	* @return string
	*/
    function publish($dir = null){
    	$r = new ReflectionClass($this);	
    	//当前使用的widget name
    	$widget_name = $r->name; 
    	$widget_name =  substr($widget_name,strrpos($widget_name, '\\')+1 ) ; 
      	File::cpdir($dir,static::$to ,$widget_name ); 
     	$this->url = Route::init()->base_url.static::$_url.'/'.$widget_name.'/'; 
     	return $this->url;
    }

    /**
	* 渲染视图 
	*
	* @param string $view 　 
	* @param array $par 　 
	* @return void
	*/
    function view($view,$par = []){
    	$r = new ReflectionClass($this);
    	$n = str_replace('\\','/',$r->name);
    	$n = substr($n,0,strrpos($n,'/'));   
		$n = BASE.'/'.$n;
		$file = $n."/".static::$view."/$view.php";   
    	if(file_exists($file)){
			extract($par, EXTR_OVERWRITE); 
			include $file;
		} 
    } 
  
   
   
}
