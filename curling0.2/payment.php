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
	<title>ATLcurling: Payment</title>
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

		<?php
		
		$debugmode = "production";
		
		function payPalButton($baseurl, $hosted_button_id, $memberFieldName)
		{
			echo "<form action=\"$baseurl/cgi-bin/webscr\" method=\"post\">\n";
#			echo "<input type='hidden' name='business' value='atlcurling@gmail.com'>\n";
			echo "<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">\n";
#			echo "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n";
			echo "<input type=\"hidden\" name=\"hosted_button_id\" value=\"$hosted_button_id\">\n";
			echo "<table>\n";
			echo "<tr><td>\n";
			echo "<input type=\"hidden\" name=\"on0\" value=\"Member Name\">$memberFieldName\n";
			echo "</td><td rowspan=\"2\">\n";
			echo "<input type=\"image\" src=\"https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif\" ";
			echo "border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\">\n";
			echo "<img alt=\"\" border=\"0\" src=\"https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\">\n";
			echo "</td></tr><tr><td>\n";
			echo "<input type=\"text\" name=\"os0\" maxlength=\"60\">\n";
#			echo "<input type='hidden' name='amount' value='127.50'>\n";
			echo "</td></tr>\n";
			echo "</table>\n";
			echo "</form>\n";
		}
		
		/*
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="AUPURE6SQWTL4">
<table>
<tr><td><input type="hidden" name="on0" value="Member Name">Member Name</td></tr><tr><td><input type="text" name="os0" maxlength="200"></td></tr>
</table>
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
*/
		switch ($debugmode)
		{
			case "sandbox":
				$title = "SANDBOX";
				$baseurl = "https://www.sandbox.paypal.com";
				break;
				
			case "prodtest":
				$title = "PRODTEST";
				$baseurl = "https://www.paypal.com";
				break;
				
			case "production":
				$title = "Payment";
				$baseurl = "https://www.paypal.com";
				break;
		}
		
		echo "<h1>Atlanta Curling Club: $title</h1>\n";
		
		?>

<p>		
<strong>NOTE:</strong> After you complete your payment using PayPal, click <strong>Return to Atlanta Curling Club, Inc.</strong> 
to return to our web site. You can safely ignore the security warning at that point.
</p>
		
<table border=1><tr><td>
2011-2012 Membership<br />
(Now - Dec 31, 2012)
</td><td>
Cost: $100 / year
</td><td>
		<?php
		switch ($debugmode)
		{
			case "sandbox":
				$hosted_button_id = "FRRJHPTT6RSRE";
				break;

			case "prodtest":
				$hosted_button_id = "DK6W5D5VUGZHJ";
				break;
				
			case "production":
				$hosted_button_id = "4ZJYGJGPEWNRG";
				break;
		}		
		payPalButton($baseurl, $hosted_button_id, "Member Name");
		?>
</td></tr>
<!--
<tr><td rowspan="4">
Curling Camp 2010
</td><td>
Adult Member<br />
Cost $100
</td><td>
		<?php		
		switch ($debugmode)
		{
			case "sandbox":
				$hosted_button_id = "XU8DGDQGYJRW6";
				break;

			case "prodtest":
				$hosted_button_id = "HGWH842SDHFEG";
				break;
				
			case "production":
				$hosted_button_id = "4UWGSKBP8B5K4";
				break;
		}
		payPalButton($baseurl, $hosted_button_id, "Member Name");
		?>
</td></tr><tr><td>
Student Member<br />
Cost $80
</td><td>
		<?php
		switch ($debugmode)
		{
			case "sandbox":
				$hosted_button_id = "3NBWKJQFCUDJS";
				break;

			case "prodtest":
				$hosted_button_id = "42S8DMAFV9JQ4";
				break;
				
			case "production":
				$hosted_button_id = "388GNYVBGU9QQ";
				break;
		}
		payPalButton($baseurl, $hosted_button_id, "Member Name");
		?>
</td></tr><tr><td>
Minor Member<br />
Cost $60
</td><td>
		<?php
		switch ($debugmode)
		{
			case "sandbox":
				$hosted_button_id = "XR3HVLGC6D35U";
				break;

			case "prodtest":
				$hosted_button_id = "YK2285BFU2VC2";
				break;
				
			case "production":
				$hosted_button_id = "2C97Y77JNZN54";
				break;				
		}
		payPalButton($baseurl, $hosted_button_id, "Member Name");
		?>
</td></tr><tr><td>
Non-Member<br />
Cost $250
</td><td>
		<?php
		switch ($debugmode)
		{
			case "sandbox":
				$hosted_button_id = "GDV7X4UVNL9SE";
				break;

			case "prodtest":
				$hosted_button_id = "SB77PVM53HH9C";
				break;
				
			case "production":
				$hosted_button_id = "54Q35YQMQ6UDG";
				break;
		}
		payPalButton($baseurl, $hosted_button_id, "Attendee Name");
		?>
</td></tr>
-->
</table>
			
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
