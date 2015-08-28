<?php

	require_once("../settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('../include.php');

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

	require_once("DynHtmlPage2.php");
	require_once("DynHtmlBlock.php");

	$pageName = "Report - Event Registration";
	$debug = 0;

	DynHtmlPage::docHeader($pageName);
	DynHtmlPage::header();

	echo "<div class='colmask leftmenu'>\n";

	dbconnect();

# Report logic

	if (User::isAdmin()) {
		$sql = 
			"SELECT CONCAT(u.firstnm, ' ', u.lastnm) nm, u.usernm, u.phonenbr, " .
			"    o.orderix, o.crtime, o.pmtaprtime, o.pmtrejtime, o.pmtrecvtime, o.userix, o.totalamt, " .
			"    d.orderdtlix, d.eventix, d.action, d.qty, d.extamt, e.eventnm, e.eventdt " .
			"  FROM orderhdr o " .
			"    JOIN orderdtl d ON o.orderix = d.orderix " .
			"    JOIN user u ON o.userix = u.userix " .
			"    JOIN event e ON d.eventix = e.eventix " .
			"  ORDER BY u.firstnm, u.lastnm, o.orderix, d.orderdtlix";
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());

		$debugreport = 0;
		if (! $debugreport) {
			$puserix = 0;
			$porderix = 0;
			while ($row = mysql_fetch_assoc($result)) {
			
				if ($row["orderix"] != $porderix) {
					if ($intable) {
						echo "</table>\n";
						$intable = 0;
					}
				}
			
				if ($row["userix"] != $puserix) {
					printf("<h4>%s - %s - %s</h4>\n", $row["nm"], $row["usernm"], $row["phonenbr"]);
					$puserix = $row["userix"];
					$porderix = 0;
				}
				
				if ($row["orderix"] != $porderix) {
					printf("<h5>Order %s - $%.2f</h5>\n", $row["orderix"], $row["totalamt"]);
					echo "<ul>";
					printf("<li>Order creation time: %s</li>\n", $row["crtime"]);
					if ($row["pmtaprtime"]) printf("<li>Payment approval time: %s</li>\n", $row["pmtaprtime"]);
					if ($row["pmtrejtime"]) printf("<li>Payment rejection time: %s</li>\n", $row["pmtrejtime"]);
					if ($row["pmtrecvtime"]) printf("<li>Payment received time: %s</li>\n", $row["pmtrecvtime"]);
					
					$orderstatus = "Abandoned";
					if ($row["pmtaprtime"]) $orderstatus = "Approved";
					if ($row["pmtrejtime"]) $orderstatus = "Rejected";

					printf("<li>Order summary: %s</li>\n", $orderstatus);
					echo "</ul>";

					if ($orderstatus == "Approved") {					
						echo "<table border=1>";
						echo "<tr><th>Line</th><th>Event</th><th>Event Date</th><th>Action</th><th>Qty</th><th>Ext. Amt.</th></tr>\n";
						$intable = 1;
					}

					$porderix = $row["orderix"];
				}
				
				if ($orderstatus == "Approved") {
					printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>$%.2f</td></tr>\n", 
						$row["orderdtlix"],
						$row["eventnm"],
						$row["eventdt"],
						$row["action"],
						$row["qty"],
						$row["extamt"]);
				}
			}
			
			if ($intable) echo "</table>\n";
		} else {
			echo "<table border=1>\n";
			while ($row = mysql_fetch_assoc($result)) {
				disprowvert($row);
				echo "<tr><td colspan=2><hr/></td></tr>\n";
			}
			echo "</table>\n";
		}		
	
	} else {

		echo "<h2>Access to reports is limited to administrators.</h2>\n";

	}

	echo "</div><!-- colmask leftmenu -->\n";
	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
