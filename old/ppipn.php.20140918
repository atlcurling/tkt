<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PayPal IPN</title>
</head>

<?php

require_once("settings.php");
require_once("{$TKTDIR}functions.php");
require_once("{$TKTDIR}database.php");
require_once("{$TKTDIR}xactlog.php");
require_once("{$TKTDIR}order.php");

dbconnect();

$x = new XactLog();
$order = new Order();

$ipn = $_POST;

$orderix = postvalue("invoice", NULL);
$userix = NULL;
if ($orderix) {
	$order->loadByOrderIx($orderix);
	$userix = $order->userix;
	if ($userix) $usernm = dbgetsingleton("SELECT usernm FROM user WHERE userix = $userix", "usernm");
}

$x->log("PP IPN Notificaton", "Unvalidated PP Notification", $userix, $orderix, NULL, print_r($_POST, true));

/* Form the response */

if (array_key_exists("test_ipn", $_POST) && $_POST["test_ipn"] == 1) {
	$ppurl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$ppurl = "https://www.paypal.com/cgi-bin/webscr";	
}

$request = curl_init();
curl_setopt_array($request, array (
	CURLOPT_URL => $ppurl,
	CURLOPT_POST => TRUE,
	CURLOPT_POSTFIELDS => http_build_query(array("cmd" => "_notify-validate") + $_POST),
	CURLOPT_RETURNTRANSFER => TRUE,
	CURLOPT_HEADER => FALSE,
	CURLOPT_SSL_VERIFYPEER => TRUE
));

/* Send the response */

$response = curl_exec($request);
$status = curl_getinfo($request, CURLINFO_HTTP_CODE);
curl_close($request);

if ($status == 200 && $response == "VERIFIED") {
	$x->log("PP IPN Verified", "PP IPN Verification Succeeded", $userix, $orderix, NULL, print_r($_POST, true));
	
/* Record approval */

	$order->setPmtAprTime();
	
/* Apply changes to registration */
			
	$sql =
		"SELECT orderdtlix, itemix, eventix, action, qty \n" .
		"  FROM orderdtl \n" .
		"  WHERE orderix = $orderix \n" .
		"  ORDER BY orderdtlix";

	dispsql($sql);

	$res = mysql_query($sql) or
		die("Error during orderdtl select. " . mysql_error());

	while ($row = mysql_fetch_assoc($res)) {
		$orderdtlix = $row["orderdtlix"];
		$itemix = $row["itemix"];
		$eventix = $row["eventix"];
		$action = $row["action"];
		$qty = $row["qty"];

		switch ($action) {
		/* Process adds */
			case "A":
			/* Process adds - take from this user's previously released reservations */

				if ($debug) echo "Looking for released reservations from this user for eventix $eventix, userix $userix, quantity $qty.<br/>";
				$sql = 
					"UPDATE registration SET \n" .
					"    userix = $userix, \n" .
					"    addorderix = $orderix, \n" .
					"    ordertime = CURRENT_TIMESTAMP, \n" .
					"    releasetime = NULL \n" .
					"  WHERE eventix = $eventix \n" .
					"    AND userix = $userix \n" .
					"    AND NOT waiting \n" .
					"    AND releasetime IS NOT NULL \n" .
					"  ORDER BY releasetime \n" .
					"  LIMIT $qty";
				dispsql($sql);

				$res2 = mysql_query($sql) or
					die("Error during update 1. " . mysql_error());

				$rows = mysql_affected_rows();
				if ($debug) echo $rows . " row" . ($rows != 1 ? "s" : "") . " updated.<br/>\n";

				if ($rows) {
					$sql =
						"DELETE FROM registration \n" .
						"  WHERE eventix = $eventix \n" .
						"    AND userix = $userix \n" .
						"    AND waiting \n" .
						"  LIMIT $rows";
					dispsql($sql);
					$res2 = mysql_query($sql) or
						die("Error during delete 1. " . mysql_error());
					$rows2 = mysql_affected_rows();
					if ($debug) echo $rows . " row" . ($rows != 1 ? "s" : "") . " updated.<br/>\n";

					$x->log("Reservations Self Reclaimed",
						"Order $orderix for $usernm reclaimed $rows2 previously released reservations by them for event $eventix.",
						$userix, $orderix, $eventix);
				}

			/* Process adds - taken from openings */
	
				$qty -= $rows;
				$rows = 0;
				if ($qty) {
					if ($debug) echo "Processing add for eventix $eventix, userix $userix, quantity $qty.<br/>\n";
					$sql = "INSERT INTO registration (eventix, userix, addorderix, waiting, ordertime) VALUES \n ";
					$values = "";
					for ($i = 0; $i < $qty; $i ++) $values .= ",\n ($eventix, $userix, $orderix, 0, CURRENT_TIMESTAMP)";
					if ($values) {
						$values = substr($values, 3);
						$sql .= $values;
	
						dispsql($sql);
	
						$res2 = mysql_query($sql) or
							die("Error during insert. " . mysql_error());
	
						$rows = mysql_affected_rows();
						if ($debug) echo $rows . " row" . ($rows != 1 ? "s" : "") . " inserted.<br/>";
	
						$x->log("Reservations Added", 
							"Order $orderix for $usernm added $rows reservations for event $eventix.",
							$userix, $orderix, $eventix);
					}
				}
	
			/* Process adds - taken from released reservations */
	
				$qty -= $rows;
				$rows = 0;
				if ($qty) {
					if ($debug) echo "Looking for released reservations for eventix $eventix, userix $userix, quantity $qty.<br/>\n";
					$sql = 
						"UPDATE registration SET \n" .
						"    userix = $userix, \n" .
						"    addorderix = $orderix, \n" .
						"    ordertime = CURRENT_TIMESTAMP, \n" .
						"    releasetime = NULL \n" .
						"  WHERE NOT waiting \n" .
						"    AND releasetime IS NOT NULL \n" .
						"  ORDER BY releasetime \n" .
						"  LIMIT $qty";
	
					dispsql($sql);
	
					$res2 = mysql_query($sql) or
						die("Error during update 2. " . mysql_error());
	
					$rows = mysql_affected_rows();
					if ($debug) echo $rows . " row" . ($rows != 1 ? "s" : "") . " updated.<br/>";
					if ($rows) {
						$sql =
							"DELETE FROM registration \n" .
							"  WHERE eventix = $eventix \n" .
							"    AND userix = $userix \n" .
							"    AND waiting \n" .
							"  LIMIT $rows";
						dispsql($sql);
						$res2 = mysql_query($sql) or
							die("Error during delete 2. " . mysql_error());
						$rows2 = mysql_affected_rows();
						if ($debug) echo $rows . " row" . ($rows != 1 ? "s" : "") . " updated.<br/>\n";
	
						$x->log("Reservations Reclaimed",
							"Order $orderix for $usernm reclaimed $rows reservations for event $eventix.",
							$userix, $orderix, $eventix);
					}
				}
	
				break;
		}
	}
} else {
	$x->log("PP INP Failed", "PP IPN Verification Failed - status: $status, response: $response", 
		$userix, $orderix, NULL, print_r($_POST, true));
}
?>


<body>
</body>
</html>
