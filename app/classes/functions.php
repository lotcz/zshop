<?php
	
	function myTrim($s, $chrs = '.,-*/1234567890') {				
		do {
			$trimmed = false;
			$s = trim($s);
			if (strlen($s)) {
				for ($i = 0, $max = strlen($chrs); $i < $max; $i++) {
					if ($s[0] == $chrs[$i]) {
						$s = substr($s,1,strlen($s)-1);
						$trimmed = true;
					}
					if ($s[strlen($s)-1] == $chrs[$i]) {
						$s = substr($s,0,strlen($s)-1);
						$trimmed = true;
					}
				}
			}
		} while ($trimmed);		
		
		return $s;
	}
	
	/*
		remove slashes if they are present at first or last character of the string
	*/
	function trimSlashes($s) {		
		return myTrim($s, '/');
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
	
	/* GET */
	function _g($name, $def = null) {
		return isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $def);
	}
	
	function parseInt($val) {		
		if (isset($val) && strlen(trim($val)) > 0) {
			return intval($val);
		} else {
			return null;
		}
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
	
	/*
		log a debug message
	*/
	function dbg($data) {		
		global $messages;
		$messages->add($data);
	}
	
	/*
		handle fatal db error
	*/
	function dbErr($model, $operation, $sql, $message) {
		global $globals;
		global $messages;
		
		if ($globals['debug_mode']) {
			$messages->dbErr($model, $operation, $sql, $message);
		} else {
			// log error
			redirect('error');
		}
	}
	
	/*
		handle error
	*/
	function handleErr($message, $type) {
		global $globals;
		global $messages;
		
		if ($globals['debug_mode']) {
			$messages->add($message, $type);
		} else {
			// log error
			redirect('error');
		}
	}
		
	function renderBlock($block) {
		global $home_dir;
		include $home_dir . 'blocks/' . $block . '.b.php';
	}
		
	function renderPartial($name, $paramdata) {
		global $home_dir;
		global $data;
		$data['partials.' . $name] = $paramdata;
		include $home_dir . 'views/partials/' . $name . '.v.php';
	}
	
	function renderLink($href, $title, $css = '') {
		global $base_url;
		echo sprintf('<a href="%s" class="%s">%s</a>', $base_url . '/' . $href, $css, t($title));
	}
	
	function renderMenuLink($href, $title) {
		global $base_url, $raw_path;
		if ($raw_path == $href) {
			$css = 'active';
		} else {
			$css = '';
		}
		echo sprintf('<li class="%s"><a href="%s" >%s</a>', $css, $base_url . '/' . $href, t($title));
	}
	
	function renderImage($src, $alt, $css) {
		global $base_url;		
		echo sprintf('<img src="%s" class="%s" alt="%s" />', $base_url . '/images/' . $src, $css, t($alt));
	}
	
	function renderSelect($name, $items, $id_name, $label_name, $selected_value = null) {
		?>
			<select name="<?=$name ?>" class="form-control">
				<?php
					for ($i = 0, $max = count($items); $i < $max; $i++) {
						$value = $items[$i]->val($id_name);
						$selected = '';
						if ($value == $selected_value) {
							$selected = 'selected';
						}
						?>
							<option value="<?=$items[$i]->val($id_name) ?>" <?=$selected ?> ><?=$items[$i]->val($label_name) ?></option>
						<?php
					}
				?>
			</select>
		<?php
		
	}
	
	function formatPrice($price) {
		$res = sprintf('%s&nbsp;Kč', number_format($price , 0 , "," , "&nbsp;" ));
		return $res;
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