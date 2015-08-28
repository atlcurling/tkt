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
	<title>ATLcurling: Join Us</title>
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
	<li><a href="aboutus.php"><img src="image/RedCurlingStone20L.png"/>About Us</a></li>
	<li><a href="joinus.php"><img src="image/BlueCurlingStone20L.png"/>Join Us</a></li>
	<li><a href="eventstatus.php"><img src="image/RedCurlingStone20L.png"/>Events</a></li>
	<li><a href="payment.php"><img src="image/BlueCurlingStone20L.png"/>Payment</a></li>
	<li><a href="photos.php"><img src="image/RedCurlingStone20L.png" />Photos and Video</a></li>
	<li><a href="pubs.php"><img src="image/BlueCurlingStone20L.png" />Publications</a></li>
	<li><a href="media.php"><img src="image/RedCurlingStone20L.png" />Media</a></li>
	<li><a href="schedule.php"><img src="image/BlueCurlingStone20L.png"/>Schedule</a></li>
	<li><a href="http://bit.ly/atlcurling"><img src="image/RedCurlingStone20L.png"/>Facebook</a></li>
	<li><a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki"><img src="image/BlueCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="contactus.php"><img src="image/RedCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
  <div class="colleft">
    <div class="col1"> 
	  <!-- InstanceBeginEditable name="body" -->

<?php loginprompt(); ?>

		<h1>Atlanta Curling Club: Join Us!</h1>
		Join the Atlanta Curling Club and help us get curling going in Atlanta!
		
		<h3>Step 1: Apply for Membership</h3>
		<p>
		Fill out our <a href="form/membership2011c.pdf">Membership Form</a>, print it out and sign it, 
		and enclose a check for the appropriate membership amount (or use our <a href="payment.php">Payment Page</a>).
		You may also want to fill out the <a href="form/waiver2011.pdf">waiver</a> as well, as you will need this before you can get on the ice.
		Mail your paperwork (and check if not paying online) to:
		<ul class="AddressBlock">
			<li>Atlanta Curling Club</li>
			<li>P.O. Box 72873</li>
			<li>Marietta, GA 30007-2873</li>
		</ul>
		</p>
		
		<h3>Step 2: Pay for Membership</h3>
		<p>
		If you didn't include a check, pay for your membership on our <a href="payment.php">Payment Page</a>.
		</p>

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

<div class="event">
	<strong>Monday Night Curling A1</strong><br/>
	<i>Monday, January 9, 2012 @ 7:30pm</i><br/>
	Come to the start of regular curling -- we'll be curling every two weeks.
</div>

<div class="event">
	<strong>Learn to Curl #5</strong><br/>
	<i>Sunday, January 22, 2011 @ 5:30pm</i><br/>
	Learning to curl is easy and fun. Come let us show you how!
</div>

<div class="event">
	<strong>Monday Night Curling A2</strong><br/>
	<i>Monday, January 23, 2012 @ 7:30pm</i><br/>
	Regular member curling.
</div>

<div class="event">
	<strong>Monday Night Curling A3</strong><br/>
	<i>Monday, February 6, 2012 @ 7:30pm</i><br/>
	Regular member curling.
</div>

<div class="event">
	<strong>Monday Night Curling A4</strong><br/>
	<i>Monday, February 27, 2012 @ 7:30pm</i><br/>
	Regular member curling.
</div>

<div class="event">
	<strong>Monday Night Curling A5</strong><br/>
	<i>Monday, March 12, 2012 @ 7:30pm</i><br/>
	Regular member curling.
</div>

<div class="event">
	<strong>Monday Night Curling A6</strong><br/>
	<i>Monday, March 26, 2012 @ 7:30pm</i><br/>
	Regular member curling.
</div>

<!-- #EndLibraryItem --></div>
    <!-- col2 -->
  </div><!-- colleft -->
</div><!-- colmask -->
<div id="Footer">
    <p>
		<a href="index.php">Home</a> &nbsp; -- &nbsp; 
		<a href="aboutus.php">About Us</a> &nbsp; -- &nbsp; 
		<a href="joinus.php">Join Us</a> &nbsp; -- &nbsp; 
		<a href="eventstatus.php">Events</a> &nbsp; -- &nbsp; 
		<a href="payment.php">Payment</a> &nbsp; -- &nbsp; 
		<a href="photos.php">Photos and Video</a> &nbsp; -- &nbsp; 
		<a href="pubs.php">Publications</a> &nbsp; -- &nbsp; 
		<a href="media.php">Media</a> &nbsp; -- &nbsp; 
		<a href="schedule.php">Schedule</a> &nbsp; -- &nbsp; 
		<a href="http://bit.ly/atlcurling">Facebook</a> &nbsp; -- &nbsp; 
		<a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki">Wiki</a> &nbsp; -- &nbsp; 
		<a href="contactus.php">Contact Us</a>

	</p>
	<p>Curl with us! Copyright &copy; 2011 Atlanta Curling Club, Inc., All Rights Reserved</p>
</div><!-- Footer -->
</div><!-- Page -->
<?php dispdebug(); ?>
</body>
<!-- InstanceEnd --></html>
