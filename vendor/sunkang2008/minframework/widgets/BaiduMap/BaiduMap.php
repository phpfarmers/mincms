<?php namespace Widget\BaiduMap;
/**
*<code> 
* <?php echo widget('BaiduMap',['id'=>'baidumap','address'=>'上海襄阳公园']);?>
*</code>
*/
use Form,Html,View;
use Widget\Comm;
class BaiduMap extends Comm{ 
 	public $ak = "0ME7KoA1hVt2coCPviSXdv3V";
 	public $id = "baidumap";
 	public $width="400px";
 	public $height="300px";
 	public $address = "上海襄阳公园";
 	public $point = 16;
 	public $zoom = 12;
 	function run(){ 
		$div = "<div id='".$this->id."' style='width:".$this->width.";height:".$this->height."'></div>"; 
	 	Html::link("http://api.map.baidu.com/api?v=2.0&ak=".$this->ak); 
	 	Html::code(" 
			var map = new BMap.Map('".$this->id."');
			var point = new BMap.Point(116.331398,39.897445);
			map.centerAndZoom(point,".$this->zoom.");
			// 创建地址解析器实例
			var myGeo = new BMap.Geocoder();
			// 将地址解析结果显示在地图上,并调整地图视野
			myGeo.getPoint('".$this->address."', function(point){
				if (point) {
					map.centerAndZoom(point, ".$this->point.");
					map.addOverlay(new BMap.Marker(point));
				}else{
					
				}
			});
	 	");
	 	
	 	
	  
 	 	return $div;
	}

}