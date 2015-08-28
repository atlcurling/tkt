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

	public function displayEditForm($readonly = 0, $submit = "Submit", $url = "", $cols = 60, $rows = 12) {
		$nl = chr(10);

		$ro = $readonly ? "readonly" : "";
		$halfCols = intval($cols/2) - 2;

		print "<form action='$url' method='post'>\n";

		print "<input type='hidden' name='ppagenm' value='$this->pagenm'>\n";
		print "<input type='hidden' name='pseq' value='$this->seq'>\n";

	// Header fields

		print "<table><tr><td><table>\n";
		print "<tr><td><label>pagenm</label></td><td><input type='text' name='pagenm' size=16 $ro value='$this->pagenm'>\n";
		print "<tr><td><label>seq</label></td><td><input type='text' name='seq' size=8 $ro value='$this->seq'>\n";


	// Detail fields
	// Try to height-limit the big text areas
		$r1 = min($rows, substr_count($this->leftRaw, $nl), substr_count($this->rightRaw, '\n'));
		$r2 = min($rows, substr_count($this->bottomRaw, $nl));

		print "</table></td></tr><tr><td><table>\n";

#		print "<tr><td><label>left</label></td><td><label>right</label></td></tr>\n";
		print "<tr><td><textarea cols=$halfCols rows=$r1 name='left' $ro>$this->leftRaw</textarea></td>";
		print "<td><textarea cols=$halfCols rows=$r1 name='right' $ro>$this->rightRaw</textarea></td></tr>";
#		print "<tr><td><label>bottom</label></td></tr>\n";
		print "<tr><td colspan=2><textarea cols=$cols rows=$r2 name='bottom' $ro>$this->bottomRaw</textarea></td></tr>\n";

	// Footer fields

		print "</table></td></tr><tr><td><table>\n";

		if ($submit) {
			print "<tr><td style='text-align: center;'>\n";
			if (is_array($submit)) {
				foreach ($submit as $i => $button) {
					if ($i > 0) print "&nbsp;";
					print "<input type='submit' name='$submit' value='$submit'>\n";
				}
			} else {
				print "<input type='submit' name='$submit' value='$submit'>\n";
			}
			print "</td></tr>\n";
		}
		print "</table></td></tr></table>\n";
		print "</form>\n";
	}
}
