<?php 
	require_once("settings.php");
	require_once("user.php");
	session_start(); 
?>
<html>
<head>
<link rel="Stylesheet" href="styles.css" title="Main Style Sheet" type="text/css">
<?php

	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

	$debug = 1;

	loginprompt();

?>

<title>Atlanta Curling Club Reservation System</title>

</head>
<body>

<h1>Atlanta Curling Club Reservation System</h1>

<ul>
<li><a href="dumptables.php">Dump Tables</a></li>
<li><a href="eventstatus.php">Event Status</a></li>
<li><a href="eventdetail.php">Event Detail</a></li>
</ul>

<h2>Test Modules</h2>
<ul>
<li><a href="test.order.php">Test Order</a></li>
<li><a href="test.orderdtl.php">Test OrderDtl</a></li>
<li><a href="test.xactlog.php">Test XactLog</a></li>
</ul>

<h2>Inclusion Test</h2>
<a href="inctest.php">Inclusion Test</a>

<?php dispdebug(); ?>

</body>
</html>

