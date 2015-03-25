<?php  
 /**
  *  数组
  *
  *  提供数组操作
  *  
  * @author Sun <68103403@qq.com>
  * @license MIT
  * @license    http://opensource.org/licenses/MIT  The MIT License  
  * @version 　2.0
  * @time 2014 
  */
class Arr
{
	static $to_str; 
	static $array_to_one;
	static $get_value;
	static $one_array;
	
	/**
	  * 对象转成数组
	  * @example  Arr::obj2arr($obj)   
	  * @param object $obj 　对象 
	  * @return 数组
	  */
	 static function obj2arr($obj){
		if(!$obj) return;
		$_arr = is_object($obj)? get_object_vars($obj) :$obj;
		foreach ($_arr as $key => $val){
			$val=(is_array($val)) || is_object($val) ? static::obj2arr($val) :$val;
			$arr[$key] = $val;
		}
		return $arr; 
	}
	/**
	* 对array_combine优化
	* @param array $a  
	* @param array $b  
	*/
	static function array_combine($a=[],$b=[]){   
		 $i = 0;
		 foreach($b as $v){
		 	$out[$a[$i]] = $v;
		 	$i++;
		 } 
		 return $out; 
	}
 	
 	/**
 	  * 多维数组转成字符串
	  * @example  Arr::to_str( $arr ,$suffix = "\n", $rest = false )   
	  * @param array $arr 　
	  * @param string $suffix 　
	  * @param bool $rest 　
	  * @return 数组
	  */
 	static function to_str($arr ,$suffix = "\n", $rest = false){ 
 		if(false === $rest) static::$to_str = null;
 		if(!is_array($arr)) return $arr;
 		foreach($arr as $v){  
 			if(!is_array($v)) static::$to_str .= $v . $suffix;
 			if(is_array($v) && static::deep($v)==1){ 
 				static::$to_str .= implode($suffix,$v);
 			}else{
 				static::to_str($v , $suffix , true);
 			} 			
 		} 
 		return  static::$to_str; 
 	}
   
	/**
	* 取数组指定key的值 title  user.title
	* 如使用drupal　该方法将被使用
	* @return 数组
	*/
   static function value($arr = [] , $key){
   	   return static::get_value($arr,$key);
   }
	/**
	* 取数组指定key的值  title  user.title
	* 如使用drupal　该方法将被使用
	* @return 数组
	*/
 	static function get_value($arr = [] , $key){
 			if(!$arr) return;
			$max = static::deep($arr);
			$volist = $arr[$key];
			if($volist) return [$volist];
 			if($max==1){
				$array[] = $arr;
			}else{
				$array = $arr;
			}  
 			foreach($array as $value){
				if(strpos($key,'.')!==false){
					static::$get_value = $value;
 					$vi =  static::_get_value( explode('.',$key) ); 
				 	$rt[] = $vi;
				}else{
					if(array_key_exists($key,$value))
						$rt[] = $value[$key];
					else{
						foreach($value as $v){
							if($v[$key])
								$rt[] = $v[$key];
						}
					}
				}
			} 
			return $rt;
  	}
 	/**
 	  * 取多维数据的指定深度 
	  * @example  Arr::get( $arr = [] , $leep = 1 )   
	  * @param array $arr 　 
	  * @param string $leep 　 
	  * @return 数组
	  */
 	static function get($arr = [] , $leep = null){
  		if(!$arr) return ;
  		$i = 0;
  		foreach($arr as $v){
  			$i++;
  			$vo = $v;
  			if($leep && $leep == $i){
  				goto getleep;
  			} 
  		}
  		getleep:
  		return $vo;
  	}
  	static function last($arr){
  		 return static::get($arr);
  	}
  	/**
 	  * 判断数组为一个时返回第一个
	  * @param array $arr 　 
	  * @return 数组
	  */
  	static function single($arr = []){
  		$i = count($arr);
  		if($i==1){
  			return static::first($arr);
  		}
  		return $arr;
  	}
  	/**
 	  * 判断数组为一个时返回多维
	  * @param array $arr 　 
	  * @return 数组
	  */
  	static function full($arr = []){
  		$i = count($arr);
  		if($i==1){
  			return [$arr];
  		}
  		return $arr;
  	}
  	/**
	 * 多维数组合并（支持多数组）
	 * @return array
	 */
	function array_merge($arr=[])
	{
	    foreach ($arr as $key => $value) {
	    	if(is_array($value)){
	    		static::array_merge($value);
	    	}else{
		    	static::$array_to_one[$key] = $value;
		    }
	    }
	    return static::$array_to_one;
	}

  	/**
 	  * 取多维数组的第一个数组
	  * @example  Arr::first( $arr = []  )   
	  * @param array $arr 　 
	  * @return 数组
	  */
  	static function first($arr = []){
  		return static::get($arr,1);
  	}
  	/**
 	  * 数组深度
	  * @example  Arr::deep( $arr = []  )   
	  * @param array $arr 　 
	  * @return 数字
	  */
  	static function deep($arr = []){  
 	 	$max = 1; 
	        foreach ($arr as $v) {
	            if (is_array($v)) {
	                $deep = static::deep($v) + 1; 
	                if ($deep > $max)  
	                    $max = $deep; 
	            }
	        }        
	        return $max; 
	}
	/**
 	  * 多维数组排序
	  * @example  Arr::deep( $arr,$keys,$type='asc'  )   
	  * @param array $arr 　 
	  * @param string $keys 　 
	  * @param string $type 　 默认值asc 或选值desc
	  * @return 数组
	  */
	function sort($arr,$keys,$type='asc'){ 
		  $keysvalue = $new_array = [];
		  foreach ($arr as $k=>$v){
		 	   $keysvalue[$k] = $v[$keys];
		  }
		  if($type == 'asc'){
		  	  asort($keysvalue);
		  }else{
			    arsort($keysvalue);
		  }
		  reset($keysvalue);
		  foreach ($keysvalue as $k=>$v){
		 	   $new_array[$k] = $arr[$k];
		  }
		  return $new_array; 
	} 
	
   
   /**
	 * 多维数组合成一个　
	 * 如使用drupal　该方法将被使用
	 * @return array
	 */
	function one ($arr) {   
	    static::$one_array = null; 
	    return static::_one($arr);
	}
	
	/**
	 * 	作用：array转xml
	 */
	function arrayToXml($arr,$start="<![CDATA[",$end = "]]>")
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 

        	 }
        	 else
        	 	$xml.="<".$key.">".$start.$val.$end."</".$key.">";  
        }
        $xml.="</xml>";
        return $xml; 
    }
	
	/**
	 * 	作用：将xml转为array
	 */
	public function xmlToArray($xml)
	{		
        //将XML转为array        
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
		return $array_data;
	}
	
	/**
	* 内部使用
	*/	
	function _one ($arr) {  
	    foreach($arr as $k=>$v){
	    	if(is_array($v)){
	    		static::_one($v);
	    	}else{
	    		static::$one_array[$k] = $v;
	    	}
	    }
	    return static::$one_array; 
	}
	/**
	* 内部使用
	*/	
   function _get_value($args){
    	foreach($args as $k){  
   	    	$v = static::$get_value = static::$get_value[$k];
   	    } 
   		return $v;
   }

 
}
