<?php  
/**
*  File 操作  
*  
*  
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
class File
{  
 	static $obj = [];  
	/**
	* 复制整个目录到 $to 下
	*
	* 给Widget 提供 assets 复制目录功能
	*
	* @example  File::cpdir($dir , $to )   
	* @param string $dir 　要复制的目录 
	* @param string $to 　 复制目录到该目录
	* @param string $name 如存在复制到的目录为　$to.'/'.$name; 
	* @return void
	*/
	static function cpdir($dir , $to ,$name = null){
		if($name) $to = $to.'/'.$name; 
	 	if(!is_dir ($dir )){
	 		return false;
	 	}   
 	 	$ar = static::find($dir);  
 	 	if(is_dir($to)) return false; 
 	  	if($ar['dir']){
	 	 	foreach($ar['dir'] as $v){
	 	 		$v = $to.''.str_replace($dir,'',$v);
	 	 		@mkdir($v,0775,true); 
	 	 	}
 	 	}
 	 	if($ar['file']){
	 	 	foreach($ar['file'] as $v){ 
	 	 		$new = $to.''.str_replace($dir,'',$v);
	 	 		@copy($v,$new);
	 	 	} 
 	 	} 
	}
	  
	/**
	* 查看目录下的所有目录及文件
	* 
	*
	* @example  File::find($dir , $find="*" )   
	* @param string $dir 目录 
	* @param string $find 　 所有文件,默认为*
	* @return void
	*/
	static function find($dir,$find='*'){
		$ar = static::__find($dir,$find);   
 	 	static::$obj = [];
 	    return $ar;
	} 
	 
	/**
	* 内部使用,查看目录下的所有目录及文件
	*/	
	static function __find($dir_path,$find='*'){
		static::$obj['dir'][] = $dir_path;
		foreach(glob($dir_path."/*") as $v){ 
			if(is_dir($v)){
				static::$obj['dir'][] = $v;
				static::__find($v,$find);
			}else{
				static::$obj['file'][] = $v;
			} 
		}    
	 	return static::$obj;
	}
	
	 
    /**
	* 删除目录,不考虑目录的层级以及是否有文件都可以删除
	* 
	*
	* @example  File::rmdir($dir)   
	* @return void
	*/
    static function rmdir($dir)
    { 
        if(strtolower(substr(PHP_OS, 0, 3))=='win'){
        	$dir = str_replace('/','\\',$dir);
        	$ex = "rmdir /s/q ".$dir;
        }
        else{
        	$dir = str_replace('\\','/',$dir);
        	$ex = "rm -rf ".$dir;   
        } 
        @exec($ex);
        
    }
    /**
	* 浏览器中打开PDF
	* 
	*
	* @example  File::pdf($file , $filename="1.pdf" )   
	* @param string $file 　 
	* @param string $filename 　打开时保存的文件名
	* @return void
	*/
    function pdf($file ,$filename='1.pdf' ){ 
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes'); 
		@readfile($file);
	}
	 
	/**
	* 取文件名　返回类似 1.jpg
	* 
	*
	* @param string $name  
	* @return string
	*/
	static function name($name){ 
		return substr($name,strrpos($name,'/')+1); 
	}
 
	/**
	* 返回后缀 如.jpg 
	* 
	*
	* @param string $url 　 
	* @return string
	*/
	static function ext($url){
		if(strpos($url,'?')!==false){
			$url = substr($url,0,strrpos($url,'?'));
		}
		return substr($url,strrpos($url,'.')+1); 
	} 
	/**
	* 反射class取文件名
	*/
	function file_name($class = null){
		$reflector = new \ReflectionClass($class);
		return  $reflector->getFileName();
	}
	/**
	* 返回文件目录，不包括文件名
	* 
	*
	* @param string $file_name 　 
	* @return string
	*/
	static function dir($file_name){ 
		return substr($file_name,0, strrpos($file_name,'/'));
	}
	/**
	* 文件大小　1 GB MB kB bytes
	* 
	*
	* @param string $file 　 
	* @return string
	*/
	static function size($file) {
		 $filesize =  filesize($file);
		 if($filesize >= 1073741824) {
		  	$filesize = round($filesize / 1073741824 * 100) / 100 . '  GB';
		 } elseif($filesize >= 1048576) {
		  	$filesize = round($filesize / 1048576 * 100) / 100 . '  MB';
		 } elseif($filesize >= 1024) {
		 	 $filesize = round($filesize / 1024 * 100) / 100 . '  KB';
		 } else {
		 	 $filesize = $filesize . ' bytes';
		 }
		 return $filesize;
	}
 
   
   
}
