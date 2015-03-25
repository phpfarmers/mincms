<?php 
function array_remove_empty_value($v) {  
    if ($v != "") {  
        return true;  
    }  
    return false;  
}  
function drupal_form_element_image($value,$field){ 
		$element = null; 
		$field = str_replace("[]","",$field);
		foreach($value as $vi){
			$url = $vi->url; 
			$url = host()."/".$url;
			$element .= '<div class="drupal_image_delete">';
			$in  = ['jpg','gif','jpeg','png','bmp'];
			if(in_array(strtolower(File::ext($vi->url)),$in)){
				$element .= '<img src="'.$url.'" style="max-width:100px;max-height:100px;">';
			}else{
				$element .= __("File:").$url;
			}
			$element .= '<input type="hidden" value="'.$vi->id.'" name="'.$field.'[]"> <span class="delete">'.__('Remove').'</span></div>';
		} 
		return $element;
}
function show_error($msg,$code = 500){
	throw new Exception($msg);
}
class Mo{
	static $init;
	static function start(){
		if(!static::$init){
			 $connection = new \MongoClient( Config::get('mongo.host') );
			 $db = Config::get('mongo.db');
	   		 \Mawelous\Yamop\Mapper::setDatabase( $connection->$db );
	   		 static::$init = true;
   		}
    }
}
class QI extends Q{

}
class DBI extends DB{
	
}
 