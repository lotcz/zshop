<?php 

/*
	provides localization mechanism
	
	example:
		$lang = new Localization('lang_files/');
		echo $lang->translate('Hello');
*/
class Localization {
		
	public $lang_name = 'en';
	public $cookie_name = 'language';
	
	function __construct($dir, $lang = null) {
		if (!isset($lang)) {
			if (isset($_COOKIE[$this->cookie_name])) {
				$lang_name = $_COOKIE[$this->cookie_name];
			} elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {				
				$lang_name = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2));
			}
		} else {
			$lang_name = $lang;
		}
		
		$file = $dir . $lang_name . '.php';
		
		if (file_exists($file)) {			
			require $file;
		}
	}
	
	public function translate($s) {
		global $language_data;
		if (isset($language_data) and isset($language_data[$s])) {
			return $language_data[$s];
		} else {
			global $config, $home_dir, $db;
			if ($config['debug_mode']) {
				require_once $home_dir . 'models/translation.m.php';
				require_once $home_dir . 'models/language.m.php';				
				$language = new Language($db);
				$language->loadByCode($language_data['language_code']);
				$t = new Translation($db);
				$t->load($language->ival('language_id'), $s);
				if (!$t->is_loaded) {
					$t->data['translation_name'] = $s;
					$t->data['translation_language_id'] = $language->ival('language_id');
					$t->save();
				}
			}
			return $s;
		}		
	}
	
}