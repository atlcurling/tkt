<?php 

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");
	require_once("{$TKTDIR}bargraph.php");

	$user = User::getSession();
	$usernm = $user ? $user->usernm : "";
	$userix = $user ? $user->userix : "";
	$member = $user ? $user->member : false;

	loginprompt();

	dbconnect();
	
	$showold = getvalue("showold", 0);

/* Event table */

	echo "<h1>Event Status";
	if ($usernm) echo " - $usernm";
	echo "</h1>\n";
	
	if (! $member) warning("If you are a member you must not be logged in.");

/* Event query */

	$sql = 
		"SELECT eventix, eventnm, eventdt, capacity, mbrprice, guestprice\n" .
		"  FROM event e \n" .
		"  WHERE active " . ($showold ? "" : "AND eventdt >= CURDATE() ") . "\n" .
		"  ORDER BY eventdt";

	if ($debug > 1) dispsql($sql);

	$res = mysql_query($sql) 
		or die("Error during event select. " . mysql_error());

	echo "<form action='eventorder.php' method='post'>\n";
	if ($userix) echo "<input type='submit' name='action' value='Submit Order'>\n";

	$ix = 0;
	while ($row = mysql_fetch_assoc($res)) {
		$eventix = $row['eventix'];
		$eventnm = $row['eventnm'];
		$eventdt = $row['eventdt'];
		$capacity = $row['capacity'];
		$mbrprice = $row['mbrprice'];
		$guestprice = $row['guestprice'];

	/* Get reservation counts */

		$reserved = dbgetsingleton(
			"SELECT COUNT(*) reserved " .
			"  FROM registration " . 
			"  WHERE eventix = $eventix " .
			"    AND NOT waiting " .
			"    AND releasetime IS NULL", 
			"reserved");
		$released = dbgetsingleton(
			"SELECT COUNT(*) released " .
			"  FROM registration " .
			"  WHERE eventix = $eventix " .
			"    AND NOT waiting " .
			"    AND releasetime IS NOT NULL",
			"released");
		$openings = $capacity - $reserved;

		$waiting = dbgetsingleton(
			"SELECT COUNT(*) waiting " .
			"  FROM registration " .
			"  WHERE eventix = $eventix AND waiting", 
			"waiting");

	/* Get personal reservation counts */

		if ($usernm) {
			$myreserved = dbgetsingleton(
				"SELECT COUNT(*) myreserved " .
				"  FROM registration " .
				"  WHERE eventix = $eventix " .
				"    AND NOT waiting " .
				"    AND userix = $userix " .
				"    AND releasetime IS NULL",
				"myreserved");

			$myreleased = dbgetsingleton(
				"SELECT COUNT(*) myreleased " .
				"  FROM registration " .
				"  WHERE eventix = $eventix " .
				"    AND NOT waiting " .
				"    AND userix = $userix " .
				"    AND releasetime IS NOT NULL",
				"myreleased");

			if ($waiting) {
				$mywaiting = dbgetsingleton(
					"SELECT COUNT(*) mywaiting " .
					"  FROM registration " .
					"  WHERE eventix = $eventix AND waiting AND userix = $userix",
					"mywaiting");
			}
		} else {
			$myreserved = 0;
			$mywaiting = 0;
		}

	/* Put out one event section */

		$price = $member ? $mbrprice : $guestprice;
		printf("<h3>%s - %s &nbsp; (Reservations: $%.2f)</h3>\n", $eventnm, $eventdt, $price / $pricedivider);
		if (! $member) warning(sprintf("If you were a member this reservation would only cost $%.2f.", $mbrprice));

		echo "<table width=100%>\n";
		echo "<tr><td width=50%>\n";

	/* Entire event counts */

		echo "<table><tr>\n";
		echo "<td align=left>Reserved: $reserved</td>\n";
		echo "<td align=center>Released: $released</td>\n";
	   	echo "<td align=right>Openings: $openings</td>\n";

	/* Bar graph */

		echo "</tr><tr>\n";
		echo "<td colspan=3>";
		bargraph2($reserved, "red", $released, "yellow", $capacity, "white", 12);
		echo "</td>";

	/* Add or waiting list control */

		if ($userix)
			if ($openings) {
				echo "<td>";
				echo "Reserve";
				echo "</td>";
				echo "<td>";
				echo "<select name='add$ix'>";
				for ($i = 0; $i <= $openings; $i ++)
					echo "<option>$i</option>";
				echo "</select>\n";
				echo "</td>\n";
			} else {
				echo "<td>";
				echo "Add to Waiting List";
				echo "</td>";
				echo "<td>";
				echo "<select name='addwait$ix'>";
				for ($i = 0; $i <= $capacity; $i ++)
					echo "<option>$i</option>";
				echo "</select>\n";
				echo "</td>\n";
			}
		   	   
	/* Personal event counts */

		echo "</tr><tr>\n";
		echo "<td colspan=3>";
		if ($userix) {
			echo "You have $myreserved reservation" . 
			   ($myreserved != 1 ? "s" : "") . " for this event.";
		}
		echo "</td>";

	/* Release control */

		echo "<td>";
		if ($myreserved) echo "Release";
		echo "</td><td>";
		if ($myreserved) {
			echo "<select name='remove$ix'>";
			for ($i = 0; $i <= $myreserved; $i ++)
				echo "<option>$i</option>";
			echo "</select>\n";
		}
		echo "</td>\n";
		echo "</tr></table>\n";

	/* Waiting list */

		echo "</td><td width=50%>\n";

		if ($waiting) {

		/* Entire event count */

			echo "<table><tr>\n";
			echo "<td>Waiting: $waiting</td>";

		/* Bar graph */

			echo "</tr><tr>\n";
			echo "<td>";
			bargraph($waiting, "green");
			echo "</td>\n";

		/* Personal count */

			echo "</tr><tr>\n";
			echo "<td>";
			if ($userix) {
				echo "You are on the waiting list $mywaiting time" .
					($mywaiting != 1 ? "s" : "") . ".";
			}
			echo "&nbsp;</td>\n";
			echo "</tr></table>\n";
			echo "\n";
		}

		echo "</td>\n";
		echo "</tr></table>\n";

	/* Per-event data */

		echo "<input type='hidden' name='eventix$ix' value='$eventix'>\n";
		echo "<input type='hidden' name='eventnm$ix' value='$eventnm'>\n";
		echo "<input type='hidden' name='eventdt$ix' value='$eventdt'>\n";
		echo "<input type='hidden' name='price$ix' value='$price'>\n";

		$ix ++;
	}

/* Values to pass and submit button */

	echo "<input type='hidden' name='usernm' value='$usernm'>\n";
	echo "<input type='hidden' name='userix' value='$userix'>\n";
	if ($userix) echo "<input type='submit' name='action' value='Submit Order'>\n";

	echo "</form>\n";

?>

</body>
</html>

