<?php  
 /**
  *  用户注册　登录　修改密码
  *　
  *  
  * @author Sun <68103403@qq.com>
  * @license MIT
  * @license    http://opensource.org/licenses/MIT  The MIT License  
  * @version 　2.0
  * @time 2014
  */
/**
*
*<code>
*	Auth::$save = 'Cookie';  //使用Cookie方式记录用户登录信息
*	Auth::create('admin',111111); //注册　
*	Auth::login('admin',111111); 　//登录
*	Auth::change_password_on('admin',222222); 　//直接修改密码
*	Auth::change_password('admin',222222,111111);　//使用原密码，修改密码
*	
*	
*	MySQL数据表:
*	
*	DROP TABLE IF EXISTS `user`;
*	CREATE TABLE `user` (
*	  `id` int(11) NOT NULL AUTO_INCREMENT,
*	  `name` varchar(20) NOT NULL,
*	  `pwd` varchar(100) NOT NULL,
*	  `hash` varchar(100) NOT NULL,
*	  PRIMARY KEY (`id`)
*	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*
*
*</code>
*　
*/
class Auth
{ 
	/**
	*　内部属性
	*/
	static $_hash;
	/**
	* 表名
	*/
	static $table = 'user';
	/**
	* 用户字段
	*/
	static $usr = 'name';
	/**
	* 密码字段
	*/
	static $pwd = 'pwd';
	/**
	* 内部属性
	*/
	static $hash = 'hash'; 
	/**
	* 登录保存方式　仅支持Cookie/SESSION
	*/
	static $save = 'Cookie';
	/**
	* 判断是否登录　
	*/
	static function check(){
		$c = static::$save; 
		if($c::get('id') && $c::get('name')) return true;
 		return false;
	}
	/**
	* 取得当前登录用户的key对应的值
	* @param string $key
	* @return string
	*/
	static function get($key){
		$c = static::$save; 
		return $c::get($key);
 	}
 	/**
	* 退出　　
	* @return void
	*/
	static function logout(){
		$c = static::$save; 
		$c::delete(['id','name']);
 	}
 	/**
	* 登录
	* @param string $name　用户名
	* @param string $pwd　　密码
	* @return array [id,name]
	*/
	static function login($name,$pwd){
		$name = trim($name);
		$pwd = trim($pwd);
		if(!$name || !$pwd) return false;  
		$one = Q::from(static::$table)->where(static::$usr.'=?',$name)->one(); 
		$h = static::$hash;
		$p = static::$pwd;
		$name = static::$usr;   
		if(!$one || !static::verify($pwd,$one->$h,$one->$p)) return false;
		$c = static::$save;
		$c::set('id',$one->id,0);
		$c::set('name',$one->$name,0);
		return $c::get(['id','name']);
	}
	/**
	* 直接修改密码,无需原密码
	* @param string $name　用户名
	* @param string $pwd　　密码
	* @return bool
	*/
	static function change_password_on($name,$pwd){
		$name = trim($name);
		$pwd = trim($pwd);
		if(!$name || !$pwd) return false; 
		$one = Q::from(static::$table)->where(static::$usr.'=?',$name)->one();
 		if(!$one) return false;
 		$password = static::hash($pwd); 
		$id = Q::update(static::$table,[ 
			static::$pwd=>$password,
			static::$hash=>static::$_hash,
		],'id=?',$one->id);
		return true;
	}
	/**
	* 修改密码,需要原密码也正确才能修改成功　
	* @param string $name　用户名
	* @param string $old_pwd　原密码
	* @param string $pwd　　密码
	* @return bool
	*/
	static function change_password($name,$old_pwd,$pwd){
		$name = trim($name);
		$old_pwd = trim($old_pwd);
		$pwd = trim($pwd);
		if(!$name || !$old_pwd || !$pwd) return false; 
		$one = Q::from(static::$table)->where(static::$usr.'=?',$name)->one();
		$h = static::$hash;
		$p = static::$pwd;
		$name = static::$usr;   
		if(!$one || !static::verify($old_pwd,$one->$h,$one->$p)) return false;
		$password = static::hash($pwd);
		$id = Q::update(static::$table,[ 
			static::$pwd=>$password,
			static::$hash=>static::$_hash,
		],'id=?',$one->id);
		return true;
	}
	/**
	* 注册用户
	* @param string $name　用户名
	* @param string $pwd　　密码
	* @return bool
	*/
	static function create($name,$pwd){
		$name = trim($name);
		$pwd = trim($pwd);
		if(!$name || !$pwd) return false; 
		if(Q::from(static::$table)->where(static::$usr.'=?',$name)->one()){
			return false;
		}
		$password = static::hash($pwd);  
		$id = Q::insert(static::$table,[
			static::$usr =>$name,
			static::$pwd =>$password,
			static::$hash =>static::$_hash,
		]); 
		return $id;
	}
	/**
	* 内部函数
	*/
	static function hash($password)
    {  
    	static::$_hash = Str::rand(5);
		return crypt($password, '$1$'.static::$_hash.'$');
     }
    /**
	* 内部函数
	*/
    static function  verify($password,$hash ,$hash_check){  
    	return  crypt($password ,'$1$'.$hash.'$' ) == $hash_check?true:false;
    }

 
}
