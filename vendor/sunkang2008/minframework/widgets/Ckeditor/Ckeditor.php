<?php namespace Widget\Ckeditor;
/**
*<code>
* <?php echo widget('Ckeditor',['name'=>'a']);?>
*</code>
*/
use Form,Html;
use Widget\Comm;
class Ckeditor extends Comm{ 
  	public $js_opt = [
  		 "toolbar"=>"baisc",
  		 "skin"=>'bootstrapck',
  	];
 	function run(){ 
		$this->publish( __DIR__.'/ckeditor'); 
		$this->opt['style'] = $this->opt['style']?:"width:98%;min-height:400px";
 		$s = Form::text($this->name,["class"=>"ckeditor" ,'value'=>$this->value]+$this->opt);
 		$s .= "<div class='help-block'></div>";
 		$id = "ck".\Str::rand2();
 		
 		$opt = $this->js_opt;
 		$opt['filebrowserImageBrowseUrl'] = $this->url."ckfinder/ckfinder.html?Type=Images";
 		$opt['filebrowserFlashBrowseUrl'] = $this->url."ckfinder/ckfinder.html?Type=Flash";
 		$opt['filebrowserUploadUrl'] = $this->url."ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
 		$opt['filebrowserImageUploadUrl'] = $this->url."ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
 		$opt['filebrowserFlashUploadUrl'] = $this->url."ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash";
 		$opt = json_encode($opt,true);  
		Html::code("
			var ".$id." = CKEDITOR.replace('".$this->name."',".$opt.");"); 
	 	Html::link($this->url.'ckeditor.js');
 	 	return $s;
	}

}