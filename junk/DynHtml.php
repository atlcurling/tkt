<?php

class DynHtml {

	public $header = '';
	public $rendered = '';

	public $leftRaw = '';
	public $rightRaw = '';
	public $bottomRaw = '';

	public $leftRendered = '';
	public $rightRendered = '';
	public $bottomRendered = '';

	function __construct($group = "unknown", $item = "unknown") {
#		$this->header = "$group: $item";
		$this->load($group, $item);
	}

	public function load($group, $item) {
		$this->header = "$group: $item";
	}

	public function render() {
		$this->leftRendered = $this->leftRaw;
		$this->rightRendered = $this->rightRaw;
		$this->bottomRendered = $this->bottomRaw;

		$this->rendered = "<h2>$this->header</h2>\n";
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
