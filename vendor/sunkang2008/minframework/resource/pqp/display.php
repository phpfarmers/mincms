<?php

/* - - - - - - - - - - - - - - - - - - - - - - - - - - - 

 Title : HTML Output for Php Quick Profiler
 Author : Created by Ryan Campbell
 URL : http://particletree.com/features/php-quick-profiler/

 Last Updated : April 22, 2009

 Description : This is a horribly ugly function used to output
 the PQP HTML. This is great because it will just work in your project,
 but it is hard to maintain and read. See the README file for how to use
 the Smarty file we provided with PQP.

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

function displayPqp($output, $config) {
	
$cssUrl = $config.'css/pQp.css';
$css = file_get_contents($cssUrl);		
echo "<style>$css</style>";
echo <<<JAVASCRIPT
<!-- JavaScript -->
<script type="text/javascript">
	var PQP_DETAILS = true;
	var PQP_HEIGHT = "short";
	
	addEvent(window, 'load', loadCSS);

	function changeTab(tab) {
		var pQp = document.getElementById('pQp');
		hideAllTabs();
		addClassName(pQp, tab, true);
	}
	
	function hideAllTabs() {
		var pQp = document.getElementById('pQp');
		removeClassName(pQp, 'console');
		removeClassName(pQp, 'speed');
		removeClassName(pQp, 'queries');
		removeClassName(pQp, 'memory');
		removeClassName(pQp, 'files');
	}
	
	function toggleDetails(){
		var container = document.getElementById('pqp-container');
		
		if(PQP_DETAILS){
			addClassName(container, 'hideDetails', true);
			PQP_DETAILS = false;
		}
		else{
			removeClassName(container, 'hideDetails');
			PQP_DETAILS = true;
		}
	}
	function toggleHeight(){
		var container = document.getElementById('pqp-container');
		
		if(PQP_HEIGHT == "short"){
			addClassName(container, 'tallDetails', true);
			PQP_HEIGHT = "tall";
		}
		else{
			removeClassName(container, 'tallDetails');
			PQP_HEIGHT = "short";
		}
	}
	
	function loadCSS() {
		var sheet = document.createElement("link");
		document.getElementsByTagName("head")[0].appendChild(sheet);
		setTimeout(function(){document.getElementById("pqp-container").style.display = "block"}, 10);
	}
	
	
　	function addClassName(objElement, strClass, blnMayAlreadyExist){
	   if ( objElement.className ){
	      var arrList = objElement.className.split(' ');
	      if ( blnMayAlreadyExist ){
	         var strClassUpper = strClass.toUpperCase();
	         for ( var i = 0; i < arrList.length; i++ ){
	            if ( arrList[i].toUpperCase() == strClassUpper ){
	               arrList.splice(i, 1);
	               i--;
	             }
	           }
	      }
	      arrList[arrList.length] = strClass;
	      objElement.className = arrList.join(' ');
	   }
	   else{  
	      objElement.className = strClass;
	      }
	}

　	function removeClassName(objElement, strClass){
	   if ( objElement.className ){
	      var arrList = objElement.className.split(' ');
	      var strClassUpper = strClass.toUpperCase();
	      for ( var i = 0; i < arrList.length; i++ ){
	         if ( arrList[i].toUpperCase() == strClassUpper ){
	            arrList.splice(i, 1);
	            i--;
	         }
	      }
	      objElement.className = arrList.join(' ');
	   }
	}

　	function addEvent( obj, type, fn ) {
	  if ( obj.attachEvent ) {
	    obj["e"+type+fn] = fn;
	    obj[type+fn] = function() { obj["e"+type+fn]( window.event ) };
	    obj.attachEvent( "on"+type, obj[type+fn] );
	  } 
	  else{
	    obj.addEventListener( type, fn, false );	
	  }
	}
</script>
JAVASCRIPT;

echo '<div id="pqp-container" class="pQp" style="display:none">';

$logCount = count($output['logs']['console']);
$fileCount = count($output['files']);
$memoryUsed = $output['memoryTotals']['used'];
$queryCount = $output['queryTotals']['count'];
$speedTotal = $output['speedTotals']['total'];

echo <<<PQPTABS
<div id="pQp" class="console">
<table id="pqp-metrics" cellspacing="0">
<tr>
	<td class="green" onclick="changeTab('console');">
		<var>$logCount</var>
		<h4>控制台</h4>
	</td>
	<td class="blue" onclick="changeTab('speed');">
		<var>$speedTotal</var>
		<h4>加载时间</h4>
	</td>
	<td class="purple" onclick="changeTab('queries');">
		<var>$queryCount 条</var>
		<h4>数据库</h4>
	</td>
	<td class="orange" onclick="changeTab('memory');">
		<var>$memoryUsed</var>
		<h4>内存使用</h4>
	</td>
	<td class="red" onclick="changeTab('files');">
		<var>{$fileCount} 个文件</var>
		<h4>包含文件</h4>
	</td>
</tr>
</table>
PQPTABS;

echo '<div id="pqp-console" class="pqp-box">';

if($logCount ==  0) {
	echo '<h3>无记录</h3>';
}
else {
	echo '<table class="side" cellspacing="0">
		<tr>
			<td class="alt1"><var>'.$output['logs']['logCount'].'</var><h4>日志</h4></td>
			<td class="alt2"><var>'.$output['logs']['errorCount'].'</var> <h4>错误</h4></td>
		</tr>
		<tr>
			<td class="alt3"><var>'.$output['logs']['memoryCount'].'</var> <h4>内存</h4></td>
			<td class="alt4"><var>'.$output['logs']['speedCount'].'</var> <h4>速度</h4></td>
		</tr>
		</table>
		<table class="main" cellspacing="0">';
		
		$class = '';
		foreach($output['logs']['console'] as $log) {
			echo '<tr class="log-'.$log['type'].'">
				<td class="type">'.$log['type'].'</td>
				<td class="'.$class.'">';
			if($log['type'] == 'log') {
				echo '<div><pre>'.$log['data'].'</pre></div>';
			}
			elseif($log['type'] == 'memory') {
				echo '<div><pre>'.$log['data'].'</pre> <em>'.$log['dataType'].'</em>: '.$log['name'].' </div>';
			}
			elseif($log['type'] == 'speed') {
				echo '<div><pre>'.$log['data'].'</pre> <em>'.$log['name'].'</em></div>';
			}
			elseif($log['type'] == 'error') {
				echo '<div><em>Line '.$log['line'].'</em> : '.$log['data'].' <pre>'.$log['file'].'</pre></div>';
			}
		
			echo '</td></tr>';
			if($class == '') $class = 'alt';
			else $class = '';
		}
			
		echo '</table>';
}

echo '</div>';

echo '<div id="pqp-speed" class="pqp-box">';

if($output['logs']['speedCount'] ==  0) {
	echo '<h3>无记录.</h3>';
}
else {
	echo '<table class="side" cellspacing="0">
		  <tr><td><var>'.$output['speedTotals']['total'].'</var><h4>加载时间</h4></td></tr>
		  <tr><td class="alt"><var>'.$output['speedTotals']['allowed'].'</var> <h4>最大执行时间</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';
		
		$class = '';
		foreach($output['logs']['console'] as $log) {
			if($log['type'] == 'speed') {
				echo '<tr class="log-'.$log['type'].'">
				<td class="'.$class.'">';
				echo '<div><pre>'.$log['data'].'</pre> <em>'.$log['name'].'</em></div>';
				echo '</td></tr>';
				if($class == '') $class = 'alt';
				else $class = '';
			}
		}
			
		echo '</table>';
}

echo '</div>';

echo '<div id="pqp-queries" class="pqp-box">';

if($output['queryTotals']['count'] ==  0) {
	echo '<h3>无记录.</h3>';
}
else {
	echo '<table class="side" cellspacing="0">
		  <tr><td><var>'.$output['queryTotals']['count'].'</var><h4>所有SQL</h4></td></tr>
		  <tr><td class="alt"><var>'.$output['queryTotals']['time'].'</var> <h4>总执行时间</h4></td></tr>
		  <tr><td><var>0</var> <h4>重复SQL</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';
		
		$class = '';
		$output['queries'] = Arr::sort($output['queries'],'time' ,'desc');
		foreach($output['queries'] as $query) { 
			echo '<tr>
				<td class="'.$class.'">'.$query['sql'];
					echo '<em>';
					$st = $query['value'];
					if($st) $st = json_encode($st);
					if($st)
						echo '	传入值: <b>'.$st.'</b> &middot'; 
					echo '时间: <b>'.$query['time'].'</b></em>';
			echo '</td></tr>';
			if($class == '') $class = 'alt';
			else $class = '';
		}
			
		echo '</table>';
}

echo '</div>';

echo '<div id="pqp-memory" class="pqp-box">';

if($output['logs']['memoryCount'] ==  0) {
	echo '<h3>无记录.</h3>';
}
else {
	echo '<table class="side" cellspacing="0">
		  <tr><td><var>'.$output['memoryTotals']['used'].'</var><h4>内存使用</h4></td></tr>
		  <tr><td class="alt"><var>'.$output['memoryTotals']['total'].'</var> <h4>总使用</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';
		
		$class = '';
		foreach($output['logs']['console'] as $log) {
			if($log['type'] == 'memory') {
				echo '<tr class="log-'.$log['type'].'">';
				echo '<td class="'.$class.'"><b>'.$log['data'].'</b> <em>'.$log['dataType'].'</em>: '.$log['name'].'</td>';
				echo '</tr>';
				if($class == '') $class = 'alt';
				else $class = '';
			}
		}
			
		echo '</table>';
}

echo '</div>';

echo '<div id="pqp-files" class="pqp-box">';

if($output['fileTotals']['count'] ==  0) {
	echo '<h3>无记录.</h3>';
}
else {
	echo '<table class="side" cellspacing="0">
		  	<tr><td><var>'.$output['fileTotals']['count'].'</var><h4>总共加载文件数</h4></td></tr>
			<tr><td class="alt"><var>'.$output['fileTotals']['size'].'</var> <h4>总大小</h4></td></tr>
			<tr><td><var>'.$output['fileTotals']['largest'].'</var> <h4>最大</h4></td></tr>
		 </table>
		<table class="main" cellspacing="0">';
		
		$class ='';
		foreach($output['files'] as $file) {
			echo '<tr><td class="'.$class.'"><b>'.$file['size'].'</b> '.$file['name'].'</td></tr>';
			if($class == '') $class = 'alt';
			else $class = '';
		}
			
		echo '</table>';
}

echo '</div>';

echo <<<FOOTER
	<table id="pqp-footer" cellspacing="0">
		<tr>
			<td class="credit">　
				<strong>PHP</strong> 
				<b class="green">Q</b><b class="blue">u</b><b class="purple">i</b><b class="orange">c</b><b class="red">k</b>
				性能</a></td>
			<td class="actions">
				<a href="#" onclick="toggleDetails();return false">显示隐藏</a>
				<a class="heightToggle" href="#" onclick="toggleHeight();return false">高</a>
			</td>
		</tr>
	</table>
FOOTER;
		
echo '</div></div>';

}

?>