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
	<title>ATLcurling: Contact Us</title>
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

	  <h1>Contact Us</h1>

      <?php	  
		if ($debug)
		{
			echo "<ul>";
			echo "<li>Topic: " . $_POST["Topic"] . "</li>";
			echo "<li>Name: " . $_POST["Name"] . "</li>";
			echo "<li>Email: " . $_POST["Email"] . "</li>";
			echo "<li>Body: " . $_POST["Body"] . "</li>";
			echo "</ul>";
		}

		require_once("include/recaptcha.incl.php");
		$resp = recaptcha_check_answer ($privatekey,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
		
		if ($resp->is_valid) 
		{
			echo "<h3>Your message has been sent!</h3>";
			
			mail("atlcurling@gmail.com", "ATLcurling.org: {$_POST['Topic']}",
				"Message from {$_POST['Name']} <{$_POST['Email']}>\n" . wordwrap($_POST['Body'], 70) . "\n",
				"From: {$_POST['Email']}");
		}
		else
		{
			echo "<h3>Sorry, that wasn't right, please try again!</h3>\n";
			echo "<form action='contactus.send.php' method='post' enctype='application/x-www-form-urlencoded' name='contactus'>\n";

		    echo recaptcha_get_html($publickey, $resp->error);
			
			echo "<input type='hidden' name='Topic' value='{$_POST['Topic']}'>\n";
			echo "<input type='hidden' name='Name' value='{$_POST['Name']}'>\n";
			echo "<input type='hidden' name='Email' value='{$_POST['Email']}'>\n";
			echo "<input type='hidden' name='Body' value='{$_POST['Body']}'>\n";
			
		  	echo "<input name='Submit' type='submit' value='Submit' />\n";
			echo "</form>\n";
		}


	  ?>
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
