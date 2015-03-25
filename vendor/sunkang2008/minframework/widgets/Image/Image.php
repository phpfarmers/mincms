<?php namespace Widget\Image;
/**
* layoutµÄÊä³ö
*<code>
*$link = Html::link();
*echo implode("\n" , $link);
*$link = Html::code();
*echo implode("\n" , $link);
*</code>
*<form   enctype="multipart/form-data">
*	
*	<?php echo widget('Image',['name'=>'a']);?>
*</form>
*
*  $upload = new Upload;
*   $upload->drupal = true;
*   $upload->openDB = false;
*   $r = $upload->run();
*   if($r){
*   	  echo json_encode($r);
*   }
*</code>	
*/
use Form ,Html;
use Widget\Comm;
class Image extends Comm{
	public $multiple = true;
	public $class;
	public $drupal = true;
	function run(){ 
		$this->name = $this->name?:'file';
		$this->publish( __DIR__.'/js'); 
		$id = str_replace('[]','',$this->name); 
		if($multiple)$opt = ['multiple'=>1];
		$s = Form::file($this->name,['class'=>'ajaxUpload '.$this->class,'id'=>$id]+$this->opt);
		$s .= "<div class='help-block'>";
		
		$value = $this->value;
		if($value){
			if($this->drupal===true){
				$s .=drupal_form_element_image($value,$this->name);
			}
		}
		
		$s .="</div>";
		
	 	Html::link($this->url."jquery.ajaxfileupload.js");
	 	Html::link($this->url.'default.js'); 
	 	return $s;
	}

}