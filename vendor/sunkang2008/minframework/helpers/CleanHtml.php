<?php namespace Helper;
/**
*  htmlpurifier
*  
*  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
class CleanHtml {
	static $obj; 
	 
	/**
	* 执行
	*/
	static function run($string){
		if(!static::$obj){
			import(SYS.'/resource/htmlpurifier/library/HTMLPurifier.auto.php'); 
			$config = \HTMLPurifier_Config::createDefault();
			static::$obj =  new \HTMLPurifier($config);
		}
		$obj = static::$obj ;
		return $obj->purify($string);
		
	}
 	
 
 	
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );