<?php
namespace module\admin;
use View,Auth;
class comm extends \AdminControllers
{  
 	function init(){
 		parent::init();
 		  
 	}
 	/**
 	*
 	* $v = new \Helper\Verify;
    *  $v->check(code);
 	*/
	function verifyAction(){
		 $v = new \Helper\Verify;
     	 echo $v->entry();
	} 
	
	
	
}
 

 