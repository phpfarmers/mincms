<?php namespace Widget;
class Comm extends \Widget{ 
	public $id; 
	public $name; 
	public $value;
	public $opt = [];
	public $js_opt = [];
	function init(){  
		if(!$this->name) $this->name = $this->id;
		 
	}
}