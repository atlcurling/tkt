<?php

/* Allowed: prod, prodtest, staging */

$ENV = "prod";

switch ($ENV) {
	case "prod":
		$BASEURL = "http://atlcurling.org/";
		
		switch (substr_count($_SERVER["PHP_SELF"], "/")) {
			case 1: 
				$BASEDIR = "";
				$TKTDIR = "tkt0.2/";
				$IMGDIR = "image/";
				set_include_path(get_include_path() . ":skin:lib");
				break;

			case 2: 
				$BASEDIR = "../";
				$TKTDIR = "../tkt0.2/";
				$IMGDIR = "../image/";
				set_include_path(get_include_path() . ":..:../skin:../lib");
				break;
		}
		
		$PPbaseurl = "https://www.paypal.com";
		$PPbusiness = "atlcurling@gmail.com";

		$pricedivider = 1.00;

		$dbname = "atlcurli_reg";
		$dbuser = "atlcurli_root";
		$dbpasswd = "06lotsam";
		
		$debug = 0;

#		set_include_path(get_include_path() . ":skin:lib:../lib");
		break;
		
	case "prodtest":
		$BASEURL = "http://atlcurling.org/curling0.2/";
		$TKTDIR = "../tkt0.1/";
	
		$PPbaseurl = "https://www.paypal.com";
		$PPbusiness = "atlcurling@gmail.com";

		$pricedivider = 300.00;

		$dbname = "atlcurli_sreg";
		$dbuser = "atlcurli_root";
		$dbpasswd = "06lotsam";
		
		$debug = 1;
		break;
		
	case "staging":
		$BASEURL = "http://atlcurling.org/curling0.2/";
		$TKTDIR = "../tkt0.1/";
	
		$PPbaseurl = "https://www.sandbox.paypal.com";
		$PPbusiness = "seller_1325287622_biz@gmail.com";

		$pricedivider = 1.00;

		$dbname = "atlcurli_sreg";
		$dbuser = "atlcurli_root";
		$dbpasswd = "06lotsam";
		
		$debug = 1;
		break;
}

?>
