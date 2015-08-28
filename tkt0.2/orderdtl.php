<?php

class OrderDtl {
	public $orderix;

	public function __construct() {
		$orderix = 0;
		$orderdtlix = 0;
		$itemix = 0;
		$eventix = 0;
		$action = "";
		$qty = 0;
		$extamt = 0.00;
	}

	public function load($orderix, $orderdtlix) {
		$sql = 
			"SELECT orderix, orderdtlix, itemix, eventix, action, qty, extamt " .
			"  FROM orderdtl " .
			"  WHERE orderix = $orderix AND orderdtlix = $orderdtlix";
		dispsql($sql);
		$result = mysql_query($sql) or
			die("Error loading OrderDtl for orderix $orderix, orderdtlix $orderdtlix. " . mysql_error());
		$o = mysql_fetch_object($result, "OrderDtl");

		foreach($o as $key => $value) $this->{$key} = $o->{$key};
	}

	public static function select($orderix) {
		$sql =
			"SELECT orderix, orderdtlix, itemix, eventix, action, qty, extamt " .
			"  FROM orderdtl " .
			"  WHERE orderix = $orderix " .
			"  ORDER BY orderdtlix";
		dispsql($sql);
		$result = mysql_query($sql) or
			die("Error selecting OrderDtl for orderix $orderix. " . mysql_error());
		return $result;
	}

	public function save() {
		$ER_DUP_ENTRY = 1062;

		$sql =
			"INSERT INTO orderdtl SET " .
			"  orderix = {$this->orderix}, " .
			"  orderdtlix = {$this->orderdtlix}, " .
			"  itemix = {$this->itemix}, " .
			"  eventix = {$this->eventix}, " .
			"  action = '{$this->action}', " .
			"  qty = {$this->qty}, " .
			"  extamt = {$this->extamt}";
		dispsql($sql);
		$result = mysql_query($sql);
		$errno = mysql_errno();
		if ($errno == $ER_DUP_ENTRY) {
			$sql =
				"UPDATE orderdtl SET " .
				"    orderix = {$this->orderix}, " .
				"    orderdtlix = {$this->orderdtlix}, " .
				"    itemix = {$this->itemix}, " .
				"    eventix = {$this->eventix}, " .
				"    action = '{$this->action}', " .
				"    qty = {$this->qty}, " .
			    "    extamt = {$this->extamt} " .
				"  WHERE orderix = {$this->orderix} AND " .
				"    orderdtlix = {$this->orderdtlix}";
			dispsql($sql);
			$result = mysql_query($sql) or
				die("Error updating OrderDtl for orderix {$this->orderix}, orderdtlix {$this->orderdtlix}. " . mysql_error());

		} else {
			die("$errno: Error inserting OrderDtl for orderix {$this->orderix}, " .
				"orderdtlix {$this->orderdtlix}. " . mysql_error());
		}

		return mysql_affected_rows();
	}
}
