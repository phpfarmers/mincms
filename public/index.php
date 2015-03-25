<?php  
header("Content-type: text/html; charset=utf-8");
$time_start = microtime(true);
define('WEB',__DIR__);
define('BASE',realpath(__DIR__.'/../'));  
require  __DIR__.'/../autoload.php';   
ini_set('display_errors',1);
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE)); 
date_default_timezone_set('Asia/Shanghai'); 
include __DIR__."/../routes.php"; 
try {  
	$view = Route::run();  
	if($view){
		echo $view; 
	}
}catch (Exception $e) { 
	View::$par['site_title'] = Config::get('app.site_title')['default'];
	View::$par['menu'] = Config::get('app.menu');
	if(in_array(get_ip(),['127.0.0.1','::1'])){  
		echo View::make('error',['message'=>$e->__toString()]);
	}else{
		echo View::make('error',['message'=>$e->__toString()]);
	}
} 
if($_GET['debug'] == 1)
	profile_end();

