<?php namespace Widget\Xheditor;
/**
*<code>
* <?php echo widget('Xheditor',['name'=>'a']);?>
*</code>
*/
use Form,Html;
use Widget\Comm;
class Xheditor extends Comm{ 
  
 	function run(){
 		$js_opt = json_encode($this->js_opt); 	 
		$this->publish( __DIR__.'/xheditor'); 
		$this->opt['style'] = $this->opt['style']?:"width:98%;min-height:400px";
 		$s = Form::text($this->name,["class"=>"xheditor" ,'value'=>$this->value]+$this->opt);
 		$s .= "<div class='help-block'></div>";
		Html::code("$('#".$this->name."').xheditor(".$js_opt.");"); 
	 	Html::link($this->url.'xheditor-1.1.14-zh-cn.min.js');
 	 	return $s;
	}

}