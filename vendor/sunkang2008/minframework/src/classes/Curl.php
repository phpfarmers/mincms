<?php  
/**
*  CURL
*  
*  具体类文件请查看　CurlFunction 
*  
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/

class Curl {
 	static $obj;
 	/** 
 	*	静态方法实现
 	*/ 
 	public static function __callStatic($name, $arguments) 
    {    
    	static::$obj = new CurlFunction;    
    	return call_user_func_array( array(static::$obj , $name) , $arguments);  
    } 
 	 
 	  
}
