<?php
//记录程序开始时间  
$time_start = microtime(true);
//启动脚本 定时执行代码必须先包含这个文件 
header("Content-type: text/html; charset=utf-8"); 
require __DIR__.'/../../ken.framework/init.php';   
error_reporting(Config::get('app.error_reporting'));  
set_time_limit(0);
ini_set('display_errors', 1);
//时区	
date_default_timezone_set(Config::get('app.timezone'));  

define('WEB',realpath(__DIR__.'/../public/'));
define('BASE',realpath(__DIR__.'/../')); 


 