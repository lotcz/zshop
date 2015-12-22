<?php

class Emails {

	static function sendPlain($from, $to, $cc, $subject, $body) {
		$headers = sprintf('From: %s\r\nCC: %s', $from, $cc);
		mail($to, $subject, $body, $headers);
	}

}