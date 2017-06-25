<?php
	
	return [
		// available formats for image resizing
		'formats' => [
			'mini-thumb' => ['width' => 75, 'height' => 50 ],
			'thumb' => ['width' => 160, 'height' => 140 ],
			'view' => ['width' => 800, 'height' => 600 ]
		],
		
		// absolute path to disk where all images are stored
		'images_disk_path' => 'C:\\develop\\parfumerie\\images\\',
		
		// base url for images src
		'images_url' => 'http://parf-images.loc'
	];