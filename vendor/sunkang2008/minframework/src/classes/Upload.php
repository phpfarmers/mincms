<?php  
/**
*  上传文件  
*  　　
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
/**
*<code>
*   上传
*  	
*	$upload = new Upload;
*   $upload->openDB = true;
*	$r = $upload->run();
*	dump($r);
*	
* 		
* 	CREATE TABLE `file` (
*	  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
*	  `name` varchar(200) NOT NULL,
*	  `url` varchar(255) NOT NULL,
*	  `ext` varchar(50) NOT NULL,
*	  `mime` varchar(100) NOT NULL,
*	  `size` int NOT NULL,
*	  `md5` varchar(32) NOT NULL DEFAULT ''
 *	) COMMENT='' ENGINE='MyISAM' COLLATE 'utf8_general_ci'; 
*
*</code>
*/
class Upload
{  
	public  $path = 'upload';  
    private $obj; 
    public $db = 'w';
    public  $url;
    /**
    * 在输出图片时前面加域名
    */
    public $domain;
    protected $dir;
    public $type = ['image/png', 'image/gif','image/jpg','image/jpeg'];
    /**
    * k m g t 
    */
    public $size = "1m"; 
    /**
    * 启用数据库
    */
    public $openDB = false; 
    /**
    * 返回id的前缀　可供drupal使用
    */
    public $drupal = false; 
    /**
    * 仅供drupal使用
    */
    protected $drupal_url;
    /**
    * 构造函数
    */
    public function __construct($path = null){  
     	if($path) $this->path = $path;
     	$this->drupal_url = date('Y').'/'.date('m');
		$this->url = $this->path.'/'.$this->drupal_url;
		$this->dir = WEB.'/'.$this->url;
		$dir = WEB.'/'.$this->path; 
		
		if(!is_dir($this->dir)){
			@mkdir($this->dir,0777,true);
		} 
		if(!is_writable($dir)){
			throw new Exception("上传文件目录及权限问题:".$dir);
		}   
   	} 
    /**
    * 执行上传文件操作
    */
    function run(){  
    	if(count($_FILES)==0) return; 
    	foreach($_FILES as $key=>$v)
    	{
    		$name = $v['name'];
    		$temp = $v['tmp_name'];
    		$type = $v['type'];
    		$size = $v['size']; 
    		
    		
    		/*if ( ! is_uploaded_file($v['tmp_name']))
			{
				$error = isset($v['error']) ? $v['error'] : 4;
				switch ($error)
				{
					case UPLOAD_ERR_INI_SIZE:
						$error['upload_file_exceeds_limit'] = '上传文件超过设置大小';
						break;
					case UPLOAD_ERR_FORM_SIZE:
						$error['upload_file_exceeds_form_limit'] = "上传文件超过表单允许最大值";
						break;
					case UPLOAD_ERR_PARTIAL:
						$error['upload_file_partial'] = "上传失败";
						break;
					case UPLOAD_ERR_NO_FILE:
						$error['upload_no_file_selected'] = "未选择上传文件";
						break;
					case UPLOAD_ERR_NO_TMP_DIR:
						$error['upload_no_temp_directory'] = "上传临时目录失败";
						break;
					case UPLOAD_ERR_CANT_WRITE:
						$error['upload_unable_to_write_file'] = "上传文件写入失败";
						break;
					case UPLOAD_ERR_EXTENSION:
						$error['upload_stopped_by_extension'] = "上传文件的类型错误";
						break;
					default:
						$error['upload_no_file_selected'] = "上传错误了";
						break;
				}
				return FALSE;
			}*/
			
    		if(is_array($name)){
    			foreach($name as $k=>$vo){
    				$array[] = $this->upload_file($vo,$type[$k],$temp[$k],$size[$k],$key);
    			}
    		}else{
    			$array = $this->upload_file($name,$type,$temp,$size,$key);
    		}
    	} 
    	return $array;
    	 
    }
    protected function error(){
    	
    }
    /**
    * 内部函数
    */
    protected function upload_file($name,$type,$temp,$size,$key){
    	if(!$this->domain){
    		$this->domain = base_url();
    	}
    	if(in_array($type,$this->type) && $size <= $this->bit($this->size) ){
			$ext = File::ext($name);
			$rename = strtolower(uniqid(true).".$ext");
			$url = $this->url."/".$rename;
			$full = $this->dir."/".$rename; 
			$d7 = $this->drupal_url.'/'.$rename;
			if($this->openDB == true){
    			$md5 = md5(file_get_contents($temp));
    			$one = DB::w($this->db)
    				->from('`file`')
    				->where('md5=?',$md5)
    				->one();  
				if(!$one){  
			    	$insert = [
			    		'name'=>$rename,
			    		'url'=>$url,
			    		'ext'=>$ext,
			    		'mime'=>$type,
			    		'size'=>$size,
			    		'md5'=>$md5,  
			    	];
			    	$id = DB::w($this->db)->insert('`file`',$insert);
			    	move_uploaded_file($temp,$full);
			    }else{
			    	$url = $one->url;
			    	$id = $one->id;
			    }
		    }else{
		  	  move_uploaded_file($temp,$full); 
		    }
		    $array = [ 
		    	'url' => $this->domain.$url,
		    	'size' => $size,
		    	'type'  => $type,
		    	'ext'  => $ext,
		    ];
		    
		    $array['id'] = $id?:$url;
		    $array['key'] = $key;
 		    if($this->drupal == true){
 		    	$array['id'] = "public://".$d7;
 		    }
		}else{
			return;
		}
		return $array;
    }
    /**
    * 把1m转成对应文件大小的具体bits
    */
    function bit($size){ 
	    $unit = strtolower($size);
	    $unit = preg_replace('/[^a-z]/', '', $unit);	  
	    $value = intval(preg_replace('/[^0-9]/', '', $size));	  
	    $units = array('k'=>1, 'm'=>2, 'g'=>3, 't'=>4);
	    $exponent = isset($units[$unit]) ? $units[$unit] : 0;	  
	    return ($value * pow(1024, $exponent));           
	}
  
   
	
 
}
