<?php

class DynPage {

	public $title = '';

	public $introRaw = '';
	public $introRendered = '';

	function __construct($page = "unknown") {
#		$this->title = "Atlanta Curling Club: $page";
		$this->load($page);
	}

	public function load($page) {
		$this->title = "Atlanta Curling Club: $page";
	}

	public function render() {
		$this->introRendered = $this->introRaw;

		$this->rendered = "<h1>$this->title</h1>\n";
		$this->rendered .= "<div class='my_wrapper'>\n";
		$this->rendered .= "<div class='my_footer'>$this->introRendered</div>\n";
		$this->rendered .= "</div>\n";
		return $this->rendered;
	}

	public function display() {
		if (! $this->rendered) $this->render();
		print $this->rendered;
	}
}
