<?php
	
	/*
		remove slashes if they are present at first or last character of the string
	*/
	function trimSlashes($s) {
		if ($s[0] == '/') {
			$s = substr($s,1,strlen($s)-1);
		}
		if ($s[strlen($s)-1] == '/') {
			$s = substr($s,0,strlen($s)-1);
		}
		return $s;
	}
	
	/* 
		redirect to a new url using http header
		use relative path to web's base_url
		use of leading or trailing slash is optional
		example: redirect('admin');
	*/
	function redirect($url, $statusCode = 303) {
		global $base_url;
		header('Location: ' . trimSlashes($base_url) . '/' . trimSlashes($url), true, $statusCode);
		die();
	}
	
	/*
		translate string to current language
	*/
	function t($s) {
		global $localization;
		$t = $localization->translate($s);
		if (func_num_args() > 1) {
			$args = func_get_args();
			array_shift($args);
			array_unshift($args, $t);
			$t = call_user_func_array('sprintf', $args);
		}
		return $t;
	}
		
	function renderBlock($block) {
		global $home_dir;
		include $home_dir . 'blocks/' . $block . '.b.php';
	}
	
	/*
		TOKEN GENERATOR
		
		example: $token = generateToken(10);
		-- now $token is something like '9HuE48ErZ1'
	*/
	function getRandomNumber() {
		return rand(0,9);
	}
	
	function getRandomLowercase() {
		return chr(rand(97,122));
	}
	
	function getRandomUppercase() {
		return strtoupper(getRandomLowercase());
	}	
	
	function generateToken($len) {
		$s = '';
		for ($i = 0; $i < $len; $i++) {
			$case = rand(0,2);
			if ($case == 0) {
				$s .= getRandomNumber();
			} elseif ($case == 1) {
				$s .= getRandomUppercase();
			} else {
				$s .= getRandomLowercase();
			}
		}
		return $s;
	}