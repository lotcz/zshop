<?php
	
	return [
		
		// will be used to create link urls, no trailing slash
		'base_url' => 'http://zshop.loc',
		
		// base dir to include files, trailing slash
		'home_dir' => '../app/',

		// base url for gallery images
		'images_url' => 'http://parf-images.loc',
		
		// base dir where images are stored, it must be writtable and contain "originals" folder
		'images_dir' => 'C:\\develop\\parfumerie\\images\\',

		// turn this off in production!
		'debug_mode' => true, 
		
		// save untranslated strings, turn this off in production!
		'language_check' => false, 
		
		'emails_from' => 'info@parfumerie-hracky.cz',
		
		// for production, put something random here
		'security_token' => 'MySecureToken',

		'db_host' => 'localhost',
		'db_login' => 'root',
		'db_password' => '',
		'db_name' => 'zshop'
		
	];