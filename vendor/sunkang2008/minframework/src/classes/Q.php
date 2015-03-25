<?php  
/**
*  Q快速数据库  
*  Q::from(table) 等同于 DB::w()->from(table)
*  　　
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
class Q
{ 
	/**
	* 默认主库 w
	*/
	static $w = 'w'; 
	static $obj;
    public static function __callStatic($name, $arguments) 
    {   
    	if ( ! static::$obj)
    		 static::$obj = DB::w(static::$w);    
    	return call_user_func_array( array(static::$obj , $name) , $arguments);  
    }  
}