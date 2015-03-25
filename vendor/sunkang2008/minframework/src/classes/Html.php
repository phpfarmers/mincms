<?php  
/**
*  Html 
*  
*  　　
* @author Sun <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
/**
*<code>
* Html::code("$('#".$this->name."').xheditor();");
* Html::link('a.js?');
* Html::link('aa.js');
* echo implode("\n",Html::link());
* echo implode("\n",Html::code());
*</code>
*/
class Html
{ 
  /**
   * 所有链接
   */
   static $link = []; 
   /**
   * 所有code
   */
   static $code = [];
   /**
   * 是否加载 $(function(){ }); 默认加载
   */
   static $jquery = true; 
  /**
  * 是否是不加http:// https://的链接
  *
  * @param bool
  */
   static function _http($str){
   		if(strpos($str,'http://') !== false || strpos($str,'https://') !== false || substr($str,0,2)=='//'){
   			return true;
   		}
   		return false;
   }
  
  /**
  * 写CODE 与输出CODE
  *
  * @param string $code 　 
  * @return  void
  */
   static function code($code = null){
       if(!$code){
       	    $css = static::$code['css'];
       	    if($css) $css = "<style rel='stylesheet'>\n".implode('\n',$css)."\n</style>\n";
       	    $js = static::$code['js'];
        	if($js) {
        		if(static::$jquery === true){
        			$a = "$(function(){\n";
        			$b = "\n});";
        		}
        		$js = "<script type='text/javascript'>\n".$a.implode('\n',$js).$b."\n</script>\n";
        	}
   	   		return [ 
	   	   		'css'=>$css,   	   		
	   	   		'js'=>$js 
   	   		];
   	   }
   	   $id = md5($code);
   	   $code = trim($code);
   	   $type = 'css';
   	   //js code 
   	   if(substr($code,0,1) == '$' || substr($code,0,8)=="function" || substr($code,0,4)=="var " || substr($code,0,7)=="window."){
   	   		$type = 'js';
   	   }  
   	   static::$code[$type][$id] = $code;  
   } 
  /**
  * 取得code,link
  *  
  * @return  void
  */
   static function get(){
  		return [
  			'code'=>static::$code,
  			'link'=>static::$link,
  		];
   }
  /**
  * 写link 与输出link
  *
  * @param string $link 　 
  * @return  void
  */
   static function link($link = null){  
   		 if(!$link){
   		 	$css = static::$link['css'];
       	    if($css) {
       	    	unset($cssLink);
        		foreach($css as $v){
       	  		  	$cssLink .= '<link href="'.$v.'" rel="stylesheet">'."\n";
       	    	}
       	    }
       	    $js = static::$link['js'];
        	if($js) { 
        		unset($jsLink);
        		foreach($js as $v){
        			$jsLink .= "<script type='text/javascript' src=\"".$v."\"></script>\n";
        		}
        	}
   	   		return [ 
	   	   		'css'=>$cssLink,   	   		
	   	   		'js'=> $jsLink
   	   		];
   		 }
   		 $ext = File::ext($link);
   		 $i = strpos($ext,"?"); 
   		 if($i!==false) {
	   		 $ext = substr($ext,0,$i);
	   		 $j = substr($link,0,$i).$ext;
   		 }else{
   		 	 $j = $link;
   		 } 
   		 if(!in_array($ext,['css','js'])){
   		 	$ext = "js";
   		 }
   		 static::$link[$ext][md5($j)] = $link;
   }
   
    
   
   
}
