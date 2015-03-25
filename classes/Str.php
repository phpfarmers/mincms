<?php
namespace classes;
class Str{
	/**
	$prize_arr = [
				'0' => array('id'=>1,'prize'=>'平板电脑','v'=>1), 
			    '1' => array('id'=>2,'prize'=>'数码相机','v'=>5), 
			    '2' => array('id'=>3,'prize'=>'音箱设备','v'=>10), 
			    '3' => array('id'=>4,'prize'=>'4G优盘','v'=>12), 
			    '4' => array('id'=>5,'prize'=>'10Q币','v'=>22), 
			    '5' => array('id'=>6,'prize'=>'下次没准就能中哦','v'=>50), 
			];
	foreach ($prize_arr as $key => $val) { 
	    $arr[$val['id']] = $val['v']; 
	}   
	classes\Str::get_rand($arr);
	*/
	function get_rand($proArr) { 
	    $result = '';  
	    //概率数组的总概率精度
	    $proSum = array_sum($proArr);  
	    //概率数组循环
	    foreach ($proArr as $key => $proCur) { 
	        $randNum = mt_rand(1, $proSum); 
	        if ($randNum <= $proCur) { 
	            $result = $key; 
	            break; 
	        } else { 
	            $proSum -= $proCur; 
	        } 
	    } 
	    unset ($proArr);  
	    return $result; 
	}
	 /**
	 * 全概率计算
	 *
	 * @param array $p array('a'=>0.5,'b'=>0.2,'c'=>0.4)
	 * @return string 返回上面数组的key
	 */
	function random($ps){
	    static $arr = array();
	    $key = md5(serialize($ps));

	    if (!isset($arr[$key])) {
	        $max = array_sum($ps);
	        foreach ($ps as $k=>$v) {
	            $v = $v / $max * 10000;
	            for ($i=0; $i<$v; $i++) $arr[$key][] = $k;
	        }
	    }
	    return $arr[$key][mt_rand(0,count($arr[$key])-1)];
	}  
}