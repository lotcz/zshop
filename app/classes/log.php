<?php

class ErrorLog {
	
	public $path = 'error.log';
	
	function __construct($path = null) {
		$path = $path || $this->path;		
	}
	
	public function write($message) {		
		$myfile = fopen($this->path, 'a');
		fwrite($myfile, sprintf('%s: %s', date('Y-m-d H:i:s'), $message));
		fclose($myfile);
	}

	public function rewrite($message = null) {
		$myfile = fopen($this->path, 'w');
		fwrite($myfile, $message);
		fclose($myfile);
	}

}