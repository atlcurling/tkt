<?php

require_once("{$TKTDIR}orderdtl.php");

class Order {
	public $orderix;
	public $crtime;
	public $pmtaprtime;
	public $pmtrejtime;
	public $pmtrecvtime;
	public $userix;
	public $totalamt;
	public $dtl;

	public function __construct() {
		$orderix = 0;
		$crtime = 0;
		$publicaprtime = 0;
		$pmtrejtime = 0;
		$pmtrecvtime = 0;
		$userix = 0;
		$totalamt = 0.00;
		$dtl = array();
	}

	public function loadByOrderIx($orderix) {
		$sql = 
			"SELECT orderix, crtime, pmtaprtime, pmtrejtime, pmtrecvtime, userix, totalamt " .
			"  FROM orderhdr " .
			"  WHERE orderix = $orderix";
		dispsql($sql);
		$result = mysql_query($sql) or
			die("Error loading Order for orderix $orderix. " . mysql_error());
		$o = mysql_fetch_object($result, "Order");

		foreach($o as $key => $value) $this->{$key} = $o->{$key};
	}

	public function load($orderix) {
		$this->loadByOrderIx($orderix);

		$result = OrderDtl::select($orderix);
		while ($o = mysql_fetch_object($result, "OrderDtl")) {
			$this->dtl[$o->orderdtlix] = $o;
		}
	}

	public function save() {
		$ER_DUP_ENTRY = 1062;

		$sql =
			"INSERT INTO orderhdr SET " .
			"  orderix = {$this->orderix}, " .
			"  crtime = {$this->crtime}, " .
			"  pmtaprtime = {$this->pmtaprtime}, " .
			"  pmtrejtime = {$this->pmtrejtime}, " .
			"  pmtrecvtime = {$this->pmtrecvtime}, " .
			"  userix = {$this->userix}, " .
			"  totalamt = {$this->totalamt}";
		dispsql($sql);
		$result = mysql_query($sql);
		$errno = mysql_errno();
		if ($errno == $ER_DUP_ENTRY) {
			$sql =
				"UPDATE orderhdr SET " .
				"    orderix = {$this->orderix}, " .
				"    crtime = {$this->crtime}, " .
				"    pmtaprtime = {$this->pmtaprtime}, " .
				"    pmtrejtime = {$this->pmtrejtime}, " .
				"    pmtrecvtime = {$this->pmtrecvtime}, " .
				"    userix = {$this->userix} " .
				"    totalamt = {$this->totalamt} " .
				"  WHERE orderix = $orderix";
			dispsql($sql);
			$result = mysql_query($sql) or
				die("Error updating Order for orderix {$this->orderix}. " . mysql_error());
		} else {
			die("$errno: Error inserting Order for orderix {$this->orderix}. " . mysql_error());
		}

	/* Save details */

		foreach ($this->dtl as $key) {
			$this->dtl[$key]->save();
		}

		return mysql_affected_rows();
	}

	public function createOrderIx($userix) {
		global $debug;
		
		$sql =
			"INSERT INTO orderhdr SET \n" .
			"  userix = $userix";
		if ($debug > 1) dispsql($sql);
		$result = mysql_query($sql)
			or die("Error during Order insert. " . mysql_error());

		$this->orderix = mysql_insert_id();

		return $this->orderix;
	}

	public function setTotalAmt($totalamt) {
		global $debug;
		
		$this->totalamt = $totalamt;
		$sql =
			"UPDATE orderhdr SET \n" .
			"    totalamt = $totalamt \n" .
			"  WHERE orderix = {$this->orderix}";
		if ($debug > 1) dispsql($sql);
		$result = mysql_query($sql)
			or die("Error updating Order total amount. " . mysql_error());
	}

	public function setPmtAprTime() {
		$sql =
			"UPDATE orderhdr SET \n" .
			"  pmtaprtime = CURRENT_TIMESTAMP \n" .
			"  WHERE orderix = {$this->orderix}";
		dispsql($sql);
		$result = mysql_query($sql)
			or die("Error updating Order payment approval timestamp. " . mysql_error());

		$this->pmtaprtime = dbgetsingleton(
			"SELECT pmtaprtime FROM orderhdr WHERE orderix = {$this->orderix}",
			"pmtaprtime");

		return $this->pmtaprtime;
	}

	public function setPmtRejTime() {
		$sql =
			"UPDATE orderhdr SET \n" .
			"  pmtrejtime = CURRENT_TIMESTAMP \n" .
			"  WHERE orderix = {$this->orderix}";
		dispsql($sql);
		$result = mysql_query($sql)
			or die("Error updating Order payment rejection timestamp. " . mysql_error());

		$this->pmtrejtime = dbgetsingleton(
			"SELECT pmtrejtime FROM orderhdr WHERE orderix = {$this->orderix}",
			"pmtrejtime");

		return $this->pmtrejtime;
	}
}
