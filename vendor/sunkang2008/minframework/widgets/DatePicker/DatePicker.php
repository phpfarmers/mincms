<?php namespace Widget\DatePicker;
/**
*<code>
* <?php echo widget('DatePicker',['date'=>[] ]);?>
*</code>
*/
use Form,Html;
use Widget\Comm;
use Helper\CJavaScript;
class DatePicker extends Comm{ 
  	public $opt = [];
  	public $date = [];
  	public $class; 
 	function run(){ 
		$this->publish( __DIR__.'/My97DatePicker'); 
		$this->date = CJavaScript::encode($this->date);
 		$s = Form::text($this->name,[
	 		"class"=>$this->class ,
	 		'onClick'=>"WdatePicker(".$this->date.")",
	 		'value'=>$this->value
 		]+$this->opt);
 	 	Html::link($this->url.'WdatePicker.js');
 	 	return $s;
	}

}