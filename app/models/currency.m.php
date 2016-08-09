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
	
	static function jsFormatPrice($db, $selected_currency = null) {
		if (!isset($selected_currency)) {			
			$selected_currency = Currency::getSelectedCurrency($db);
		}
		$s = sprintf('function convertPrice(price) { return price / %d; }', $selected_currency->fval('currency_value'));
		$s.= sprintf('function formatPrice(price) { return (\'%s\').replace(\'%s\', price.formatMoney(%d, \'%s\', \'%s\')); }', $selected_currency->val('currency_format'), '%s', $selected_currency->ival('currency_decimals'), t('decimal_separator'), t('thousands_separator') );
		return $s;
	}
	
	static function formatPrice($db, $price, $selected_currency = null) {
		if (!isset($selected_currency)) {			
			$selected_currency = Currency::getSelectedCurrency($db);
		}
		if (isset($selected_currency)) {
			return sprintf($selected_currency->val('currency_format'), number_format($selected_currency->convert($price), $selected_currency->ival('currency_decimals') , t('decimal_separator') , t('thousands_separator') ));
		} else {
			return $price;
		}
	}
	
	public function convert($price) {
		return parseFloat($price) / $this->fval('currency_value');
	}
	
}