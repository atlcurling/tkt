<?php 

	require_once("settings.php");
	require_once("{$TKTDIR}user.php");
	session_start(); 

?>
<html>
<head>
<link rel="Stylesheet" href="styles.css" title="Main Style Sheet" type="text/css">
<title>Login</title>

<?php

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

	$page = "login.php";

	$debug = 1;

?>

</head>

<body>

<?php

	require_once("{$TKTDIR)logic.login.php");
	dispdebug();

?>

</body>
</html>
