<?php
$path = realpath(__DIR__.'/../');
require $path.'/src/functions.php'; 
require $path.'/resource/Aura.Autoload/autoload.php';  
 
$loader =  new \Aura\Autoload\Loader;  
$loader->register();
$loader->addPrefix('Widget',$path."/widgets");
$loader->addPrefix('Helper',$path."/helpers");   


profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ ); 
$loader->setClassFiles([
	'Action'=>$path."/src/classes/Action.php",
	'Arr'=>$path."/src/classes/Arr.php",
	'Asset'=>$path."/src/classes/Asset.php",
	'Auth'=>$path."/src/classes/Auth.php",
	'Cache'=>$path."/src/classes/Cache.php",
	'Config'=>$path."/src/classes/Config.php",
	'Cookie'=>$path."/src/classes/Cookie.php",
	'Curl'=>$path."/src/classes/Curl.php",
	'CurlFunction'=>$path."/src/classes/CurlFunction.php",
	'DB'=>$path."/src/classes/DB.php",
	'File'=>$path."/src/classes/File.php",
	'Form'=>$path."/src/classes/Form.php",
	'Html'=>$path."/src/classes/Html.php",
	'Img'=>$path."/src/classes/Img.php",
	'Lang'=>$path."/src/classes/Lang.php",
	'Log'=>$path."/src/classes/Log.php",
	'Paginate'=>$path."/src/classes/Paginate.php",
	'Q'=>$path."/src/classes/Q.php",
	'Route'=>$path."/src/classes/Route.php",
	'Session'=>$path."/src/classes/Session.php",
	'Str'=>$path."/src/classes/Str.php",
	'Upload'=>$path."/src/classes/Upload.php",
	'View'=>$path."/src/classes/View.php",
	'Widget'=>$path."/src/classes/Widget.php"
	]
); 
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ ); 	

Config::set('loader',$loader); 
return $loader;
