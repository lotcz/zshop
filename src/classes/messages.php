<?php

class Messages {
	
	public $messages = [];
	
	public function add($message, $type = 'info') {
		$this->messages[] = [$message, $type];
	}
	
	public function error($message) {
		$this->add($message, 'error');
	}
	
	public function dbErr($model, $operation, $sql, $message) {
		$this->add(sprintf('DB error: \'%s\' in model %s during operation \'%s\'. <br/>SQL: %s', $message, $model, $operation, $sql), 'error');
	}
	
}