<html>
<head>
<?php

	require_once("functions.php");
	require_once("database.php");
	require_once("order.php");

?>
</head>
<body>
<h1>test.order</h1>

<?php

	dbconnect();

	echo "<h2>Order::loadbyOrderIx</h2>";
	$order = new Order();
	$order->loadByOrderIx(1);

	echo "<pre>";
	print_r($order);
	echo "</pre>";

	echo "<h2>Order::load</h2>";
	$order = new Order();
	$order->load(1);

	echo "<pre>";
	print_r($order);
	echo "</pre>";

?>

</body>
</html>

