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
	  
	  <center><h1>Check Your Totals</h1></center> 
	  <?php
	    $debug = 1;
	  
		echo "<ul>\n";
		echo "<li>Name: {$_POST['FIRSTNAME']} {$_POST['LASTNAME']}</li>\n";
		echo "<li>Daytime Phone: {$_POST['DAYPHONE']}</li>\n";
		echo "<li>Evening Phone: {$_POST['EVENINGPHONE']}</li>\n";
		echo "<li>E-mail Address: {$_POST['EMAIL']}</li>\n";
		echo "</ul>\n";
		
		$payingmembership = array_key_exists("Membership", $_POST);
		$membershipamt = $payingmembership ? 100 : 0;
		
		$payingcurlingcamp = array_key_exists("CurlingCamp", $_POST);
		$curlingcamplevel = $_POST["CurlingCampLevel"];
		
		$curlingcampamt = 0;
		if ($payingcurlingcamp) switch ($curlingcamplevel)
		{
			case "adult":		$curlingcampamt = 100; break;
			case "student": 	$curlingcampamt = 80; break;
			case "minor":		$curlingcampamt = 60; break;
			case "non-member":	$curlingcampamt = 250; break;
		}
		
		$totalamt = $membershipamt + $curlingcampamt;
		
		if ($payingmembership)
		{
			echo "<p>You have selected to pay for your membership ($$membershipamt).</p>\n";

			if ($payingcurlingcamp)
			{
				if ($curlingcamplevel != "non-member")
				{
					echo "<p>You have selected to pay for Curling Camp at the \"$curlingcamplevel\" level ($$curlingcampamt).</p>\n";
				} else {
					echo "<div class='error'>";
					echo "ERROR: You should not pay for Curling Camp at the Non-member level since you are joining the club.";
					echo "</div>\n";
					$totalamt = 0;
				}
			} else {
				echo "<div class='warning'>";
				echo "NOTE: You have selected not to pay for Curling Camp.";
				echo "</div>\n";
			}
		}
		else 
		{
			echo "<div class='warning'>";
			echo "NOTE: You have not selected to pay for your membership. ";
			echo "You should only continue if you are not intending to become a member ";
			echo "or have paid for your membership using other means.";
			echo "</div>\n";

			if ($payingcurlingcamp)
			{
				echo "<p>You have selected to pay for Curling Camp at the \"$curlingcamplevel\" level ($$curlingcampamt).</p>\n";

				if ($curlingcamplevel != "non-member")
				{
					echo "<div class='warning'>";
					echo "WARNING: You are not eligible to enroll for Curling Camp at the ";
					echo "\"$curlingcamplevel\" level ($$curlingcampamt) ";
					echo "unless you have already paid for your membership. ";
					echo "You should only continue if this is the case.";
					echo "</div>\n";
				}
			}
			else
			{
				echo "<div class='notice'>";
				echo "NOTE: You have selected not to pay for Curling Camp.";
				echo "</div>\n";
			}
		}
		
		echo "</ul>\n";
		
		if ($totalamt) echo "<p>Your total will be $$totalamt.</p>\n";

		echo "<table cellpadding=4px><tr valign='top'><td>\n";
		echo "<form action=\"signup.review.php\" method=\"post\">\n";
		if ($totalamt)
		{
			echo "<input type=\"image\" name=\"submit\" src=\"https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif\" />\n";
			echo "</td><td>\n";
		}
		echo "<input name=\"Back\" value=\"Change My Payments\" type=\"button\" onClick=\"history.go(-1)\" />\n";
		
		echo "<input name=\"FIRSTNAME\" type=\"hidden\" value=\"{$_POST['FIRSTNAME']}\" />\n";
		echo "<input name=\"LASTNAME\" type=\"hidden\" value=\"{$_POST['LASTNAME']}\" />\n";
		echo "<input name=\"DAYPHONE\" type=\"hidden\" value=\"{$_POST['DAYPHONE']}\" />\n";
		echo "<input name=\"EVENINGPHONE\" type=\"hidden\" value=\"{$_POST['EVENINGPHONE']}\" />\n";
		echo "<input name=\"EMAIL\" type=\"hidden\" value=\"{$_POST['EMAIL']}\" />\n";
		
		$i = 0;
		
		if ($payingmembership)
		{
			echo "<input name=\"L_NAME$i\" type=\"hidden\" value=\"Membership\">\n";
			echo "<input name=\"L_AMT$i\" type=\"hidden\" value=\"$membershipamt\">\n";
			echo "<input name=\"L_QTY$i\" type=\"hidden\" value=\"1\">\n";
			$i ++;
		}
		
		if ($payingcurlingcamp)
		{
			echo "<input name=\"L_NAME$i\" type=\"hidden\" value=\"Curling Camp: $curlingcamplevel\">\n";
			echo "<input name=\"L_AMT$i\" type=\"hidden\" value=\"$curlingcampamt\">\n";
			echo "<input name=\"L_QTY$i\" type=\"hidden\" value=\"1\">\n";
			$i ++;
		}
		
		echo "</form>\n";
		echo "</td><tr></table>\n";

		if (debug)
		{
	    	echo "<hr/>\n";
	  		echo "<h3>_POST</h3><pre>";
	  		print_r($_POST);
			echo "</pre>\n";
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
