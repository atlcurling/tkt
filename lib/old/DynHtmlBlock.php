<?php

class DynHtmlBlock {

	public $pagenm = '';
	public $seq = 0;

	public $header = '';
	public $rendered = '';

	public $leftRaw = '';
	public $rightRaw = '';
	public $bottomRaw = '';

	public $leftRendered = '';
	public $rightRendered = '';
	public $bottomRendered = '';

	function __construct($pagenm = "unknown", $seq = 0, $header, $left, $right, $bottom) {
		$this->init($pagenm, $seq, $header, $left, $right, $bottom);
	}

	public function init($pagenm, $seq, $header, $left, $right, $bottom) {
		$this->pagenm = $pagenm;
		$this->seq = $seq;
		$this->header = $header;
		$this->leftRaw = $left;
		$this->rightRaw = $right;
		$this->bottomRaw = $bottom;
	}

	public function load($pagenm, $seq) {
		$apagenm = $pagenm ? $pagenm : $this->pagenm;
		$aseq = $seq ? $seq : $this->seq;

		$sql = "SELECT b.header, b.left, b.right, b.bottom " .
			"FROM block b " .
			"WHERE pagenm = '$apagenm' AND seq = $aseq;";
		$result = mysql_query($sql) or die("load() failed. " . mysql_error());
		$row = mysql_fetch_object($result);

		$this->header = $row->header;
		$this->leftRaw = $row->left;
		$this->rightRaw = $row->right;
		$this->bottomRaw = $row->bottom;

		mysql_free_result($result);
	}

	public function save() {
	}

	public function render() {
		$this->leftRendered = $this->leftRaw;
		$this->rightRendered = $this->rightRaw;
		$this->bottomRendered = $this->bottomRaw;

		$this->rendered = "";
		if ($this->header) $this->rendered .= "<h2>$this->header</h2>\n";
		$this->rendered .= "<div class='my_wrapper'>\n";
		$this->rendered .= "<div class='my_left_box'>$this->leftRendered</div>\n";
		$this->rendered .= "<div class='my_right_box'>$this->rightRendered</div>\n";
		$this->rendered .= "<div class='my_footer'>$this->bottomRendered</div>\n";
		$this->rendered .= "</div>\n";
		return $this->rendered;
	}

	public function display() {
		if (! $this->rendered) $this->render();
		print $this->rendered;
	}
}
