<?php

	require_once("../settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/admin.dwt.php" codeOutsideHTMLIsLocked="false" -->

<?php

require_once('../include.php');
require_once("{$TKTDIR}functions.php");
require_once("{$TKTDIR}database.php");

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Report: Event Registration</title>
	<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
	<link href="../style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<div id="Page">
<div id="Header">
  <img src="<?= $IMGDIR ?>CurlingSheetTitle.png" />
  <ul>
	<li><a href="index.php"><img src="<?= $IMGDIR ?>BlueCurlingStone20L.png"/>Home</a></li>
	<li><a href="aboutus.php"><img src="<?= $IMGDIR ?>RedCurlingStone20L.png"/>About Us</a></li>
	<li><a href="joinus.php"><img src="<?= $IMGDIR ?>BlueCurlingStone20L.png"/>Join Us</a></li>
	<li><a href="eventstatus.php"><img src="<?= $IMGDIR ?>RedCurlingStone20L.png"/>Events</a></li>
	<li><a href="leagues.php"><img src="<?= $IMGDIR ?>BlueCurlingStone20L.png"/>Leagues</a></li>
	<li><a href="photos.php"><img src="<?= $IMGDIR ?>RedCurlingStone20L.png" />Photos and Video</a></li>
	<li><a href="pubs.php"><img src="<?= $IMGDIR ?>BlueCurlingStone20L.png" />Publications</a></li>
	<li><a href="media.php"><img src="<?= $IMGDIR ?>RedCurlingStone20L.png" />Media</a></li>
	<li><a href="schedule.php"><img src="<?= $IMGDIR ?>BlueCurlingStone20L.png"/>Schedule</a></li>
	<li><a href="http://bit.ly/atlcurling"><img src="<?= $IMGDIR ?>RedCurlingStone20L.png"/>Facebook</a></li>
	<li><a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki"><img src="<?= $IMGDIR ?>BlueCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="contactus.php"><img src="<?= $IMGDIR ?>RedCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
	  <!-- InstanceBeginEditable name="body" -->


		<?php

		$eventix = getvalue("eventix", 0);
		
		$totadm = 0.00;
		
		dbconnect();
		$sql =
			"SELECT e.* FROM event e WHERE e.eventix = $eventix";
			
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());
			
		$row = mysql_fetch_assoc($result);
		echo "<h3>Event {$row['eventix']} - {$row['eventnm']} - {$row['eventdt']}</h3>\n";
		
		echo "<table width='100%'><tr><td style='width: 33%;'>\n";
		printf("<table style='border: solid 1px black; width: 100%%;'><tr><td>%s</td></tr></table>\n", $row['description']);
		
		$fmt = "<tr><td>%s</td><td>%s</td></tr>\n";

		echo "</td><td style='width: 33%'>\n";
		echo "<table style='border: solid 1px black; width: 100%;'>\n";
		printf($fmt, "Volunteer Call Time", $row['calltm']);
		printf($fmt, "Advertised Start Time", $row['advstarttm']);
		printf($fmt, "Ice Time Start", $row['icetm']);
		printf($fmt, "Tear Down Time", $row['teardowntm']);
		echo "</table>\n";
		
		echo "</td><td style='width: 34%'>\n";
		echo "<table style='border: solid 1px black; width: 100%;'>\n";
		printf($fmt, "Event Capacity", $row['capacity']);
		printf($fmt, "Member Price", $row['mbrprice']);
		printf($fmt, "Non-Member Price", $row['guestprice']);
		echo "</table>\n";
		
		$capacity = $row['capacity'];
		
		echo "</td></tr></table>\n";
		
		$sql =
			"SELECT r.addorderix, d.extamt / d.qty amt, CONCAT(u.firstnm, ' ', u.lastnm) nm, u.usernm, u.phonenbr " .
			"  FROM registration r " .
			"    JOIN orderdtl d ON (r.addorderix = d.orderix AND d.eventix = $eventix) " .
			"    JOIN user u ON (r.userix = u.userix) " .
			"  WHERE r.eventix = $eventix " .
			"    AND NOT r.waiting";
			
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());
			
		$line = 0;
		echo "<table border=1>\n";
		echo "<tr>";
		echo "<th style='width: 2em'>Line</th>";
		echo "<th style='width: 2em'>Order</th>";
		echo "<th style='width: 4em'>Amount</th>";
		echo "<th style='width: 16em'>Name</th>";
		echo "<th style='width: 24em'>E-mail</th>";
		echo "<th style='width: 10em'>Phone</th>";
		echo "</tr>\n";

		$dfmt = "<td style='text-align: center'>%d</td>";
		$ffmt = "<td style='text-align: center'>$%.2f</td>";
		$sfmt = "<td>%s</td>";
		
		while ($row = mysql_fetch_assoc($result)) {
			echo "<tr style='height: 2.3em;'>";
			printf($dfmt, ++$line);
			printf($dfmt, $row['addorderix']);
			printf($ffmt, $row['amt']);
			printf($sfmt, $row['nm']);
			printf($sfmt, $row['usernm']);
			printf($sfmt, $row['phonenbr']);
			echo "</tr>\n";
			
			$totadm += $row['amt'];
		}
		
		while ($line < $capacity) {
			echo "<tr style='height: 2.3em;'>";
			printf($dfmt, ++$line);
			printf($sfmt, "");
			printf($sfmt, "");
			printf($sfmt, "");
			printf($sfmt, "");
			printf($sfmt, "");
			echo "</tr>\n";
		}
		
		echo "</table>\n";
		
		$sql =
			"SELECT r.addorderix, d.extamt / d.qty amt, CONCAT(u.firstnm, ' ', u.lastnm) nm, u.usernm, u.phonenbr " .
			"  FROM registration r " .
			"    JOIN orderdtl d ON (r.addorderix = d.orderix AND d.eventix = $eventix) " .
			"    JOIN user u ON (r.userix = u.userix) " .
			"  WHERE r.eventix = $eventix " .
			"    AND r.waiting";
			
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());
			
		if (mysql_num_rows($result) > 0) {
			echo "<h3>Waiting List</h3>\n";
				
			$line = 0;
			echo "<table border=1>\n";
			echo "<tr>";
			echo "<th style='width: 2em'>Line</th>";
			echo "<th style='width: 2em'>Order</th>";
			echo "<th style='width: 4em'>Amount</th>";
			echo "<th style='width: 16em'>Name</th>";
			echo "<th style='width: 24em'>E-mail</th>";
			echo "<th style='width: 10em'>Phone</th>";
			echo "</tr>\n";
	
			while ($row = mysql_fetch_assoc($result)) {
				echo "<tr style='height: 2.3em;'>";
				printf($dfmt, ++$line);
				printf($dfmt, $row['addorderix']);
				printf($sfmt, "WAIT");
				printf($sfmt, $row['nm']);
				printf($sfmt, $row['usernm']);
				printf($sfmt, $row['phonenbr']);
				echo "</tr>\n";
			
				$totadm += $row['amt'];
			}
		}
		
		echo "</table>\n";
		
		printf("Total admissions received: $%.2f<br/>\n", $totadm);
	
		?>
	  
	  
	  <!-- InstanceEndEditable -->
</div><!-- colmask -->
<div id="Footer">
    <p>
		<a href="index.php">Home</a> &nbsp; -- &nbsp; 
		<a href="aboutus.php">About Us</a> &nbsp; -- &nbsp; 
		<a href="joinus.php">Join Us</a> &nbsp; -- &nbsp; 
		<a href="eventstatus.php">Events</a> &nbsp; -- &nbsp; 
		<a href="leagues.php">Leagues</a> &nbsp; -- &nbsp; 
		<a href="photos.php">Photos and Video</a> &nbsp; -- &nbsp; 
		<a href="pubs.php">Publications</a> &nbsp; -- &nbsp; 
		<a href="media.php">Media</a> &nbsp; -- &nbsp; 
		<a href="schedule.php">Schedule</a> &nbsp; -- &nbsp; 
		<a href="http://bit.ly/atlcurling">Facebook</a> &nbsp; -- &nbsp; 
		<a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki">Wiki</a> &nbsp; -- &nbsp; 
		<a href="contactus.php">Contact Us</a>

	</p>
	<p>Curl with us! Copyright &copy; 2012 Atlanta Curling Club, Inc., All Rights Reserved</p>
</div><!-- Footer -->
</div><!-- Page -->
<?php dispdebug(); ?>
</body>
<!-- InstanceEnd --></html>
