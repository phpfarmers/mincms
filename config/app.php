<?php 
$config['refer'] = [
	"/admin/site/login"
];
$config["site_title"]  = [
		"default"=>"website_title"
	];
$config["admin_site_title"]  = [
		"default"=>"Admin Control",
	];

$menu[] = ['url'=>'/','title'=>"Home"];
$c = QI::from("cate")->where("menu=?",1)->order_by("sort desc,id asc")->all();
if($c){
	foreach($c as $v){
		$menu[] = ['url'=>url('home/site/post',['cate'=>$v->id]),'title'=>__($v->title)];
	}
}
$config["menu"]  = $menu;
$config["admin_menu"]  = [
		['url'=>url('admin/post/index'),'title'=>"Post"],
		['url'=>url('admin/cate/index'),'title'=>"Cate"], 
		['url'=>url('admin/field/index'),'title'=>"Field"],
		['url'=>url('admin/config/index'),'title'=>"Setting"],
		['url'=>url('admin/lang/index'),'title'=>"Language"],
		['url'=>url('admin/user/index'),'title'=>"User"],
		['url'=>url('admin/site/logout'),'title'=>"Logout"],
	];
return $config;