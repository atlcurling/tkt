<html>
<head>
<?php

	require_once("functions.php");
	require_once("database.php");
	require_once("orderdtl.php");

?>
</head>
<body>
<h1>test.orderdtl</h1>

<?php

	dbconnect();

	echo "<h2>OrderDtl->load</h2>";
	$orderdtl = new OrderDtl();
	$orderdtl->load(1, 1);

	echo "<pre>";
	print_r($orderdtl);
	echo "</pre>";

	echo "<h2>OrderDtl->save</h2>";
	$orderdtl->orderdtlix = 4;
	$orderdtl->eventix = 12;
	echo $orderdtl->save() . " rows inserted or updated.";

?>

</body>
</html>

