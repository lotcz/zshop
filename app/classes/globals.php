<?php

require_once $home_dir . 'classes/query.php';

// configurable site global settings stored in database
class SiteGlobals extends ArrayObject {
	
	private $db = null;
	
	function __construct($db) {
		$this->db = $db;
		$stmt = SqlQuery::select($db, 'site_globals');
		$result = $stmt->get_result();		
		while ($row = $result->fetch_assoc()) {			
			$this[$row['site_global_name']] = $row['site_global_value'];
		}
		$stmt->close();
	}
	
	function getForm($action) {
		$form = new Form('site_globals', $action);
	
		foreach ($this as $key => $value) {
			$form->addField([
				'name' => $key,
				'label' => $key,
				'type' => 'text',
				'value' => $value
			]);
		}
		
		return $form;
	}
	
	function processForm($form) {
		$values = $form->processInput($_POST);
		
		foreach ($values as $key => $value) {
			SqlQuery::update($this->db, 'site_globals', ['site_global_value' => $value], 'site_global_name = ?', [$key]);
			$this[$key] = $value;
		}
		
	}
	
}