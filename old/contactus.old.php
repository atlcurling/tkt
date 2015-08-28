<?php

	require_once("settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('include.php');


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
	<!-- InstanceEndEditable --><!-- InstanceBeginEditable name="head" -->
	<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
    </script>
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

	  <h1>Atlanta Curling Club: Contact Us</h1>
	  <p>
	  Fill out this form to send us an e-mail -- we'll reply to your e-mail address with whatever information we have!
	  </p>
	  <form action="contactus.send.php" method="post" enctype="application/x-www-form-urlencoded" name="contactus" onsubmit="MM_validateForm('Name','','R','Email','','RisEmail');return document.MM_returnValue">
	    <table border=0>
		  <tr><td>
		  	Topic
		  </td><td>
		    <select name="Topic" size="1">
		      <option value="Membership">Membership</option>
		      <option value="Locations">Locations</option>
		      <option value="Schedule">Schedule</option>
		      <option value="Sponsorship">Sponsorship</option>
		      <option value="Events">Events</option>
		    </select>
		  </td></tr><tr><td>
		    Your Name
		  </td><td>
			<input name="Name" type="text" size="40" maxlength="128" />  
	  	  </td></tr><tr><td>
		  	Your E-mail Address
		  </td><td>
		  	<input name="Email" type="text" size="40" maxlength="128" />
	  	  </td></tr><tr><td>
			Your Message
		  </td><td>
		    <textarea name="Body" cols="60" rows="10"></textarea>
		  </td></tr><tr><td>
		    Prove You're a Human
		  </td><td>
		  <?php
		    require_once('include/recaptcha.incl.php');
		    echo recaptcha_get_html($publickey);
		  ?>
		  </td></tr><tr><td>
		  </td><td>
		  	  <input name="Submit" type="submit" value="Submit" />
		</table>
	  </form>
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
