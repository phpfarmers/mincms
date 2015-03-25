<?php   namespace Helper;
/**
* https://github.com/phpseclib/phpseclib
*/
use Config;
class PhpSecLib{
		static $obj;
		static $o;
		function __construct(){
		 	if(!static::$obj){
			 	$autoload = Config::get('loader');
			 	if($autoload){
				 	$autoload->addPrefix('phpseclib',SYS."/resource/phpseclib/phpseclib"); 
				 	static::$obj = true;
			 	}
		 	}
		 	return $this;
		 }
		 
		 function encode($value,$key = null,$type = "AES"){
		 	 if($key == null){
		 	 	$key = Config::get('phpseclib')?:"phpseclib";
		 	 }
		 	 if(!static::$o['crypt_'.$type]){
			 	 $class = "\phpseclib\Crypt\\".$type;
			     $aes = new $class(); 
			     static::$o['crypt_'.$type] = $aes;
		     }else{
		     	$aes = static::$o['crypt_'.$type];
		     }
		     $aes->setKey($key); 
		     return base64_encode($aes->encrypt($value));
		 }
		 
		 function decode($value,$key = null,$type = "AES"){
		 	 if($key == null){
		 	 	$key = Config::get('phpseclib')?:"phpseclib";
		 	 }
		 	 if(!static::$o['crypt_'.$type]){
			 	 $class = "\phpseclib\Crypt\\".$type;
			     $aes = new $class(); 
			     static::$o['crypt_'.$type] = $aes;
		     }else{
		     	$aes = static::$o['crypt_'.$type];
		     }
		     $aes->setKey($key);  
		     return $aes->decrypt(base64_decode($value));
		 }
		 
	 

}


profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );