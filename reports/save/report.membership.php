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
	<title>Report: Membership</title>
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
		
		dbconnect();
		$sql = 
			"SELECT m.season, m.joindt, u.firstnm, u.lastnm, u.member " .
			"  FROM `membership` m JOIN `user` u ON m.userix = u.userix " .
			"  ORDER BY m.season, u.lastnm, u.firstnm";
		$result = mysql_query($sql)
			or die("Error during select. " . mysql_error());

		echo "<h2>Membership Report</h2>";
		echo "<p>Only these users can register at \"member price\" in the registration system.</p>\n";
		echo "<table border=1>\n";
		echo "<tr><th>Season</th><th>Join Date</th><th>First Name</th><th>Last Name</th><th>Member</th></tr>\n";
		while ($row = mysql_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>{$row['season']}</td>";
			echo "<td>{$row['joindt']}</td>";
			echo "<td>{$row['firstnm']}</td>";
			echo "<td>{$row['lastnm']}</td>";
			echo "<td>{$row['member']}</td>";
			echo "</tr>\n";
		}
		echo "</table>\n";
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
