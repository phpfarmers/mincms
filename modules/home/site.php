<?php
namespace module\home;
use View,QI;
use classes\MogoDB\Post as Post;

class site extends \FrontControllers
{  
 	function init(){
 		parent::init();
 		\Mo::start(); 
 	}
 
	function indexAction(){ 
	 
		return View::make('index');
	} 
	
	function postAction(){ 
		$cate = $_GET['cate'];
		$cate = [$cate];
	  	$condition = ["cate"=>['$in'=>$cate ]]; 
	  	$page = (int)$_GET['page']?:1; 
	  	$data = Post::find($condition)
	        ->sort([ 'id'=>1 ] ) 
	        ->getPaginator( 10 ,$page ,['url'=>'home/site/post'] );
		return View::make('post',$data);
	} 
	
	function viewAction(){
		$nid = (int)$_GET['id']?:0;
		$data['post'] = QI::from("post")->where("id=?",$nid)->one();
		return View::make('view',$data);
	} 
}
 

 