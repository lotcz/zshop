<?php

class IpFailedAttempt extends ModelBase {
	
	public $table_name = 'ip_failed_attempts';
	public $id_name = 'ip_failed_attempt_id';
	
	public function loadByIp($ip) {
		$filter['ip_failed_attempt_ip'] = $ip;
		$this->loadSingleFiltered($filter);
	}
		
}