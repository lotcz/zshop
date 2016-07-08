<?php

class Currency extends ModelBase {
	
	public $table_name = 'currencies';
	public $id_name = 'currency_id';
	
	static $selected_currency_cache = null;

	static function getSelectedCurrency($db) {
		if (!isset(Currency::$selected_currency_cache)) {
			$currencies = Currency::all($db);
			if (isset($_COOKIE['currency'])) {
				$selected_currency_id = $_COOKIE['currency'];
				$selected_currency = Currency::find($currencies, 'currency_id', $selected_currency_id);
			}
			
			if (!isset($selected_currency)) {
				$selected_currency = Currency::find($currencies, 'currency_value', 1);
			}

			Currency::$selected_currency_cache = $selected_currency;
			
		}

		return Currency::$selected_currency_cache;
	}
	
}