<?php

class Cart extends ModelBase {
	
	public $table_name = 'cart';
	public $id_name = 'cart_id';	

	public function load($product_id, $customer_id) {
		$filter = 'cart_product_id = ? AND cart_customer_id = ?';
		$this->loadSingleFiltered($filter, [$product_id, $customer_id]);		
	}
	
	static function loadCartTotals($db, $customer_id) {
		$totals = [];
		$sql = 'SELECT SUM(product_price * cart_count) AS p, SUM(cart_count) AS c FROM viewProductsInCart WHERE cart_customer_id = ?';
		$statement = SqlQuery::executeSQL($db, $sql, [$customer_id]);
		$result = $statement->get_result();
		if ($row = $result->fetch_assoc()) {
			$totals = $row;
			$totals['pf'] = formatPrice($row['p']);
		}
		$statement->close();
		return $totals;		
	}
	
}