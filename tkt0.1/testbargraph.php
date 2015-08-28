<html>
<head>
<?php
	require_once("bargraph.php");

?>
</head><body>

<?php
	echo "<p>10 / 10  from 30<br/>\n";
	bargraph2(10, "red", 10, "yellow", 30, "white");
	echo "</p>";

	echo "<p>10 / 20 from 30<br/>\n";
	bargraph2(10, "red", 20, "yellow", 30, "white");
	echo "</p>";

	echo "<p>20 from 30<br/>\n";
	bargraph2(20, "red", 0, "yellow", 30, "white");
	echo "</p>";

	echo "<p>0 from 30<br/>\n";
	bargraph2(0, "red", 0, "yellow", 30, "white");
	echo "</p>";
	
	echo "<p>30 from 30<br/>\n";
	bargraph2(30, "red", 0, "yellow", 30, "white");
	echo "</p>";
	
	echo "<p>0 / 30 from 30<br/>\n";
	bargraph2(0, "red", 30, "yellow", 30, "white");
	echo "</p>";
	
?>

</body>
</html>
