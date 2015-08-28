<?php

/* Allowed: prod, prodtest, staging */

$ENV = "prodtest";

switch ($ENV) {
	case "prod":
		$BASEURL = "http://atlcurling.org/";
		$TKTDIR = "tkt0.1/";
		
		$PPbaseurl = "https://www.paypal.com";
		$PPbusiness = "atlcurling@gmail.com";

		$pricedivider = 1.00;

		$dbname = "atlcurli_reg";
		$dbuser = "atlcurli_root";
		$dbpasswd = "06lotsam";
		
		$debug = 1;
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