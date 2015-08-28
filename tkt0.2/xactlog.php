<?php

class XactLog {
	public $xacttime;
	public $xactix;
	public $userix;
	public $orderix;
	public $eventix;
	public $xacttype;
	public $description;
	public $detail;

	public function __construct() {
	}

	public function log($xacttype, $description = NULL, $userix = NULL, $orderix = NULL, $eventix = NULL, $detail = NULL) {
		$this->description = NULL;
		$this->userix = NULL;
		$this->orderix = NULL;
		$this->eventix = NULL;
		$this->detail = NULL;
		$this->logex($xacttype, $description, $userix, $orderix, $eventix, $detail);
	}

	public function logex($xacttype, $description = NULL, $userix = NULL, $orderix = NULL, $eventix = NULL, $detail = NULL) {

		global $debug;

		$this->xacttype = $xacttype;
		if ($description) $this->description = $description;
		if ($userix) $this->userix = $userix;
		if ($orderix) $this->orderix = $orderix;
		if ($eventix) $this->eventix = $eventix;
		if ($detail) $this->detail = $detail;

		$sql =
			"INSERT INTO xactlog SET " .
			"xacttype = '$xacttype', ";

		if ($description) $sql .= "  description = '$description', ";
		if ($userix) $sql .= "  userix = $userix, ";
		if ($orderix) $sql .= "  orderix = $orderix, ";
		if ($eventix) $sql .= "  eventix = $eventix, ";
		if ($detail) $sql .= "  detail = '$detail', ";

		$sql = substr($sql, 0, strlen($sql) - 2);

		if ($debug > 1) dispsql($sql);

		$result = mysql_query($sql)
			or die("Error logging to xactlog. " . mysql_error());

		$this->xactix = mysql_insert_id();
		$this->xacttime = dbgetsingleton(
			"SELECT xacttime FROM xactlog WHERE xactix = {$this->xactix}",
			"xacttime");

		if ($debug > 1) {
			echo "<pre>";
			print_r($this);
			echo "</pre>\n";
		}
	}

}

