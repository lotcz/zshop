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

	function renderProductImage($src, $alt, $css) {
		global $base_url, $globals;		
		echo sprintf('<img src="%s" class="%s" alt="%s" />', $globals['images_url'] . '/thumbs/thumb_' . $src, $css, t($alt));
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
		$p = intval($price);
		$res = sprintf('%d Kč',$p);
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