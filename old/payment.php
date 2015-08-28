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
<strong>NOTE:</strong> Online payment for membership is currently unavailable.
<!--
<strong>NOTE:</strong> After you complete your payment using PayPal, click <strong>Return to Atlanta Curling Club, Inc.</strong> 
to return to our web site. You can safely ignore the security warning at that point.
-->
</p>
<!--		
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
#		payPalButton($baseurl, $hosted_button_id, "Member Name");
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
#		payPalButton($baseurl, $hosted_button_id, "Member Name");
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
#		payPalButton($baseurl, $hosted_button_id, "Member Name");
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
#		payPalButton($baseurl, $hosted_button_id, "Member Name");
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
#		payPalButton($baseurl, $hosted_button_id, "Attendee Name");
		?>
</td></tr>
</table>
	-->		
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
