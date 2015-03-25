<?php
namespace module\admin;
use View,QI;
class lang extends \AdminControllers
{  
	public $table = 'lang';
 	function init(){
 		parent::init();
 		\View::$par['active'] = "lang";
 	}
 	 
	function indexAction(){
		$data = []; 
		$nid = (int)$_GET['nid'];
		if($nid>0){
			$data['data'] = QI::from($this->table)->where("id=?",$nid)->one(); 
		}else{
			$data = (array)QI::from($this->table)->page(['url'=>url('admin/lang/index'),'page'=>10,'order by'=>'id desc'])?:[];
		}
		$data['op'] = $_GET['op'];
		if(is_ajax() && $_POST){
			$title = $_POST['name'];
			if(!$title ){
				goto error1;
			}
			$value['name'] = $_POST['name']; 
			$value['status'] = 1;
			$value['lang'] = $_POST['lang'];
			$value['trans'] = $_POST['trans'];		
			$value['slug'] = $_POST['slug'];		
			$ext = QI::from($this->table)->where("name=? and lang=? and slug=?",[$_POST['name'],$_POST['lang'],$_POST['slug']])->one();
			if($nid>0 && $ext->id != $nid){
				exit(json_encode([
						'status'=>0,
						'msg'=>["title"=>"存在相同翻译"],
					]));
			}elseif(!$nid&&$ext){
				exit(json_encode([
						'status'=>0,
						'msg'=>["title"=>__('Exists Same Filed')],
					]));
			}
			
			if($nid<1){
				$value['created'] = time();
			}else{
				$value['updated'] = time();
			}	
			if($nid < 1){
				$rt = QI::insert($this->table,$value);
				if($rt){
					exit(json_encode([
						'status'=>1,
						'data'=>"保存成功",
					]));
				}else{
					error1: 
					exit(json_encode([
						'status'=>0,
						'msg'=>["title"=>"保存失败"],
					]));
				}
			}else{
				$rt = QI::update($this->table,$value,'id=?',$nid);
				exit(json_encode([
						'status'=>1,
						'data'=>"保存成功",
					]));
			}
			
			exit;
		}
		return $this->make('lang',$data);
	} 
	function runAction(){
	 	$all = QI::from($this->table)->all(); 
	 	if($all){
	 		$lang = \Config::get('lang.trans');
	 		$apps = \Config::get('lang.app');
			foreach($all as $v){
				$out[$lang[$v->lang]][$apps[$v->slug]][$v->name] = $v->trans; 
			}
			$dir = BASE."/messages/";
			foreach($out as $k=>$v){
				$ne = $dir.$k;
				if(!is_dir($ne)){
					mkdir($ne,0775,true);
				}
				foreach($v as $_k=>$_v){
					$put[$ne."/".$_k.".php"] = $_v;
				}
				
			}
			foreach($put as $k=>$v){
				$content   = "<?php\n return ".  var_export($v, TRUE) .";";
				file_put_contents($k,$content);
			}
			\Session::flash("success",__('Action Success'));
		}
		redirect(url("admin/lang/index"));
	}
	
	function removeAction(){
		$nid = (int)$_GET['nid'];
		if($nid>0){
			$status = 1;
			$post = QI::from($this->table)->where("id=?",$nid)->one();
			if($post->status == 1){
				$status = 0;
			}
			\Session::flash("success",__('Action Success'));
			QI::update($this->table,['status'=>$status],'id=?',$nid);
		}
		redirect(url("admin/lang/index"));
	}
	
	
}
 

 