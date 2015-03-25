<?php namespace Helper;
/**
*  发送邮件 
*  
*  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @version 　2.0
* @time 2014
*/
/**
*<code>
*   http://swiftmailer.org/docs/messages.html
*  
*    使用方法
*   
* Mail::init()->from()
*   	->to(['youaddress@a.com'=>'user'])
*  	    ->title('标题')
* 	    ->body("content内容<hr>不错")
*	    ->send();
*
*附件
*attach($file)
*addPart
*part($html)
*</code>
*/
class Mail {
	/**
	* transport
	*/
	public $transport;
	/**
	* message
	*/
	public $message;
	/**
	* mailer句柄
	*/
	public $mailer;

	static $obj;
	/**
	* 初始化
	*/
	static function init(){
		if(!isset(static::$obj))
			static::$obj = new Static;
		return static::$obj;
	}
	/**
	* smtp设置
	*
	* @param string $smtp 　 
	* @param string $user 　 
	* @param string $pwd 　 
	* @param string $port 　 
	* @return   
	*/
	function smtp($smtp,$user,$pwd,$port=25){
		$this->transport = Swift_SmtpTransport::newInstance($smtp, $port)
			  ->setUsername($user)
			  ->setPassword($pwd);
 	}
	/**
	* sendmail设置
	*
	* @param string $bin 　  /usr/sbin/sendmail -bs
	* @return   
	*/
	function sendmail($bin = '/usr/sbin/sendmail -bs'){ 
		$this->transport = Swift_SendmailTransport::newInstance($bin);
 	}
	/**
	* mail设置
	* 
	* @return   
	*/
	function mail(){
		$this->transport = Swift_MailTransport::newInstance();
 	}
	/**
	* 发送邮件
	* 
	* @return  bool
	*/
	function send(){ 
		if(!$this->mailer->send($this->message)){ 
			return false;
		}
		return true;
 	} 
	/**
	* 构造函数  
	*/
	function __construct() {
		import( SYS.'/resource/swiftmailer/lib/swift_required.php' ); 
 		$type = Config::get('mail.type');
		switch($type){
			case "smtp":
				$this->smtp(Config::get('mail.smtp'),Config::get('mail.user'),Config::get('mail.pwd'));
				break;
			case "sendmail":
				$this->sendmail(Config::get('mail.smtp'));
				break;
			case "mail":
				$this->mail();
				break;
			default:
				$this->mail();
				break;
		} 
		$this->mailer = Swift_Mailer::newInstance($this->transport); 
		$this->message = Swift_Message::newInstance(); 
		return $this;
	} 
	/**
	* 邮件标题
	*
	* @param string $title 
	* @return   object
	*/
	function title($title){
		$this->message->setSubject($title);
		return $this;
	} 
	/**
	* 发件人
	* 默认 mail.user mail.name
	*
	* @param string $arr ['john@doe.com' => 'John Doe']
	* @return   object
	*/
	function from($arr = null){
		if(!$arr){
			$arr = [Config::get('mail.user')=>Config::get('mail.name')?:'mailer'];
		}
		$this->message->setFrom($arr) ;
		return $this;
	}
	/**
	* 收件人
	*
	* @param string $arr 
	* @return   object
	*/
	function to($arr = []){
		$this->message->setTo($arr);
		return $this;
		return $this;
 	}
 	/**
	* 邮件主体内容
	*
	* @param string $body 
	* @return   object
	*/
	function body($body){
		$this->message->setBody($body, 'text/html');
		return $this;
 	}
 	/**
	* 邮件part
	*
	* @param string $body 
	* @return   object
	*/
	function part($body){
		$this->message->addPart($body, 'text/html'); 
		return $this;
 	}
 	/**
	* 邮件附件
	*
	* @param string $body 
	* @return   object
	*/
	function attach($file){
		$this->message->attach(Swift_Attachment::fromPath($file));
		return $this;
	}
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );