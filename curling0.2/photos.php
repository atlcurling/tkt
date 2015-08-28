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
	<title>ATLcurling: Photos and Videos</title>
	<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" -->
	<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<!-- InstanceEndEditable -->
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

	  <h1>Atlanta Curling Club: Photos and Video</h1>
	  
	  <p>Please enjoy these photos from Curling Camp 2010. We had a great time and wish you had been there with us.</p>
	  
	  <embed type="application/x-shockwave-flash" src="http://picasaweb.google.com/s/c/bin/slideshow.swf" width="600" height="400" flashvars="host=picasaweb.google.com&hl=en_US&feat=flashalbum&RGB=0x000000&feed=http%3A%2F%2Fpicasaweb.google.com%2Fdata%2Ffeed%2Fapi%2Fuser%2F116158141739229422422%2Falbumid%2F5501010156007725505%3Falt%3Drss%26kind%3Dphoto%26hl%3Den_US" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
	  
	  <p>Here's a video of Jeff's button shot from Curlng Camp 2010.</p>
	  
	  <script type="text/javascript">
AC_AX_RunContent( 'width','640','height','385','src','http://www.youtube.com/v/RBq8r23-e5A?fs=1&hl=en_US','type','application/x-shockwave-flash','allowscriptaccess','always','allowfullscreen','true','movie','http://www.youtube.com/v/RBq8r23-e5A?fs=1&hl=en_US' ); //end AC code
</script><noscript><object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/RBq8r23-e5A?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/RBq8r23-e5A?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed></object></noscript>

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
