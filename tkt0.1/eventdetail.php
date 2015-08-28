<html>

<link rel="Stylesheet" href="styles.css" title="Main Style Sheet" type="text/css">

<body>

<?php

	require_once("functions.php");
	require_once("database.php");

	$debug = 1;

	dbconnect();

/* Event table */

	echo "<h1>Event Detail</h1>\n";

	$sql = 
		"SELECT r.eventix, r.userix, r.position, r.waiting, " .
		"    e.eventnm, e.capacity, u.usernm \n" .
		"  FROM registration r \n" .
		"    JOIN event e ON (r.eventix = e.eventix) \n" .
		"    JOIN user u ON (r.userix = u.userix) \n" .
		"  ORDER BY r.eventix, r.position, r.waiting";

	dispsql($sql);

	$res = mysql_query($sql) 
		or die("Error during select. " . mysql_error());


	$cbeventix = 0;
	while ($row = mysql_fetch_assoc($res)) {
		if ($cbeventix != $row['eventix']) {
			$cbeventix = $row['eventix'];

			$eventnm = $row['eventnm'];
			$capacity = $row['capacity'];
			$registered = dbgetsingleton("SELECT COUNT(*) registered FROM registration WHERE eventix = $cbeventix AND waiting = 0", "registered");
			$openings = $capacity - $registered;
			$waiting = dbgetsingleton("SELECT COUNT(*) waiting FROM registration WHERE eventix = $cbeventix AND waiting = 1", "waiting");

			echo "<h2>eventix $cbeventix, eventnm: $eventnm, registered: $registered, openings: $openings, waiting: $waiting</h2>\n";
		}

		if ($debug) {
			echo "position: ${row['position']}, ";

			echo "userix: ${row['userix']}, ";
			echo "waiting: ${row['waiting']}, ";
			echo "usernm: ${row['usernm']}";
		} else {
			echo $row['position'] . ": ";
			echo $row['usernm'] . " ";
			if ($row['waiting']) echo " (waiting)";
		}
		echo "<br/>\n";
	}

	dispdebug();
?>


</body>
</html>

