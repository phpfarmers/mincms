<?php  namespace Helper;
/**
*  计算坐标点之间的距离 
*  　　
* @author SunKang <68103403@qq.com>
* @license MIT
* @license   http://opensource.org/licenses/MIT  The MIT License  
* @time 2014 
*/ 
class Location 
{
	/**
	* 百度地图KEY
	*/
 	static $key = "0ME7KoA1hVt2coCPviSXdv3V";
	/**
	* 取当前城市 或 整个数组
	* @param $lng 纬度  大的值 
	* @param $lat 经度  小的值  
	* @param $full 是否返回整个数组，默认否
	* @return  string 公里
	*/ 
	function city($lng,$lat,$full = false){
	     $url = "http://api.map.baidu.com/geocoder?location=".$lat.",".$lng."&output=json&key=".static::$key;
		 $data = file_get_contents($url);
		 $arr = json_decode($data,true);
		 if(true === $full) return $arr['result'];
		 return $arr["result"]['addressComponent']["city"];  
	}
	/**
	* 高德坐标转百度
	* @param $lng 纬度  大的值 
	* @param $lat 经度  小的值   
	* @return  [$lng,$lat]
	*/ 
	static function gaodeToBaidu($lng,$lat){
		 $url = "http://api.map.baidu.com/geoconv/v1/?coords={$lng},{$lat}&&output=json&ak=".static::$key;
		 $data = file_get_contents($url);
 		 $arr = json_decode($data,true); 
 		 $lng = $arr['result'][0]['x'];
		 $lat = $arr['result'][0]['y']; 
 		 return [$lng,$lat];
 	}
	/**
	* 获取2点之间的距离
	* @param $lng1 纬度  大的值 
	* @param $lng1 经度  小的值 
	* @param $lng1 纬度  大的值 
	* @param $lng1 经度  小的值 
	* @return  string 公里
	*/
	function distance($lng1, $lat1, $lng2, $lat2){ 
		$PI = 3.1415926535898;
		$EARTH_RADIUS = 6378.137; 
	    $radLat1 = $lat1 * ($PI / 180);
	    $radLat2 = $lat2 * ($PI / 180); 
	    $a = $radLat1 - $radLat2; 
	    $b = ($lng1 * ($PI / 180)) - ($lng2 * ($PI / 180));  
	    $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2))); 
	    $s = $s * $EARTH_RADIUS; 
	    $s = round($s * 10000) / 10000; 
	    return $s; 
	}
}
profile_logs(__FILE__." LINE:".__LINE__ );
profile_logm(__FILE__." LINE:".__LINE__ );