<?php namespace Widget\Jui;
/**
* layout�����
*<code>
*$link = Html::link();
*echo implode("\n" , $link);
*$link = Html::code();
*echo implode("\n" , $link); 
*</code>
* jquery ui
*	
*/
use Form ,Html;
use Widget\Comm;
class Jui extends Comm{ 
	public $datepicker  = [
		 "option", 
		 "dateFormat"=>"yy-mm-dd",
	];
	function run(){  
		$this->publish( __DIR__.'/js');  
	 	Html::link($this->url."jquery-ui.min.js");
	 	Html::link($this->url.'jquery-ui.min.css');  
	 	Html::link($this->url.'jquery-ui.theme.min.css');   
	 	$this->datepicker();
	}
	
	function datepicker(){
		Html::code("
	 		$('.datepicker').datepicker(".json_encode($this->datepicker).");
	 		jQuery(function($){  
                $.datepicker.regional['zh-CN'] = {  
                    closeText: '�ر�',  
                    prevText: '<����',  
                    nextText: '����>',  
                    currentText: '����',  
                    monthNames: ['һ��','����','����','����','����','����',  
                    '����','����','����','ʮ��','ʮһ��','ʮ����'],  
                    monthNamesShort: ['һ','��','��','��','��','��',  
                    '��','��','��','ʮ','ʮһ','ʮ��'],  
                    dayNames: ['������','����һ','���ڶ�','������','������','������','������'],  
                    dayNamesShort: ['����','��һ','�ܶ�','����','����','����','����'],  
                    dayNamesMin: ['��','һ','��','��','��','��','��'],  
                    weekHeader: '��',  
                    dateFormat: 'yy-mm-dd',  
                    firstDay: 1,  
                    isRTL: false,  
                    showMonthAfterYear: true,  
                    yearSuffix: '��'};  
                $.datepicker.setDefaults($.datepicker.regional['zh-CN']);  
	 	");
	}

}