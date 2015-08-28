<html>
<head>
<?php

	require_once("functions.php");
	require_once("database.php");
	require_once("xactlog.php");

?>
</head>
<body>
<h1>test.xactlog</h1>

<?php

	dbconnect();

	echo "<h2>XactLog::log</h2>";
	$x = new XactLog();
	$x->log("Test Xact");
	$x->log("Test Xact 2", "description");
	$x->log("Test Xact 3", NULL);
	$x->log("Test Xact 3", "");
	$x->log("Test Xact 4", "userix", 1);
	$x->log("Test Xact 4", "userix", NULL);
	$x->log("Test Xact 4", "userix", "");
	$x->log("Test Xact 4", NULL, 1);
	$x->log("Test Xact 5", "eventix", 1, 2);
	$x->log("Test Xact 5", "eventix", 1, NULL);
	$x->log("Test Xact 5", "eventix", 1, "");
	$x->log("Test Xact 5", "eventix", NULL, 2);
	$x->log("Test Xact 5", "eventix", "", 2);
	$x->log("Test Xact 5", NULL, 1, 2);
	$x->log("Test Xact 5", "", 1, 2);
	$x->log("Test Xact 6", "eventix", 1, 2, "This is a test transaction.\nMany test transactions have excessive detail.\nThis one is a good example of that.\n");
	$x->log("Test Xact 6", "eventix", 1, 2, NULL);
	$x->log("Test Xact 6", "eventix", 1, 2, "");
	$x->log("Test Xact 6", "eventix", 1, NULL, "This is a test transaction.\nMany test transactions have excessive detail.\nThis one is a good example of that.\n");
	$x->log("Test Xact 6", "eventix", 1, "", "This is a test transaction.\nMany test transactions have excessive detail.\nThis one is a good example of that.\n");
	$x->log("Test Xact 6", "eventix", NULL, 2, "This is a test transaction.\nMany test transactions have excessive detail.\nThis one is a good example of that.\n");
	$x->log("Test Xact 6", "eventix", "", 2, "This is a test transaction.\nMany test transactions have excessive detail.\nThis one is a good example of that.\n");
	$x->log("Test Xact 6", NULL, 1, 2, "This is a test transaction.\nMany test transactions have excessive detail.\nThis one is a good example of that.\n");
	$x->log("Test Xact 6", "", 1, 2, "This is a test transaction.\nMany test transactions have excessive detail.\nThis one is a good example of that.\n");

?>

</body>
</html>
