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

	$pageName = "Events";
#	$debug = 1;

	DynHtmlPage::docHeader($pageName);

	echo "<div class='colmask leftmenu'>\n";

	DynHtmlPage::header();

	loginprompt();
	dbconnect();

	echo "<div class='colleft'>\n";
	$page = new DynHtmlPage($pageName);
	$page->load($pageName);
#	$page->display();

	echo "<div class='col1'>\n";
	require_once("{$TKTDIR}logic.eventstatus.php");
	echo "<br/>\n";
	echo "</div><!-- col1 -->\n";

	DynHtmlPage::upcoming();
  	echo "</div><!-- colleft -->\n";
	echo "</div><!-- colmask -->\n";

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();

?>
