<?php  
/**
*  function
*   
*  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0 
*/   

define('SYS',realpath(__DIR__.'/../'));

function h($string){
	return htmlspecialchars($string);
}
function hh($string){
	return Helper\CleanHtml::run($string);
}
 
if(!function_exists('bootstrap')){
	error_reporting(E_ALL & ~(E_STRICT | E_NOTICE)); 
	//自动trim　$_GET $_POST  $_COOKIE 
	function bootstrap($function = "hh"){   
		$in = array(& $_GET, & $_POST, & $_COOKIE, & $_REQUEST);
	    while (list ($k, $v) = each($in))
	    {
	        foreach ($v as $key => $val)
	        {
	            if (! is_array($val))
	            {
	                $in[$k][$key] = $function(trim($val));
	                continue;
	            }
	            $in[] = & $in[$k][$key];
	        }
	    }
	    unset($in);
	} 
 
}	

if(!function_exists('get_ip')){
	/**
	* 取访问者IP
	*/
	function get_ip() {
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		   $ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	        $pos    =   array_search('unknown',$arr);
	        if(false !== $pos) unset($arr[$pos]);
	        $ip     =   trim($arr[0]);  
		}else{
		   $ip= $_SERVER['REMOTE_ADDR'];
		}
	    return $ip;
	}
}

/**************************************************************************/
/**
* 性能查看
*/
if(!function_exists('profile_start')){ 
	function profile_local(){
		$allowFile = BASE.'/profile.php';
		$allow = [];
		if(file_exists($allowFile)){
			$allow = include $allowFile;
		}
		$local = ["_local_a"=>"127.0.0.1","_local_b"=>"::1"];
		$allow = $local + $allow;
		if(!in_array(get_ip() ,$allow)){ 
			return false;
		} 
		return true;
	}
	function profile_start(){  
		if(!profile_local()){ 
			return;
		} 
		static $profile;
		if(!$profile){
			include(SYS.'/resource/pqp/classes/PhpQuickProfiler.php');
			include(SYS.'/resource/pqp/classes/Console.php');
			$config  = SYS.'/resource/pqp/';
			$profile = new \PhpQuickProfiler(\PhpQuickProfiler::getMicroTime(),$config);
		}
		return $profile;
	}
	
	function profile_end(){ 
		if(!profile_local()){ 
			return;
		} 
		$obj = profile_start();
		$obj->display();
	}
	
	
	function profile_logs($str) {
		if(!profile_local()){ 
			return;
		} 
		\Console::logSpeed($str); 
	}
	 function profile_log($str) {
	 	if(!profile_local()){ 
			return;
		} 
		\Console::log($str); 
	}
	function profile_logm($str) {
		if(!profile_local()){ 
			return;
		}
		\Console::logMemory($str); 
	}
	if(profile_local()){ 
		profile_start();
	} 
}	 
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );
if(!function_exists('is_ajax')){
	/**
	* 是否是AJAX请求
	*/
	function is_ajax(){
	    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}
}

if(!function_exists('refresh')){
	/**
	* 刷新
	*/
	function refresh(){
		header("Refresh:0");
	}
}
if(!function_exists('html_output')){
	/**
	* 输出Html中的link code
	*/
	function html_output(){
		$link = Html::link();
		echo implode("\n" , $link);
    	$link = Html::code();
    	echo implode("\n" , $link);
	}
}
if(!function_exists('widget')){
	/**
	* widget
	*/
	function widget($name,$par = []){ 
		$app = BASE.'/widgets/'.$name; 
		if(is_dir($app))
		  $widget = "widgets";
		if(!$widget){
		  $name = ucfirst($name); 
		  $core = SYS.'/widgets/'.$name;
		  if(is_dir($core))
		  	  $widget = "Widget";
		} 
		$classes = "\\".$widget."\\$name\\$name"; 
		if(!class_exists($classes)) return;
		$obj  = new $classes(); 
		if($par){
			foreach($par as $k=>$v)
				$obj->$k = $v;
		} 
		if(method_exists($obj,'init'))
			$obj->init();
		return $obj->run();   
	    	 
	}
}

if(!function_exists('url')){
	/**
	* 生成URL
	* @param string $url  
	* @param array $par  
	* @return string
	*/
	function url($url , $par = []){
		$url = str_replace('.','/',$url); 
		return Route::url($url,$par);
	}
}
 

if(!function_exists('host')){
	/**
	* 返回当前的域名地址
	*/	
	function host(){
		return Route::init()->host;
	}
}

if(!function_exists('base_url')){
	/**
	* 当前的相对路径　
	*/
	function base_url(){ 
		return Route::init()->base_url; 
	} 
}

if(!function_exists('__')){
	/**
	* 翻译
	* @param string $key  
	* @param string $alias  
	* @return string
	*/
	function __($key,$alias='app'){ 
		return Lang::get($key,$alias); 
	}  
}

if(!function_exists('redirect')){
	/**
	* 跳转
	* @param string $url   
	* @return void
	*/
	function redirect($url){
		header("location:$url"); 
		exit;
	} 
}

if(!function_exists('dump')){
	/**
	* 格式化输出
	*/
	function dump($str){
		print_r('<pre>');
		print_r($str);
		print_r('</pre>');
	} 
}   

 
 

if(!function_exists('import')){
	/**
	* 导入文件
	* @param string $file  
	* @return void
	*/
	function import($file){ 
		static $statics; 
		if(!isset($statics[$file])){
			include $file;
			$statics[$file] = true;
		} 
	}
}


profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );