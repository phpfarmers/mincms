<?php  namespace Helper;
/**
*  验证
* <code>
*Vali::all([
*		'title'=>[
*			"not_empty"=>[
*				'message'=>"标题不为能空"
*			], 
*			'same'=>[
*			
*				  'message'=>"标题不为能空"
*				]
*			],
*
*
*	]);
*</code>  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @time 2014
*/
class Validator
{
	static function all($arr = []){
		foreach($arr as $k=>$v){
			foreach($v as $k1=>$v1){
				$message = $v1['message']?:"输入信息有误";
				unset($v1['message']);
				$v1['value'] = $_POST[$k];
				$log = static::validate($k1,$v1);
				if($error[$k]) continue;
				if(!$log){
					$error[$k] = $message;
				}
			}
		}
		if($error)
			return $error;
		return;
	}
	/**
	* 验证统一调用
	*
	* @param string $method 　 
	* @param string $args 　 
	* @return  bool
	*/
	static function validate($method,$args){
		if($method=="*"){
			$method = "not_empty";
		}  
		return call_user_func_array(array(__CLASS__,$method), $args);
		
	}
	/**
	* 不为空
	*
	* @param string $input 　 
	* @return  bool
	*/
	static function not_empty($input)
    {
        return  strlen($input)>0?1:0;
    }
	/**
	* 是否是邮件地址
	*
	* @param string $input 　 
	* @return  bool
	*/
    static function email($input)
    {
        return filter_var($input, FILTER_VALIDATE_EMAIL);
    }
    /**
	* 是否是URL
	*
	* @param string $input 　 
	* @return  bool
	*/
    static  function url($input){
	 	return filter_var($input, FILTER_VALIDATE_URL);
	}  
	/**
	* 是否是ip
	*
	* @param string $input 　 
	* @return  bool
	*/
	static function ip($str){
	 	return filter_var($str, FILTER_VALIDATE_IP);
	}  
	/**
	* 是否是手机号
	*
	* @param string $input 　 
	* @return  bool
	*/
	public static function phone($input){
	     return !empty($input) && preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{1,3})[\)\.\-\s]*(([\d]{3})[\.\-\s]?([\d]{4})|([\d]{2}[\.\-\s]?){4})$/', $input);
	} 
	
	static function chinese($input){
		if(preg_match('/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$|^[a-zA-Z0-9\x{4e00}-\x{9fa5}][a-zA-Z0-9_\s\ \x{4e00}-\x{9fa5}\.]*[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$/u',$input)){
			return true;	
		}
		return false;
	}  
	  
	/**
	* 整型URL
	*
	* @param string $input 　 
	* @return  bool
	*/
	public static function int($input){
	 	return filter_var($input, FILTER_VALIDATE_INT)?true:false;
	} 
	/**
	* float 型URL
	*
	* @param string $input 　 
	* @return  bool
	*/
	static function float($input){
	 	return filter_var($input, FILTER_VALIDATE_FLOAT)?true:false;
	}  
	/**
	*  正则
	*
	* @param string $input 　 
	* @return  bool
	*/
    static function preg($value, $regxp){ 
        return preg_match($regxp, $value) > 0;
	}  
	/**
	*  2个值相同
	*
	* @param string $value 
	* @param string $test　 
	* @return  bool
	*/
	static function same($value, $test)
    {
        return $value == $test && strlen($value) == strlen($test);
    }  
    /**
	*  IPv4 地址（格式为 a.b.c.h） 
	*
	* @param string $value  
	* @return  bool
	*/
    static function ipv4($value)
    {
        $test = @ip2long($value);
        return $test !== - 1 && $test !== false;
    } 
    /**
	*  是否是 Internet 域名 
	*
	* @param string $value  
	* @return  bool
	*/
    static function domain($value)
    {
        $regular = "/^([0-9a-z\-]{1,}\.)?[0-9a-z\-]{2,}\.([0-9a-z\-]{2,}\.)?[a-z]{2,}$/i";
        return preg_match($regular, $value);
    } 
    
    /**
	*  是否是日期（yyyy/mm/dd、yyyy-mm-dd）
	*
	* @param string $value  
	* @return  bool
	*/
    static function date($value)
    {
        if (strpos($value, '-') !== false)
        {
            $p = '-';
        }
        elseif (strpos($value, '/') !== false)
        {
            $p = '\/';
        }
        else
        {
            return false;
        }

        if (preg_match('/^\d{4}' . $p . '\d{1,2}' . $p . '\d{1,2}$/', $value))
        {
            $arr = explode($p, $value);
            if (count($arr) < 3) return false;

            list($year, $month, $day) = $arr;
            return checkdate($month, $day, $year);
        }
        else
        {
            return false;
        }
    } 
    /**
	*  是否是时间（hh:mm:ss） 
	*
	* @param string $value  
	* @return  bool
	*/
    static function time($value)
    {
        $parts = explode(':', $value);
        $count = count($parts);

        if ($count != 2 && $count != 3)
        {
            return false;
        }

        if ($count == 2)
        {
            $parts[2] = '00';
        }

        $test = @strtotime($parts[0] . ':' . $parts[1] . ':' . $parts[2]);

        if ($test === - 1 || $test === false || date('H:i:s', $test) != implode(':', $parts))
        {
            return false;
        }

        return true;
    } 
    /**
	*  是否是日期 + 时间 
	*
	* @param string $value  
	* @return  bool
	*/
    static function datetime($value)
    {
        $test = @strtotime($value);
        if ($test === false || $test === - 1)
        {
            return false;
        }
        return true;
    }
    
    
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );