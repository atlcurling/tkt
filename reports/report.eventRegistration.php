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
		$eventix = getvalue("eventix", 0);
		
		$totadm = 0.00;
		
		dbconnect();

	# Heading section

		$sql =
			"SELECT e.* FROM event e WHERE e.eventix = $eventix";
			
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());
			
		$row = mysql_fetch_object($result);
		echo "<h3>Event $row->eventix - $row->eventnm - $row->eventdt</h3>\n";
		
		echo "<table width='100%'><tr><td style='width: 33%;'>\n";
		printf("<table style='border: solid 1px black; width: 100%%;'><tr><td>%s</td></tr></table>\n", $row->description);
		
		$fmt = "<tr><td>%s</td><td>%s</td></tr>\n";

		echo "</td><td style='width: 33%'>\n";
		echo "<table style='border: solid 1px black; width: 100%;'>\n";
		printf($fmt, "Volunteer Call Time", $row->calltm);
		printf($fmt, "Advertised Start Time", $row->advstarttm);
		printf($fmt, "Ice Time Start", $row->icetm);
		printf($fmt, "Tear Down Time", $row->teardowntm);
		echo "</table>\n";
		
		echo "</td><td style='width: 34%'>\n";
		echo "<table style='border: solid 1px black; width: 100%;'>\n";
		printf($fmt, "Event Capacity", $row->capacity);
		printf($fmt, "Member Price", $row->mbrprice);
		printf($fmt, "Non-Member Price", $row->guestprice);
		echo "</table>\n";
		
		$capacity = $row->capacity;
		
		echo "</td></tr></table>\n";

	# Reservation section
		
		$sql =
			"SELECT r.addorderix, r.ordertime, d.extamt / d.qty amt, CONCAT(u.firstnm, ' ', u.lastnm) nm, u.usernm, u.phonenbr " .
			"  FROM registration r " .
			"    JOIN orderdtl d ON (r.addorderix = d.orderix AND d.eventix = $eventix) " .
			"    JOIN user u ON (r.userix = u.userix) " .
			"  WHERE r.eventix = $eventix " .
			"    AND r.releasetime IS NULL " .
			"    AND NOT r.waiting " .
			"  ORDER BY u.lastnm, u.firstnm";
			
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());
			
		$line = 0;
		echo "<table border=1>\n";
		echo "<tr>";
		echo "<th style='width: 2em'>Line</th>";
		echo "<th style='width: 2em'>Order</th>";
		echo "<th style='width: 4em'>Amount</th>";
		echo "<th style='width: 12em'>Name</th>";
		echo "<th style='width: 10em'>Order Time</th>";
		echo "<th style='width: 18em'>E-mail</th>";
		echo "<th style='width: 10em'>Phone</th>";
		echo "</tr>\n";

		$dfmt = "<td style='text-align: center'>%d</td>";
		$ffmt = "<td style='text-align: center'>$%.2f</td>";
		$sfmt = "<td>%s</td>";
		
		while ($row = mysql_fetch_object($result)) {
			echo "<tr style='height: 2.3em;'>";
			printf($dfmt, ++$line);
			printf($dfmt, $row->addorderix);
			printf($ffmt, $row->amt);
			printf($sfmt, $row->nm);
			printf($sfmt, $row->ordertime);
			printf($sfmt, $row->usernm);
			printf($sfmt, $row->phonenbr);
			echo "</tr>\n";
			
			$totadm += $row->amt;
		}
		
		while ($line < $capacity) {
			echo "<tr style='height: 2.3em;'>";
			printf($dfmt, ++$line);
			printf($sfmt, "");
			printf($sfmt, "");
			printf($sfmt, "");
			printf($sfmt, "");
			printf($sfmt, "");
			echo "</tr>\n";
		}
		
		echo "</table>\n";

	# Released reservations section


		$sql =
			"SELECT r.addorderix, r.releasetime, d.extamt / d.qty amt, CONCAT(u.firstnm, ' ', u.lastnm) nm, u.usernm, u.phonenbr " .
			"  FROM registration r " .
			"    JOIN orderdtl d ON (r.addorderix = d.orderix AND d.eventix = $eventix) " .
			"    JOIN user u ON (r.userix = u.userix) " .
			"  WHERE r.eventix = $eventix " .
			"    AND r.releasetime IS NOT NULL " .
			"    AND NOT r.waiting " .
			"  ORDER BY u.lastnm, u.firstnm";
			
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());
			
		
		if (mysql_num_rows($result) > 0) {
			echo "<h3>Released Reservations</h3>\n";

			$line = 0;
			echo "<table border=1>\n";
			echo "<tr>";
			echo "<th style='width: 2em'>Line</th>";
			echo "<th style='width: 2em'>Order</th>";
			echo "<th style='width: 4em'>Amount</th>";
			echo "<th style='width: 12em'>Name</th>";
			echo "<th style='width: 10em'>Release Time</th>";
			echo "<th style='width: 18em'>E-mail</th>";
			echo "<th style='width: 10em'>Phone</th>";
			echo "</tr>\n";

			$dfmt = "<td style='text-align: center'>%d</td>";
			$ffmt = "<td style='text-align: center'>$%.2f</td>";
			$sfmt = "<td>%s</td>";

			while ($row = mysql_fetch_object($result)) {
				echo "<tr style='height: 2.3em;'>";
				printf($dfmt, ++$line);
				printf($dfmt, $row->addorderix);
				printf($ffmt, $row->amt);
				printf($sfmt, $row->nm);
				printf($sfmt, $row->releasetime);
				printf($sfmt, $row->usernm);
				printf($sfmt, $row->phonenbr);
				echo "</tr>\n";
			}

			echo "</table>\n";
		}

	# Waiting list section
		
		$sql =
			"SELECT r.addorderix, r.ordertime, d.extamt / d.qty amt, CONCAT(u.firstnm, ' ', u.lastnm) nm, u.usernm, u.phonenbr " .
			"  FROM registration r " .
			"    JOIN orderdtl d ON (r.addorderix = d.orderix AND d.eventix = $eventix) " .
			"    JOIN user u ON (r.userix = u.userix) " .
			"  WHERE r.eventix = $eventix " .
			"    AND r.waiting " .
			"  ORDER BY u.lastnm, u.firstnm";
			
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());
			
		if (mysql_num_rows($result) > 0) {
			echo "<h3>Waiting List</h3>\n";
				
			$line = 0;
			echo "<table border=1>\n";
			echo "<tr>";
			echo "<th style='width: 2em'>Line</th>";
			echo "<th style='width: 2em'>Order</th>";
			echo "<th style='width: 4em'>Amount</th>";
			echo "<th style='width: 12em'>Name</th>";
			echo "<th style='width: 10em'>Wait List Time</th>";
			echo "<th style='width: 18em'>E-mail</th>";
			echo "<th style='width: 10em'>Phone</th>";
			echo "</tr>\n";
	
			while ($row = mysql_fetch_object($result)) {
				echo "<tr style='height: 2.3em;'>";
				printf($dfmt, ++$line);
				printf($dfmt, $row->addorderix);
				printf($sfmt, "WAIT");
				printf($sfmt, $row->nm);
				printf($sfmt, $row->ordertime);
				printf($sfmt, $row->usernm);
				printf($sfmt, $row->phonenbr);
				echo "</tr>\n";
			
				$totadm += $row->amt;
			}
		}
		
		echo "</table>\n";
		
		printf("Total admissions received: $%.2f<br/>\n", $totadm);
	
	} else {

		echo "<h2>Access to reports is limited to administrators.</h2>\n";

	}

	echo "</div><!-- colmask leftmenu -->\n";
	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
