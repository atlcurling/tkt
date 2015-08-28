<?php

	require_once("settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('include.php');

// tkt0.2
	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

// lib
	require_once("DynHtmlPage.php");
	require_once("DynHtmlBlock.php");

	$pageName = "Contact Us";
	$debug = 0;

	DynHtmlPage::docHeader($pageName);

?>

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

<?php

	echo "<div class='colmask leftmenu'>\n";

	DynHtmlPage::header();

	loginprompt();
	dbconnect();

	echo "<div class='colleft'>\n";

	$page = new DynHtmlPage($pageName);
	$page->load($pageName);
	$page->displayHeader();

?>
	<div class='my_wrapper my_footer'>
	  <form action="contactus.send.php" method="post" enctype="application/x-www-form-urlencoded" name="contactus" onsubmit="MM_validateForm('Name','','R','Email','','RisEmail');return document.MM_returnValue">
	    <table border=0>
		  <tr><td>
		  	Topic
		  </td><td>
		    <select name="Topic" size="1">
		      <option value="Events">Events</option>
              <option value="Bonspiel">Bonspiel</option>
		      <option value="Membership">Membership</option>
		      <option value="Locations">Locations</option>
		      <option value="Schedule">Schedule</option>
		      <option value="Sponsorship">Sponsorship</option>
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
	</div>

<?php

	$page->displayFooter();

	DynHtmlPage::upcoming();
	echo "</div><!-- colleft -->\n";
	echo "</div><!-- colmask leftmenu -->\n";

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();

?>
