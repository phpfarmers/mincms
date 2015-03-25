<?php 
$loader = require  __DIR__.'/vendor/autoload.php';   

import(__DIR__.'/controller.php');
import(__DIR__.'/database.php');
import(__DIR__.'/function.php'); 

if(!Cookie::get('guest')){
	Cookie::set('guest',Str::rand());
}
Cache::set_key('jointaichi');
// h 或 hh 更严格的xss
bootstrap('hh');

if(!Cookie::get('guest')){
	Cookie::set('guest',Str::rand(),time()+3600*30*12*20);
}

Lang::init($path)->load('app');
Lang::$lang  = "zh_CN";
Session::start();

if(!in_array(get_ip(),['127.0.0.1','::1'])){
	View::$minify = true;
}