<?php  
/**
*  视图
*   
*  　　
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/  
/** 
*<code> 
*	
*在public/index.php 需要定义 
*define('WEB',__DIR__);
*define('BASE',realpath(__DIR__.'/../')); 
*
*
*View::cache(60);
* View 视图
* layout举例  文件名为default.layout.php
 *   
 *<?php echo $this->view['content'];?>
 *  
* View中使用
*
* <?php $this->layout('default');?>
*
*<?php echo $this->start('content');?>
*test
* <?php  $this->extend('payment');?>
*<?php echo $this->end();?> 
 *</code>
 */
class View
{  
	/**
	* 默认theme 
	*/
	static $theme = 'default'; 
 	protected $block;
	protected $block_id;   
	protected $theme_dir; 
	protected $view_dir;
	protected $view_file;
	protected $theme_file; 
	protected $view;
	/**
	* 仅是静态变量
	*/
	static $par = []; 
	static $obj;   
	/**
	* 是否合并HTML输出
	*/
	static $minify = false;
	protected $base_path;
	/**
	* 生成HTML静态文件的文件夹名
	*/
	static $htmlcache = "htmlcache";
	/**
	* theme最上层目录名
	*/
	static $theme_path = "themes";
	//页面缓存时间
	static $cache = false;
	/**
	* 设置值　
	* @param string $name  
	* @param string $value  　 
	* @return void 
	*/
	static function set($name,$value){
		static::$par[$name] = $value;
	}
	/**
	* 设置主题/取得当前主题名
	*/
	static function theme($name = null){ 
		if(!$name)
			return static::$theme;
		static::$theme = $name;
	}
 
	/**
	* 构造函数
	*/
	function __construct(){    
		$this->base_path = BASE;
		$this->view_dir = $this->base_path.'/views'; 
		$this->theme_dir = WEB.'/'.static::$theme_path.'/'.static::$theme;   
		 
	}  
 
	/**
	* 加载view 同级内容
	* @param string $name  
	* @param array $par  　 
	* @return void 
	*/
	function extend($name,$par = []){ 
		$name = str_replace('.','/',$name);
		$this->__ex($name); 
		$file = $this->find([$this->theme_file,$this->view_file]); 
		if(file_exists($file)){
			extract($par, EXTR_OVERWRITE); 
			include $file;
		}
	}
	
	/**
	*返回theme所在的url
	*/
	static function themeUrl(){
		return Route::init()->base_url.''.static::$theme_path.'/'.static::$theme;
	}
 
	/**
	* 内部函数,查找文件是否存在，存在后直接include 
	*@param array $arr
	*/
	protected function find($arr = []){
		foreach($arr as $file){
			if($file && file_exists($file))  
				return $file;
		} 
		throw new Exception("视图文件不存在:<br>".implode("<br>",$arr)); 
	}
	/**
	* 内部函数
	*@param string $name
	*/
	protected function __ex($name){ 
		$this->view_file = $this->view_dir.'/'.$name.'.php';  
 		if($this->theme_dir){
			$this->theme_file = $this->theme_dir.'/'.$name.'.php';
		} 
	}
	/**
	* 内部函数View缓存
	* @param string $time  
	* @return void 
	*/
	static function cache($time = NULL){
		if($time) static::$cache = $time;
		if(static::$cache===false) return;
 		$url = static::cacheHtml();
		if(file_exists($url)){
			if(static::$cache == null ||  static::$cache==0){
				echo file_get_contents($url);
				exit;
			}
 			$d = filemtime($url);
			if(static::$cache && $d+static::$cache >= time()){
				echo file_get_contents($url);
				exit;
			} 
 		} 
	}
	/**
	* 内部函数缓存HTML
	*/
	static function cacheHtml(){
		if(static::$cache===false) return;
 		$uri = $_SERVER['REQUEST_URI']; 
		$uri = str_replace("//",'/',$uri);
		$uri = str_replace(Route::host(),'',$uri); 
		if(!$uri||$uri=='/') $uri = "index";
		$url = WEB."/".static::$htmlcache."/".$uri.".html"; 
		$url = str_replace('//','/',$url); 
		$dir = File::dir($url); 
		if(!is_writable(File::dir($dir.".t"))){
			 throw new Exception("静态html目录不可写:".$dir);
		} 
		return $url;
	} 
  	/**
	* 渲染页面
	* @param string $name  
	* @param array $par  
	* @return void 
	*/
	static function make($name, $par = [])
	{ 
		if(is_object($par)) $par = (array)$par;
		$view = new Static; 
		$data = $view->render($name, $par);
 		if(static::$cache!==false && static::$cache >= 0){
			$url = static::cacheHtml();
			ob_start();
		  	echo $data;
		  	$data = trim(ob_get_contents());   
			ob_end_clean(); 
			$data = $data."\n<!--date:".date('Y-m-d H:i:s')."-->\n";
			file_put_contents($url,$data); 
		}
		return $data;
	}
	/**
	*	渲染视图同make
	*/
	function render($name, $par = [])
	{  
		if(static::$par) $par = $par+static::$par;
	 	$name = str_replace('.','/',$name);
		if(substr($name,0,1)=='/'){
			$this->view_dir = $this->view_dir;
			$this->theme_dir = $this->theme_dir;
			$name = substr($name,1);
		} 
		$this->__ex($name); 
		$this->block['content'] = $this->find([$this->theme_file,$this->view_file]);    
		ob_start();
		extract($par, EXTR_OVERWRITE); 
		include $this->block['content']; 
		if(file_exists($this->block['layout']) ){
  			include $this->block['layout'];   
  		}
		$data = trim(ob_get_contents());   
		ob_end_clean();
		if(true === static::$minify){
			$data =  preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[\t]*)+/s'),array(' ',''),$data);  
		} 
		if(static::$cache!== false && static::$cache >= 0){
			$url = static::cacheHtml();   
			file_put_contents($url,$data); 
		} 
		return $data;  
	} 
	 
	/**
	* 加载layout
	* @param string $name  
	* @param array $par  
	* @return void 
	*/
	function layout($name , $par = [] ){  
		$d = $name = str_replace('.','/',$name);   
		$view = $this->view_dir.'/'.$name.'.layout.php';
		$theme = $this->theme_dir.'/'.$name.'.layout.php';
		//上一层是否存在layout,目的是多个模块共用同一个theme下的laout
		$pre = substr($this->theme_dir,0,strrpos($this->theme_dir,'/')).'/'.$name.'.layout.php';
		//加载view下的layout
		$default_layout = $this->base_path.'/views/'.static::$theme.'/'.$d.'.layout.php';   
		if(strpos($name,'/')!==false){
			unset($pre,$default_layout);
		} 
		$this->block['layout'] = $this->find([$theme,$view,$pre,$default_layout]);
	}
	
	/**
	*打开 加载指定的 content
	*@param string $name
	*@param array $par
	*@return void
	*/

	function start($name , $par = []){
		$this->block_id = $name;  
		ob_start();
		ob_implicit_flush(false);  
		extract($par, EXTR_OVERWRITE); 
	}
	/**
	* 关闭 加载指定的 content
	*/
	function end(){   
		$this->view[$this->block_id] = ob_get_clean();
	} 
 
}
