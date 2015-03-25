<?php   namespace Helper;
/**
*  清理由composer生成的垃圾文件
*　减少vendor大小
*  new VendorHelper($vendor);
*  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @since 开发时间 2015 年
* @time 2015
*/
　
class Vendor 
{
	/**
	* 要清理的目录
	*/
	public $path = [
		'.git','test','doc','docs'
	];
	/**
	* 要清理的文件
	*/
	public $file = [
		'README.md','composer.json',
		'CHANGELOG.md','.gitignore',
		'.jshintrc','.travis.yml','CONTRIBUTING.md','Gruntfile.js',
		'LICENSE','package.json','UPGRADE.md','LICENSE.md'
	];
	static $v;
	static $f;
	/**
	* 构造函数
	*/
    public function __construct($vendor)
    { 
    	$list = $this->dir($vendor);
		if(static::$v){
			foreach(static::$v as $v){
				$this->rmdir($v);
			}
		}
		if(static::$f){
			foreach(static::$f as $v){
				unlink($v);
			}
		}
		echo 'clean vendor finish.';
    }
    /**
	* 目录
	*
	* @param string $vendor 　 
	* @return  void
	*/
    public function dir($vendor){
    	$list = scandir($vendor);
		foreach($list as $v){
			$dr = $vendor.'/'.$v;
			if(is_dir($dr) && $v!='.' && $v!='..'){
				 if(in_array($v,$this->path)){
				 	static::$v[] = $dr;
				 }
				 $this->dir($dr);
			}elseif(in_array($v,$this->file)){
				 	static::$f[] = $dr;
			}
		}
    }
    /**
	* 删除目录
	*
	* @param string $dir 　 
	* @return  void
	*/
    public function rmdir($dir)
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
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );