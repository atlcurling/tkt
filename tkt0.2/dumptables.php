<html>

<link rel="Stylesheet" href="styles.css" title="Main Style Sheet" type="text/css">

<body>

<?php

	require_once("functions.php");
	require_once("database.php");

	function dumptable($tablenm) {
		echo "<h1>$tablenm</h1>\n";

		$sql = "SELECT * from $tablenm";

		dispsql($sql);

		$res = mysql_query($sql) 
			or die("Error during select. " . mysql_error());

		disphor($res);
	}

	dbconnect();

	dumptable("event");
	dumptable("user");
	dumptable("registration");
	dumptable("orderhdr");
	dumptable("orderdtl");

?>

</body>
</html>

