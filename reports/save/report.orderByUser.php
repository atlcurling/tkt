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
	<title>Report: Orders by User</title>
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


		<h1>Report: Orders by User</h1>
		
		<?php
		
		dbconnect();
		$sql = 
			"SELECT CONCAT(u.firstnm, ' ', u.lastnm) nm, u.usernm, u.phonenbr, " .
			"    o.orderix, o.crtime, o.pmtaprtime, o.pmtrejtime, o.pmtrecvtime, o.userix, o.totalamt, " .
			"    d.orderdtlix, d.eventix, d.action, d.qty, d.extamt, e.eventnm, e.eventdt " .
			"  FROM orderhdr o " .
			"    JOIN orderdtl d ON o.orderix = d.orderix " .
			"    JOIN user u ON o.userix = u.userix " .
			"    JOIN event e ON d.eventix = e.eventix " .
			"  ORDER BY u.firstnm, u.lastnm, o.orderix, d.orderdtlix";
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());

		$debugreport = 0;
		if (! $debugreport) {
			$puserix = 0;
			$porderix = 0;
			while ($row = mysql_fetch_assoc($result)) {
			
				if ($row["orderix"] != $porderix) {
					if ($intable) {
						echo "</table>\n";
						$intable = 0;
					}
				}
			
				if ($row["userix"] != $puserix) {
					printf("<h4>%s - %s - %s</h4>\n", $row["nm"], $row["usernm"], $row["phonenbr"]);
					$puserix = $row["userix"];
					$porderix = 0;
				}
				
				if ($row["orderix"] != $porderix) {
					printf("<h5>Order %s - $%.2f</h5>\n", $row["orderix"], $row["totalamt"]);
					echo "<ul>";
					printf("<li>Order creation time: %s</li>\n", $row["crtime"]);
					if ($row["pmtaprtime"]) printf("<li>Payment approval time: %s</li>\n", $row["pmtaprtime"]);
					if ($row["pmtrejtime"]) printf("<li>Payment rejection time: %s</li>\n", $row["pmtrejtime"]);
					if ($row["pmtrecvtime"]) printf("<li>Payment received time: %s</li>\n", $row["pmtrecvtime"]);
					
					$orderstatus = "Abandoned";
					if ($row["pmtaprtime"]) $orderstatus = "Approved";
					if ($row["pmtrejtime"]) $orderstatus = "Rejected";

					printf("<li>Order summary: %s</li>\n", $orderstatus);
					echo "</ul>";

					if ($orderstatus == "Approved") {					
						echo "<table border=1>";
						echo "<tr><th>Line</th><th>Event</th><th>Event Date</th><th>Action</th><th>Qty</th><th>Ext. Amt.</th></tr>\n";
						$intable = 1;
					}

					$porderix = $row["orderix"];
				}
				
				if ($orderstatus == "Approved") {
					printf("<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>$%.2f</td></tr>\n", 
						$row["orderdtlix"],
						$row["eventnm"],
						$row["eventdt"],
						$row["action"],
						$row["qty"],
						$row["extamt"]);
				}
			}
			
			if ($intable) echo "</table>\n";
		} else {
			echo "<table border=1>\n";
			while ($row = mysql_fetch_assoc($result)) {
				disprowvert($row);
				echo "<tr><td colspan=2><hr/></td></tr>\n";
			}
			echo "</table>\n";
		}		
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
