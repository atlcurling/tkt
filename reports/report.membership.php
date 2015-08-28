<?php

	require_once("../settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('../include.php');

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

	require_once("DynHtmlPage2.php");
	require_once("DynHtmlBlock.php");

	$pageName = "Report - Membership";
	$debug = 0;

	$season = getvalue("season", NULL);

	DynHtmlPage::docHeader($pageName);
	DynHtmlPage::header();

	echo "<div class='colmask leftmenu'>\n";

	dbconnect();

# Report logic

	if (User::isAdmin()) {
		$where = "WHERE 1";
		if ($season) $where .= " AND m.season = '$season'";

		$sql = 
			"SELECT m.season, m.joindt, u.userix, u.firstnm, u.lastnm, u.usernm, u.member, u.admin " .
			"  FROM `membership` m JOIN `user` u ON m.userix = u.userix " .
			"  $where " .
			"  ORDER BY m.season, u.lastnm, u.firstnm ";

		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());

		if (! $season) {
			echo "<h2>Membership Report</h2>";
		} else {
			echo "<h2>Membership Report for $season</h2>";
		}

		echo "<p>Only the users marked as \"Currently Member\" can register at \"member price\" in the registration system.</p>\n";
		echo "<table border=1>\n";
		echo "<tr><th>Season</th><th>Join Date</th><th>User Ix</th><th>First Name</th><th>Last Name</th><th>User Name</th><th>Currently<br/>Member</th><th>Currently<br/>Admin</th></tr>\n";
		while ($row = mysql_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>{$row['season']}</td>";
			echo "<td>{$row['joindt']}</td>";
			echo "<td>{$row['userix']}</td>";
			echo "<td>{$row['firstnm']}</td>";
			echo "<td>{$row['lastnm']}</td>";
			echo "<td>{$row['usernm']}</td>";
			echo "<td>{$row['member']}</td>";
			echo "<td>{$row['admin']}</td>";
			echo "</tr>\n";
		}
		echo "</table>\n";
	
	} else {

		echo "<h2>Access to reports is limited to administrators.</h2>\n";

	}

	echo "</div><!-- colmask leftmenu -->\n";
	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
