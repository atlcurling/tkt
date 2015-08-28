<?php 
	require_once("settings.php");
	require_once("{$TKTDIR}user.php");
	session_start();
?>
<html>

<link rel="Stylesheet" href="styles.css" title="Main Style Sheet" type="text/css">

<head>
<?php

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");
	require_once("{$TKTDIR}bargraph.php");

	$debug = 1;
	
?>
</head>

<body>

<?php

	require_once("{$TKTDIR}logic.eventstatus.php");
	dispdebug();
?>

</body>
</html>

