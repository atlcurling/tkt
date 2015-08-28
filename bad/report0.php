<?php

	require_once("../settings.php");
	require_once("../{$TKTDIR}user.php");
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/base.dwt.php" codeOutsideHTMLIsLocked="false" -->

<?php

require_once('../include.php');
require_once("../{$TKTDIR}functions.php");
require_once("../{$TKTDIR}database.php");

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Reports</title>
	<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
	<link href="../style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="../favicon.ico" />
</head>
<body>
<div id="Page">
<div id="Header">
  <img src="../image/CurlingSheetTitle.png" />
  <ul>
	<li><a href="../index.php"><img src="../image/BlueCurlingStone20L.png"/>Home</a></li>
	<li><a href="../aboutus.php"><img src="../image/RedCurlingStone20L.png"/>About Us</a></li>
	<li><a href="../joinus.php"><img src="../image/BlueCurlingStone20L.png"/>Join Us</a></li>
	<li><a href="../eventstatus.php"><img src="../image/RedCurlingStone20L.png"/>Events</a></li>
	<li><a href="../payment.php"><img src="../image/BlueCurlingStone20L.png"/>Payment</a></li>
	<li><a href="../photos.php"><img src="../image/RedCurlingStone20L.png" />Photos and Video</a></li>
	<li><a href="../pubs.php"><img src="../image/BlueCurlingStone20L.png" />Publications</a></li>
	<li><a href="../media.php"><img src="../image/RedCurlingStone20L.png" />Media</a></li>
	<li><a href="../schedule.php"><img src="../image/BlueCurlingStone20L.png"/>Schedule</a></li>
	<li><a href="http://bit.ly/atlcurling" target="_blank"><img src="../image/RedCurlingStone20L.png"/>Facebook</a></li>
	<li><a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki" target="_blank"><img src="../image/BlueCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="../contactus.php"><img src="../image/RedCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
  <div class="colleft">
    <div class="col1"> 
	  <!-- InstanceBeginEditable name="body" -->
	  
	  
	  <ul>
	  <li><a href="../report.orderByUser.php">Orders by User</a></li>
	  </ul>
	  <!-- InstanceEndEditable -->	</div><!-- col1 -->
    <div class="col2">
	  <center>
	  <?php
	  /*
	  echo "<a href='$wikiupdurl'>updates</a>";
	  echo " -- ";
	  echo "<a href='$wikitalkurl'>discuss</a>";
	  echo "\n";
	  */
	  ?>
	  </center>
<!--	  <hr /> -->
      <!-- InstanceBeginEditable name="links" -->	  <!-- InstanceEndEditable -->	
<!--      <hr /> --><!-- #BeginLibraryItem "/Library/upcoming.lbi" -->
<div id="Title">
	Upcoming Events</div>

<?php

	dbconnect();

	$sql = 
		"SELECT eventnm, DATE_FORMAT(eventdt, '%a %b %e, %Y') dt, TIME_FORMAT(advstarttm, '%l:%i %p') tm, description " .
		"  FROM event " .
		"  WHERE eventdt >= CURDATE() " .
		"  ORDER BY eventdt";
		
	$result = mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
		echo "<div class='event'>\n";
		echo "<div id='event-title'>{$row['eventnm']}</div>\n";
		echo "<div id='event-datetime'>{$row['dt']} @ {$row['tm']}</div>\n";
		echo "<div id='event-detail'>{$row['description']}</div>\n";
		echo "</div>\n";
	}

?>

<!-- #EndLibraryItem --></div>
    <!-- col2 -->
  </div><!-- colleft -->
</div>
<!-- colmask -->
<div id="Footer">
    <p>
		<a href="../index.php">Home</a> &nbsp; -- &nbsp; 
		<a href="../aboutus.php">About Us</a> &nbsp; -- &nbsp; 
		<a href="../joinus.php">Join Us</a> &nbsp; -- &nbsp; 
		<a href="../eventstatus.php">Events</a> &nbsp; -- &nbsp; 
		<a href="../payment.php">Payment</a> &nbsp; -- &nbsp; 
		<a href="../photos.php">Photos and Video</a> &nbsp; -- &nbsp; 
		<a href="../pubs.php">Publications</a> &nbsp; -- &nbsp; 
		<a href="../media.php">Media</a> &nbsp; -- &nbsp; 
		<a href="../schedule.php">Schedule</a> &nbsp; -- &nbsp; 
		<a href="http://bit.ly/atlcurling" target="_blank">Facebook</a> &nbsp; -- &nbsp; 
		<a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki" target="_blank">Wiki</a> &nbsp; -- &nbsp; 
		<a href="../contactus.php">Contact Us</a>

	</p>
	<p>Curl with us! Copyright &copy; 2012 Atlanta Curling Club, Inc., All Rights Reserved</p>
</div><!-- Footer -->
</div><!-- Page -->
<?php dispdebug(); ?>
</body>
<!-- InstanceEnd --></html>
