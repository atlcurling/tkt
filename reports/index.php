<?php

	require_once("../settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('../include.php');

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

	require_once("DynHtmlPage2.php");
	require_once("DynHtmlBlock.php");

	$pageName = "Reports";
	$debug = 0;

	$year = getvalue("year", 0);

	DynHtmlPage::docHeader($pageName);
	DynHtmlPage::header();

	echo "<div class='colmask leftmenu'>\n";

	loginprompt();
	dbconnect();

# Report menu logic

	if (User::isAdmin()) {
		echo "<ul>\n";
		echo "<li><a href='report.orderByUser.php'>Orders by User</a></li>\n";

		$currseason = dbgetsingleton("SELECT season currseason FROM season WHERE startdt = (SELECT MAX(startdt) FROM season)", "currseason");
		echo "<li><a href='report.membership.php?season=$currseason'>Membership ($currseason)</a></li>\n";

		echo "<li>Event Registration\n";
		echo "<ul>\n";

		if ($year == 0) {
			$sql =
				"SELECT eventix, eventnm, eventdt 
					FROM event 
					WHERE eventdt > CURRENT_DATE - INTERVAL 7 DAY 
					ORDER BY eventdt, advstarttm";
		} else {
			$sql =
				"SELECT eventix, eventnm, eventdt 
					FROM event 
					WHERE YEAR(eventdt) = $year
					ORDER BY eventdt, advstarttm";
		}
			
		$result = mysql_query($sql) or
			die("Error selecting from event. " . mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$url = "report.eventRegistration.php?eventix=" . $row['eventix'];
			printf("<li><a href='%s'>%s - %s</a></li>\n", $url, $row['eventdt'], $row['eventnm']);
		}

		echo "</ul></li>\n";

		echo "<li>Event Registration - Historical\n";
		echo "<ul>\n";
		$sql =
			"SELECT DISTINCT YEAR(eventdt) eventyr FROM event ORDER BY eventyr";
		$result = mysql_query($sql) or
			die("Error selecting from event 2. " . mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$url = "?year={$row['eventyr']}";
			printf("<li><a href='%s'>%s</a></li>\n", $url, $row['eventyr']);
		}

		echo "</ul></li>\n";

		echo "<li>Membership - Historical</li>\n";
		echo "<ul>\n";
		$sql = "SELECT season FROM season ORDER BY startdt";
		$result = mysql_query($sql) or
			die("Error selecting from season. " . mysql_error());

		while ($row = mysql_fetch_assoc($result)) {
			$season = $row['season'];
			$url = "report.membership.php?season=$season";
			echo "<li><a href='$url'>Membership - $season</a></li>\n";
		}

		echo "</ul>\n";

	} else {

		echo "<h2>Access to reports is limited to administrators.</h2>\n";

	}

	  
	echo "</div><!-- colmask leftmenu -->\n";
	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
