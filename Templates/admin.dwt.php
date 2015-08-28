<?php

	require_once("settings.php");
	require_once("{$TKTDIR}user.php");
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php

require_once('include.php');
require_once("{$TKTDIR}functions.php");
require_once("{$TKTDIR}database.php");

?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!-- TemplateBeginEditable name="doctitle" -->
	<title>Untitled Document</title>
	<!-- TemplateEndEditable --><!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
	<link href="../style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="../favicon.ico" />
</head>
<body>
<div id="Page">
<div id="Header">
  <img src="../image/CurlingSheetTitle.png" />
  <ul>
	<li><a href="index.php"><img src="../image/BlueCurlingStone20L.png"/>Home</a></li>
	<li><a href="aboutus.php"><img src="../image/RedCurlingStone20L.png"/>About Us</a></li>
	<li><a href="joinus.php"><img src="../image/BlueCurlingStone20L.png"/>Join Us</a></li>
	<li><a href="eventstatus.php"><img src="../image/RedCurlingStone20L.png"/>Events</a></li>
	<li><a href="leagues.php"><img src="../image/BlueCurlingStone20L.png"/>Leagues</a></li>
	<li><a href="photos.php"><img src="../image/RedCurlingStone20L.png" />Photos and Video</a></li>
	<li><a href="pubs.php"><img src="../image/BlueCurlingStone20L.png" />Publications</a></li>
	<li><a href="media.php"><img src="../image/RedCurlingStone20L.png" />Media</a></li>
	<li><a href="schedule.php"><img src="../image/BlueCurlingStone20L.png"/>Schedule</a></li>
	<li><a href="http://bit.ly/atlcurling"><img src="../image/RedCurlingStone20L.png"/>Facebook</a></li>
	<li><a href="http://atlcurling.wikia.com/wiki/Atlanta_Curling_Wiki"><img src="../image/BlueCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="contactus.php"><img src="../image/RedCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
	  <!-- TemplateBeginEditable name="body" -->


	  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et ligula a augue dignissim commodo vel a nunc. Ut ac sem eget tellus molestie molestie. Nullam sit amet urna metus, ut blandit erat. Nam sed arcu ut sem facilisis eleifend. Fusce eget turpis sed dolor tincidunt mattis. Aliquam dictum varius nunc, non ornare nunc aliquet sit amet. Nam eu luctus dui. Vestibulum nec nibh justo. Phasellus ornare placerat consequat. Praesent posuere mauris vitae metus volutpat in semper nibh luctus. Curabitur fringilla nisl in lorem consequat egestas. Integer porttitor viverra diam, id bibendum nulla sodales in. Mauris interdum sapien sed lacus condimentum blandit. Phasellus est dui, scelerisque vitae semper eu, volutpat ut nunc. Aliquam sit amet justo est, eu condimentum quam. Curabitur pharetra laoreet ligula sit amet blandit. 
	  
	  
	  <!-- TemplateEndEditable -->
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
</html>
