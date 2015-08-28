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

	$pageName = "Contact Us Sent";
	$debug = 0;

	DynHtmlPage::docHeader($pageName);

	echo "<div class='colmask leftmenu'>\n";

	DynHtmlPage::header();

	loginprompt();
	dbconnect();

	echo "<div class='colleft'>\n";

	$page = new DynHtmlPage($pageName);
	$page->load($pageName);
	$page->displayHeader();

?>
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


	$page->displayFooter();
	DynHtmlPage::upcoming();
	echo "</div><!-- colleft -->\n";

	echo "</div><!-- colmask leftmenu -->\n";

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();

?>
