<?php
namespace module\admin;
use View,QI;
use Mo;
use classes\MogoDB\Post as Post;
class mongosync extends \AdminControllers
{  
 	function init(){
 		parent::init();
 		$this->admin();
 		\View::$par['active'] = "post"; 
 	 
 	}
 	function indexAction(){
 		Mo::start();
 		$all = QI::from('post')->all(); 
 		$user = Post::find();
 		$user->remove(); 
 		 
		if($all){
			foreach($all as $v){
				$nid = $v->nid = $v->id;
				$f = unserialize($v->full)?:[];
				$c = unserialize($v->cate)?:[];
			 	unset($v->full,$v->cate);
			 	$out = (array)$v+$f+['cate'=>$c];
			 	$one = Post::findOne(['nid'=>$nid]);
			 	if(!$one){
			 		$user = new Post($out);
    				$user->save();
    			}else{ 
	    			Post::getMapper()->update($out,['$set' => [ 'id' =>$nid ] ],['multiple' => true ]); 
    			}
			}
		} 
	 	\Session::flash("success",__('Action Success'));
		redirect(url("admin/post/index"));
 	}
 
	
}
 

 