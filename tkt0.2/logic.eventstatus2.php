<?php 

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");
	require_once("{$TKTDIR}bargraph.php");

	function printResvPrice($member, $mbrprice, $guestprice) {
		if ($mbrprice != $guestprice) {
			if ($member) {
				printf("<strong>Member reservations: $%2.2f</strong>\n", $mbrprice);
			} else {
				printf("<strong>Non-member reservations: $%.2f</strong> (members pay only $%.2f)\n", $guestprice, $mbrprice);
			}
		} else {
			printf("<strong>Reservations: $%.2f</strong>\n", $guestprice);
		}
	}

	$user = User::getSession();
	$usernm = $user ? $user->usernm : "";
	$userix = $user ? $user->userix : "";
	$member = $user ? $user->member : false;

	loginprompt();

	dbconnect();
	
	$showOld = getvalue("showOld", 0);
	$showInactive = getvalue("showInactive", 0);
	$eventMask = getvalue("eventMask", 0);

/* Event table */

	echo "<h1>Event Status";
	if ($usernm) echo " - $usernm";
	echo "</h1>\n";
	
	if (! $member) warning("If you are a member you must not be logged in.");

/* Event query */

	$whereClause = "WHERE 1";
	if (! $showInactive) $whereClause .= " AND e.active";
	if (! $showOld) $whereClause .= " AND e.eventdt >= CURDATE()";
	if ($eventMask) $whereClause .= " AND e.eventcd LIKE '$eventMask'";

	$userix += 0;

$sql = <<<EOQ
SELECT e.eventix, e.eventcd, e.eventgrouped, e.eventnm, e.longDescription, e.advstarttm, 
	eventdt, advstarttm,
	DATE_FORMAT(e.eventdt, '%a %b %e, %Y') fmteventdt,
	TIME_FORMAT(e.advstarttm, '%l:%i %p') fmtadvstarttm,
    e.capacity, e.mbrprice, e.guestprice,
    (SELECT COUNT(*) 
      FROM registration r 
      WHERE NOT r.waiting 
        AND r.eventix = e.eventix 
        AND r.releasetime IS NULL)
    AS reserved,
    (SELECT COUNT(*) 
      FROM registration r 
      WHERE NOT r.waiting 
        AND r.eventix = e.eventix 
		AND r.userix = $userix
        AND r.releasetime IS NULL)
    AS myreserved,
    (SELECT COUNT(*) FROM registration r 
      WHERE NOT r.waiting 
        AND r.eventix = e.eventix 
        AND r.releasetime IS NOT NULL)
    AS released,
    (SELECT COUNT(*) FROM registration r 
      WHERE NOT r.waiting 
        AND r.eventix = e.eventix 
		AND r.userix = $userix
        AND r.releasetime IS NOT NULL)
    AS myreleased,
    (SELECT COUNT(*) FROM registration r 
      WHERE r.waiting 
        AND r.eventix = e.eventix) 
    AS waiting,
    (SELECT COUNT(*) FROM registration r 
      WHERE r.waiting 
        AND r.eventix = e.eventix 
		AND r.userix = $userix)
    AS mywaiting
  FROM event e
  $whereClause
  GROUP BY e.eventdt, e.advstarttm, e.eventcd
  ORDER BY e.eventdt, e.advstarttm, e.eventcd
EOQ;

	if ($debug > 1) dispsql($sql);

	$res = mysql_query($sql) 
		or die("Error during event select. " . mysql_error());

	echo "<form action='eventorder.php' method='post'>\n";
	if ($userix) echo "<input type='submit' name='action' value='Submit Order'>\n";

	$ix = 0;
	$preveventcdpfx = '';

	while ($row = mysql_fetch_object($res)) {

		$openings = max($row->capacity - $row->reserved, 0);

	/* Get personal reservation counts */

		if ($usernm) {
			$myreserved = dbgetsingleton(
				"SELECT COUNT(*) myreserved " .
				"  FROM registration " .
				"  WHERE eventix = $row->eventix " .
				"    AND NOT waiting " .
				"    AND userix = $userix " .
				"    AND releasetime IS NULL",
				"myreserved");

			$myreleased = dbgetsingleton(
				"SELECT COUNT(*) myreleased " .
				"  FROM registration " .
				"  WHERE eventix = $row->eventix " .
				"    AND NOT waiting " .
				"    AND userix = $userix " .
				"    AND releasetime IS NOT NULL",
				"myreleased");

			if ($row->waiting) {
				$mywaiting = dbgetsingleton(
					"SELECT COUNT(*) mywaiting " .
					"  FROM registration " .
					"  WHERE eventix = $row->eventix AND waiting AND userix = $userix",
					"mywaiting");
			} else $mywaiting = 0;
		} else {
			$myreserved = 0;
			$mywaiting = 0;
		}

	/* Event header */

		$price = $member ? $row->mbrprice : $row->guestprice;
		$eventcdpfx = substr($row->eventcd, 0, strlen($row->eventcd) - 1);


		if (! $row->eventgrouped) {
			$flag = ($openings <= 0) ? "<span class='flag'>SOLD OUT</span>" : "";
			printf("<h3>%s - %s &nbsp; %s</h3>\n", 
				$row->eventnm, $row->fmteventdt, $flag);

			printf("<p style='font-size: small'>$row->longDescription</p>\n");

			printResvPrice($member, $row->mbrprice, $row->guestprice);
		} else {

		# Special query to determine if the entire grouped event is sold out

			if ($eventcdpfx != $preveventcdpfx) {
				$gcapacity = dbgetsingleton(
					"SELECT SUM(capacity) gcapacity " .
					"  FROM event " .
					"  WHERE eventcd LIKE '{$eventcdpfx}_'",
					"gcapacity");

				$greserved = dbgetsingleton(
					"SELECT COUNT(*) greserved " .
					"  FROM registration r JOIN event e USING (eventix) " .
					"  WHERE e.eventcd LIKE '{$eventcdpfx}_'", 
					"greserved");

				$flag = ($greserved >= $gcapacity) ? "<span class='flag'>SOLD OUT</span>" : "";

				printf("<h3>%s - %s &nbsp; %s</h3>\n",
					$row->eventnm, $row->fmteventdt, $flag);
				$preveventcdpfx = $eventcdpfx;

				printf("<p>$row->longDescription</p>\n");

				printResvPrice($member, $row->mbrprice, $row->guestprice);
			}
		}

	/* Event status table
	**
	** +----------+----------+----------+----------+----------+----------+
	** |          | Reserved | Released | Openings |          | Waiting  |
	** | Event    +----------+----------+----------+          +----------+
	** | Time     | Bargraph                       | Controls | Bargraph |
	** |          +--------------------------------+          +----------+
	** |          |      Personal Reservations     |          | PersWait |
	** +----------+--------------------------------+----------+----------+
	**
	*/

		echo "<table>\n";
		echo "<tr><td>\n";

	/* Entire event counts - reservations */

		echo "<td rowspan=3 class='timeslottime'>$row->fmtadvstarttm</td>\n";
		echo "<td align=left class='barlabel'>Reserved: $row->reserved</td>\n";
		echo "<td align=center class='barlabel'>" . ($row->released ? "Released: $row->released" : "") . "</td>\n";
	   	echo "<td align=right class='barlabel'>Openings: $openings</td>\n";

	/* Controls */

		$allowedtowait = $row->waiting < $row->capacity / 3;

		if ($userix && $allowedtowait) {
			echo "<td rowspan=3><table style='border: thin black solid;'><tr>\n";

			if ($openings > 0) {
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
				if ($allowedtowait) {
					echo "<td>";
					echo "Add to<br/>Waiting<br/>List";
					echo "</td>";
					echo "<td>";
					echo "<select name='addwait$ix'>";
					for ($i = 0; $i <= $row->capacity; $i ++)
						echo "<option>$i</option>";
					echo "</select>\n";
					echo "</td>\n";
				}
			}

			if ($myreserved) {
				echo "</tr><tr>";
				echo "<td>";
				echo "Release";
				echo "</td><td>";
				echo "<select name='remove$ix'>";
				for ($i = 0; $i <= $myreserved; $i ++)
					echo "<option>$i</option>";
				echo "</select>\n";
				echo "</td>\n";
			}

			echo "</tr></table></td>\n";
		}

	/* Entire event counts - waiting list */

		echo "<td align=center class='barlabel'>" . ($row->waiting ? "Waiting: $row->waiting" : "") . "</td>\n";

	/* Bar graphs */

		$barfragwidth = 12;
		if ($row->capacity > 40) $barfragwidth = 8;
		if ($row->capacity > 60) $barfragwidth = 4;
		if ($row->capacity > 80) $barfragwidth = 3;

		echo "</tr><tr>\n";
		echo "<td></td>";
		echo "<td colspan=3>";
		bargraph2($row->reserved, "green", $row->released, "yellow", $row->capacity, "white", $barfragwidth);
		echo "</td>";

		echo "<td>";
		if ($row->waiting) bargraph($row->waiting, "red");
		echo "</td>\n";

	/* Personal event counts */

		echo "</tr><tr>\n";
		echo "<td></td>\n";
		echo "<td colspan=3 align='center' class='barlabel'>";
		if ($userix) {
			echo "You have $myreserved reservation" . 
			   ($myreserved != 1 ? "s" : "") . " for this event.";
		}
		echo "</td>";

		echo "<td class='barlabel'>";
		if ($userix && $mywaiting > 0) {
			echo "You are on the<br/>waiting list $mywaiting time" .
				($mywaiting != 1 ? "s" : "") . ".";
		}
		echo "&nbsp;</td>\n";

		echo "</tr></table>\n";

	/* Per-event data */

		echo "<input type='hidden' name='eventix$ix' value='$row->eventix'>\n";
		echo "<input type='hidden' name='eventnm$ix' value='$row->eventnm'>\n";
		echo "<input type='hidden' name='eventdt$ix' value='$row->eventdt'>\n";
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

