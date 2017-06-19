<?php

require_once __DIR__ . '/../../../models/product.m.php';
require_once __DIR__ . '/../../../models/currency.m.php';

class CartModel extends zModel {
	
	public $table_name = 'cart';
	public $id_name = 'cart_id';	

	public function load($product_id, $customer_id) {
		$filter = 'cart_product_id = ? AND cart_customer_id = ?';
		$this->loadSingleFiltered($filter, [$product_id, $customer_id]);		
	}
	
	static function loadCartTotals($db, $customer_id) {
		$totals = [];
		$sql = 'SELECT SUM(item_price) AS p FROM viewProductsInCart WHERE cart_customer_id = ?';
		$statement = SqlQuery::executeSQL($db, $sql, [$customer_id]);
		$result = $statement->get_result();
		if ($row = $result->fetch_assoc()) {
			$totals = $row;
			$selected_currency = Currency::getSelectedCurrency($db);
			$totals['pf'] = formatPrice($row['p'], $selected_currency);
			$totals['pc'] = $selected_currency->convert($row['p']);
		}
		$statement->close();
		return $totals;		
	}
	
	static function loadCart($db, $customer_id) {
		return Product::loadCart($db, $customer_id);
	}
	
	static function emptyCart($db, $customer_id) {
		return SqlQuery::del($db, 'cart', 'cart_customer_id = ?', [$customer_id]);
	}
}