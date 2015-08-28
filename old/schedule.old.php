<?php

	require_once("settings.php");
	require_once("{$TKTDIR}user.php");
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="Templates/base.dwt.php" codeOutsideHTMLIsLocked="false" -->

<?php

require_once('include.php');
require_once("{$TKTDIR}functions.php");
require_once("{$TKTDIR}database.php");

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>ATLcurling: Schedule</title>
	<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<div id="Page">
<div id="Header">
  <img src="image/CurlingSheetTitle.png" />
  <ul>
	<li><a href="index.php"><img src="image/BlueCurlingStone20L.png"/>Home</a></li>
	<li><a href="faq.php"><img src="image/RedCurlingStone20L.png"/>FAQ</a></li>
	<li><a href="aboutus.php"><img src="image/BlueCurlingStone20L.png"/>About Us</a></li>
	<li><a href="joinus.php"><img src="image/RedCurlingStone20L.png"/>Membership</a></li>
	<li><a href="eventstatus.php"><img src="image/BlueCurlingStone20L.png"/>Events</a></li>
	<li><a href="leagues.php"><img src="image/RedCurlingStone20L.png"/>Leagues</a></li>
	<li><a href="photos.php"><img src="image/BlueCurlingStone20L.png" />Photos</a></li>
	<li><a href="pubs.php"><img src="image/RedCurlingStone20L.png" />Publications</a></li>
	<li><a href="media.php"><img src="image/BlueCurlingStone20L.png" />Media</a></li>
	<li><a href="schedule.php"><img src="image/RedCurlingStone20L.png"/>Calendar</a></li>
	<li><a href="/wiki" target="_blank"><img src="image/BlueCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="contactus.php"><img src="image/RedCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
  <div class="colleft">
    <div class="col1"> 
	  <!-- InstanceBeginEditable name="body" -->

<?php loginprompt(); ?>

		<h1>Atlanta Curling Club: Schedule</h1>
		<p>
		We are currently holding Learn to Curl sessions to build up the membership of the club in preparation for possible league curling in the winter.  Help out by <a href="joinus.php">joining us</a>.
		</p>
		<p>		
		We try to keep the calendar below as up-to-date as possible.
		Refer to our <a href="http://www.google.com/calendar/embed?src=atlcurling%40gmail.com&ctz=America/New_York">Google Calendar</a> for the current event schedule.
		</p>

		<iframe src="http://www.google.com/calendar/embed?src=atlcurling%40gmail.com&ctz=America/New_York" style="border: 0" width="710" height="600" frameborder="0" scrolling="no"></iframe>
		
	  <!-- InstanceEndEditable -->
	</div><!-- col1 -->
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
      <!-- InstanceBeginEditable name="links" -->
	  
	  <!-- InstanceEndEditable -->	
<!--      <hr /> --><!-- #BeginLibraryItem "/Library/upcoming.lbi" -->
<div id="Title">
	Upcoming Events
</div>

<?php

	dbconnect();

	$sql = 
		"SELECT eventnm, DATE_FORMAT(eventdt, '%a %b %e, %Y') dt, TIME_FORMAT(advstarttm, '%l:%i %p') tm, description " .
		"  FROM event " .
		"  WHERE eventdt >= CURDATE() " .
		"    AND active " .
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
</div><!-- colmask -->
<div id="Footer">
    <p>
		<a href="index.php">Home</a> &nbsp; -- &nbsp; 
		<a href="faq.php">FAQ</a> &nbsp; -- &nbsp; 
		<a href="aboutus.php">About Us</a> &nbsp; -- &nbsp; 
		<a href="joinus.php">Membership</a> &nbsp; -- &nbsp; 
		<a href="eventstatus.php">Events</a> &nbsp; -- &nbsp; 
		<a href="leagues.php">Leagues</a> &nbsp; -- &nbsp; 
		<a href="photos.php">Photos</a> &nbsp; -- &nbsp; 
		<a href="pubs.php">Publications</a> &nbsp; -- &nbsp; 
		<a href="media.php">Media</a> &nbsp; -- &nbsp; 
		<a href="schedule.php">Calendar</a> &nbsp; -- &nbsp; 
		<a href="/wiki" target="_blank">Wiki</a> &nbsp; -- &nbsp; 
		<a href="contactus.php">Contact Us</a>

	</p>
	<p>Curl with us! Copyright &copy; 2012 Atlanta Curling Club, Inc., All Rights Reserved</p>
</div><!-- Footer -->
</div><!-- Page -->
<?php dispdebug(); ?>
</body>
<!-- InstanceEnd --></html>
