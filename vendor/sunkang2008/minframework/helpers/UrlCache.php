<?php namespace Helper;
/**
*  UrlCache 
*  
*  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
/*
*<code>
* page  clip不能同时使用,*为通配
* UrlCache::page([
*	'docs/api',
*	api/*
* ]);
*UrlCache::end();
*片段缓存
*
*UrlCache::clip('q');
*
*echo 'aaa<br>';
*UrlCache::end();
*
*片段缓存
*
*UrlCache::clip('qqq');
*echo 'bbb<br>';
*
*UrlCache::end();
*</code>
*
*/
class UrlCache{
	static $cid;
	/**
	*　片段缓存
	*/
	static $clip = false;
	/**
	*　排除缓存
	*/
	static $get = [];
	/**
	*　缓存使用的类
	*/
	static $cacheClass = "Cache";
	
	static $time = 600;
	/**
	* 片段缓存
	* @param string $name 
 	* @return string 
	*/
	static function clip($name){
		static::$clip = true;
		ob_start();
		static::$cid = $cid = "cacheClip_".$name;
		$type = static::$cacheClass;
   	 	$data = $type::get($cid);
   	 	if($data){
   	 		echo $data; 
   	 		return;
   	 	}	   	 		
	}
	 
	/**
	* 页面缓存
	* @param array $rule  缓存
	* @param array $ex  　排除缓存
	* @return string 
	*/
	static function page($rule = [],$ex = []){ 
	   static::$clip = false; 
	   ob_start();
	   $gt  = static::$get;
	   $uri = \Route::_uri();
	   if($_GET){
	   		$string = "?#string#";
	   		foreach ($_GET as $k=>$v) {
	   			if($gt && in_array($k, $gt)){
	   			}else{
	   				$string .= $k.'='.$v."&";
	   				$fl = true;
	   			}
	   		}
	   		if($fl === true)
	   			$uri = $uri.substr($string,0,-1);
	   }
	   $type = static::$cacheClass; 
	   foreach($rule as $v){
	   	$v = "/".$v;
	   	$code = $like = false;
	   	if(strpos($v,'*')!==false){
	   		$v = str_replace('*','',$v);
	   		$like = true;
	   	}
	   	if($like === true){
		   	if(strpos($uri,$v)!==false){
		   	 	$code = true;	   	 		
		   	}
	   	}elseif($v==$uri){
	   			$code = true;
	   	} 
	   	if($code === true){
	   	   goto ticache;
	   	}
	   }
	   ticache:
	   if($ex){
	   	foreach ($ex as  $v) {
	   		$v = "/".$v;
		   	if(strpos($v,'*')!==false){
		   		$v = str_replace('*','',$v);
		   	}
		   	if(strpos($uri,$v)!==false){
		   	 	$code = false;	   	 		
		   	}if($v==$uri){
	   			$code = false;
	  	 	} 
	   	}
	   }
	   if($code === true){
		    static::$cid = $cid = "urlCache_".md5($uri);
	   	 	$data = $type::get($cid);
	   	 	if($data){
	   	 		echo $data;exit;
	   	 	}
   	 	} 
     }
     /**
     * 输出缓存
     */
     static function end(){ 
     	 if(!static::$cid) return;
     	$data = trim(ob_get_contents());   
		ob_end_clean(); 
		$type = static::$cacheClass; 
		$type::set(static::$cid,$data,static::$time);
	 	echo $data;
	 	if(static::$clip === false){
	 		exit;
	 	}
	 	 
     }
    
  
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );