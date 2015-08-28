<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="Templates/base.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Untitled Document</title>
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
	<li><a href="schedule.php"><img src="image/BlueCurlingStone20L.png"/>Schedule</a></li>
	<li><a href="http://bit.ly/atlcurling"><img src="image/RedCurlingStone20L.png"/>Facebook</a></li>
	<li><a href="http://atlcurling.wikia.com"><img src="image/BlueCurlingStone20L.png"/>Wiki</a></li>
	<li><a href="contactus.php"><img src="image/RedCurlingStone20L.png"/>Contact Us</a></li>
  </ul>
</div>
<div class="colmask leftmenu">
  <div class="colleft">
    <div class="col1"> 
	  <!-- InstanceBeginEditable name="body" -->
      <?php	  
		echo "<ul>";
		echo "<li>Topic: " . $_POST["Topic"] . "</li>";
		echo "<li>Name: " . $_POST["Name"] . "</li>";
		echo "<li>Email: " . $_POST["Email"] . "</li>";
		echo "<li>Body: " . $_POST["Body"] . "</li>";
/* 		echo "<li>recaptcha_challenge_field: " . $_POST["recaptcha_challenge_field"] . "</li>";
		echo "<li>recaptcha_response_field: " . $_POST["recaptcha_response_field"] . "</li>";
 */		echo "</ul>";

		require_once("include/recaptcha.incl.php");
		$resp = recaptcha_check_answer ($privatekey,
			$_SERVER["REMOTE_ADDR"],
			$_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
		
		if ($resp->is_valid) 
		{
			echo "You got the reCAPTCHA! Aren't you talented.";
		}
		else
		{
			echo "Sorry, that wasn't right, please try again!\n";
			echo "<form action='sendcontactus.php' method='post' enctype='application/x-www-form-urlencoded' name='contactus'>\n";

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
      <!-- InstanceBeginEditable name="links" -->
	  links
	  <!-- InstanceEndEditable -->	
      <div id="Title">
		Upcoming Events
	</div>
    <!-- #BeginLibraryItem "/Library/upcoming.lbi" -->
<strong><a href="http://atlcurling.wikia.com/wiki/Curling_Camp_2010">Curling Camp</a></strong><br/>
<i>July 31 - August 1</i><br/>
Atlanta Curling Club's first official activity! Come curling with us in Knoxville.  Includes two &quot;Learn to Curl&quot; sessions and two games of curling.
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
		<a href="schedule.php">Schedule</a> &nbsp; -- &nbsp; 
		<a href="http://bit.ly/atlcurling">Facebook</a> &nbsp; -- &nbsp; 
		<a href="http://atlcurling.wikia.com">Wiki</a> &nbsp; -- &nbsp; 
		<a href="contactus.php">Contact Us</a>
	</p>
	<p>Curl with us soon! Copyright &copy; 2010 Atlanta Curling Club, Inc., All Rights Reserved</p>
</div><!-- Footer -->
</div><!-- Page -->
</body>
<!-- InstanceEnd --></html>
