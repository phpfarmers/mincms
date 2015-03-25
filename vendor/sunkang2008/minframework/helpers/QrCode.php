<?php  namespace Helper;
/**
*生成二维码
* @link https://github.com/endroid/QrCode 
*<code>  
* $code = new Helper\QrCode;
* $code->run();
*</code>　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @time 2014
*/
use Config;
class QrCode
{ 
	static $obj;
	public $opt;
	public $text = 'Qr Code';
	public $size = 300;
	public $padding = 10;
	public $label = '';
	public $labelSize = 16;
	function __construct(){
	 	if(!static::$obj){
		 	$autoload = Config::get('loader');
		 	if($autoload){
			 	$autoload->addPrefix('Endroid',SYS."/resource/QrCode/src/Endroid"); 
			 	static::$obj = true;
		 	}
	 	}
	 	return $this;
	 }
	 function run(){
	 		$qrCode = new \Endroid\QrCode\QrCode();
	 		if($this->opt){
	 			foreach($this->opt as $k=>$v){
	 				$qrCode = $qrCode->$k($v);
	 			}
	 			$qrCode->render();
	 		}else{
				$qrCode = $qrCode
				    ->setText($this->text)
				    ->setSize($this->size)
				    ->setPadding($this->padding)
				    ->setErrorCorrection('high')
				    ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
				    ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
				if($this->label)
				  $qrCode =  $qrCode->setLabel($this->label);
				 $qrCode->setLabelFontSize($this->labelSize)
				    ->render();
				
			}
	 }
   
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );