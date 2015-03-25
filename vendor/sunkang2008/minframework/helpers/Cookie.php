<?php  namespace Helper;
/**
*  CookieHelper
*  
*  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @time 2014
*/　
class Cookie
{ 
	/**
	*http_parse_headers
	*@link	http://php.net/manual/en/function.http-parse-headers.php
	*@param string $raw_headers
	*@return array
	*/
	static function http_parse_headers($raw_headers)
    {
        $headers = array();
        $key = ''; // [+]

        foreach(explode("\n", $raw_headers) as $i => $h)
        {
            $h = explode(':', $h, 2);

            if (isset($h[1]))
            {
                if (!isset($headers[$h[0]]))
                    $headers[$h[0]] = trim($h[1]);
                elseif (is_array($headers[$h[0]]))
                {
                    // $tmp = array_merge($headers[$h[0]], array(trim($h[1]))); // [-]
                    // $headers[$h[0]] = $tmp; // [-]
                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1]))); // [+]
                }
                else
                {
                    // $tmp = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [-]
                    // $headers[$h[0]] = $tmp; // [-]
                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [+]
                }

                $key = $h[0]; // [+]
            }
            else // [+]
            { // [+]
                if (substr($h[0], 0, 1) == "\t") // [+]
                    $headers[$key] .= "\r\n\t".trim($h[0]); // [+]
                elseif (!$key) // [+]
                    $headers[0] = trim($h[0]);trim($h[0]); // [+]
            } // [+]
        }

        return $headers;
    }
 
   /**
	* cookie_parse
	*@link	http://www.php.net/manual/en/function.http-parse-cookie.php
	*@param array $header
	*@return array
	*/ 	
   	static function cookie_parse( $header ) {
	        $cookies = array();
	        foreach( $header as $line ) {
	                if( preg_match( '/^Set-Cookie: /i', $line ) ) {
	                        $line = preg_replace( '/^Set-Cookie: /i', '', trim( $line ) );
	                        $csplit = explode( ';', $line );
	                        $cdata = array();
	                        foreach( $csplit as $data ) {
	                                $cinfo = explode( '=', $data );
	                                $cinfo[0] = trim( $cinfo[0] );
	                                if( $cinfo[0] == 'expires' ) $cinfo[1] = strtotime( $cinfo[1] );
	                                if( $cinfo[0] == 'secure' ) $cinfo[1] = "true";
	                                if( in_array( $cinfo[0], array( 'domain', 'expires', 'path', 'secure', 'comment' ) ) ) {
	                                        $cdata[trim( $cinfo[0] )] = $cinfo[1];
	                                }
	                                else {
	                                        $cdata['value']['key'] = $cinfo[0];
	                                        $cdata['value']['value'] = $cinfo[1];
	                                }
	                        }
	                        $cookies[] = $cdata;
	                }
	        }
	        return $cookies;
	}
	/**
	* 把cookie数组转成字符串，方便Curl传递
	*
	*@param array $array
	*@return string
	*/ 	
	static function cookie($array = []){
		foreach ($array as $key => $value) { 
			$cookie.= $value.';'; 
		}
		return $cookie;
	}　
	/**
	*把cookie字符串转成数组
	*<code>
	* 传入的字符串
	*[0] => webwx_data_ticket=AQZhwuyPUklM7pHP47HFExi9; Domain=.qq.com; Path=/; Expires=Sat, 07-Jun-2014 09:23:50 GMT
    *[1] => wxuin=13179485; Domain=.qq.com; Path=/; Expires=Sat, 07-Jun-2014 09:23:50 GMT
    *[2] => wxsid=VSEEI2seluytxAQ8; Domain=.qq.com; Path=/; Expires=Sat, 07-Jun-2014 09:23:50 GMT
    *[3] => wxloadtime=1402046630; Domain=.qq.com; Path=/; Expires=Sat, 07-Jun-2014 09:23:50 GMT
    *[4] => mm_lang=zh_CN; Domain=.qq.com; Path=/; Expires=Sat, 07-Jun-2014 09:23:50 GMT
	*
	*转换后
	*Array
	*(
	*    [webwx_data_ticket] => AQa8pNrTz50uxL83r4q4q6AS
	*    [Domain] => .qq.com
	*    [Path] => /
	*    [Expires] => Sat, 07-Jun-2014 09:33:06 GMT
	*    [wxuin] => 13179485
	*    [wxsid] => 0dxnINOufM0i06cM
	*    [wxloadtime] => 1402047186
	*    [mm_lang] => zh_CN
	*)
	*</code>
	*@param array $array
	*@return string
	*/ 
	static function cookie_array($cookie){
		$arr = explode(';',$cookie);
		$cookie = array();
		foreach($arr as $vo) {
			$k = explode('=',trim($vo));
			if (count($k)>1) {
				$key = trim($k[0]);
				$val = trim($k[1]);
				if (!empty($val)) $cookie[$key] = $val;
			}
		}
		return $cookie;
	}
	
   
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );