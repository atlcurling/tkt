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
	<title>ATLcurling: Home Page</title>
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
	<li><a href="payment.php"><img src="image/RedCurlingStone20L.png"/>Payment</a></li>
	<li><a href="photos.php"><img src="image/BlueCurlingStone20L.png" />Photos and Video</a></li>
	<li><a href="pubs.php"><img src="image/RedCurlingStone20L.png" />Publications</a></li>
	<li><a href="media.php"><img src="image/BlueCurlingStone20L.png" />Media</a></li>
	<li><a href="schedule.php"><img src="image/RedCurlingStone20L.png"/>Schedule</a></li>
	<li><a href="http://bit.ly/atlcurling"><img src="image/BlueCurlingStone20L.png"/>Facebook</a></li>
	<li><a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki"><img src="image/RedCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="contactus.php"><img src="image/BlueCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
  <div class="colleft">
    <div class="col1"> 
	  <!-- InstanceBeginEditable name="body" -->

<?php loginprompt(); ?>

		<h1>Atlanta Curling Club: Latest News</h1>
			
		<h2>Web Site Registration</h2>
		<p>As part of the online signup for scheduled curling events, please create yourself an account using the <b>login / register</b> link in the upper right corner.
		At this point you will not be able to do anything other than register, login and logout, however this is an important first step towards getting our registrations up and running.</p>
		<p>In addition, please go to <a href="http://paypal.com">PayPal</a> and create yourself an account there (click the <b>Sign Up</b> link at the top of the page. 
		PayPal is a trusted vendor of the Atlanta Curling Club, and all online payments will be processed by them.
		You will need to have an account on PayPal, and you will need to be able to log into it when reservations are made.
		(If you already have a PayPal account you will not have to create a new one.)</p>
		
		<h2>Monday Night Curling Begins January 9</h2>
		<p>Atlanta Curling Club is excited to announce the beginning of regularly scheduled curling on <b>Monday, January 9, 2012 at 7:30pm</b>.  We will have the rink for two hours about every two weeks.</p>
		<p>Continue to watch this page for more details as signup will primarily be online.</p>

		<h2>Learn to Curl #5</h2>
		<p>
		Atlanta Curling Club is dedicated to promoting the great sport of curling in the Atlanta area.
		To help build our membership we will be holding Learn to Curl events throughout 2012.
		</p>
		<p>
		Our next Learn to Curl (L2C5) is scheduled for <strong>Sunday, January 22 at 5:30pm</strong>.  
		Join us at our new home, the Marietta Ice Center. 
		Wear soft-soled shoes and loose fitting clothes.  
		Synthetic workout pants are good as they will not absorb water from the ice.
		</p>		
			<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Marietta+Ice+Center,+4880+Lower+Roswell+Rd,+Marietta,+GA+30068&amp;aq=&amp;sll=33.978603,-84.48822&amp;sspn=0.154876,0.308647&amp;vpsrc=6&amp;ie=UTF8&amp;hq=Marietta+Ice+Center,&amp;hnear=4880+Lower+Roswell+Rd,+Marietta,+Cobb,+Georgia+30068&amp;t=m&amp;ll=33.965697,-84.40798&amp;spn=0.008542,0.013733&amp;z=16&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Marietta+Ice+Center,+4880+Lower+Roswell+Rd,+Marietta,+GA+30068&amp;aq=&amp;sll=33.978603,-84.48822&amp;sspn=0.154876,0.308647&amp;vpsrc=6&amp;ie=UTF8&amp;hq=Marietta+Ice+Center,&amp;hnear=4880+Lower+Roswell+Rd,+Marietta,+Cobb,+Georgia+30068&amp;t=m&amp;ll=33.965697,-84.40798&amp;spn=0.008542,0.013733&amp;z=16&amp;iwloc=A" style="color:#0000FF;text-align:left">View Larger Map</a></small>		

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
