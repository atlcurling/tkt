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

	$pageName = "Signup Cancelled";
	$debug = 0;

	DynHtmlPage::docHeader($pageName);

	echo "<div class='colmask leftmenu'>\n";

	DynHtmlPage::header();

	loginprompt();
	dbconnect();

	echo "<div class='colleft'>\n";

	$page = new DynHtmlPage($pageName);
	$page->load($pageName);
	$page->display();

	DynHtmlPage::upcoming();
	echo "</div><!-- colleft -->\n";
	echo "</div><!-- colmask leftmenu -->\n";

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
