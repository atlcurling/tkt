<?php

	require_once("settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('include.php');

	require_once('faq/printOneBigFaq.php');

// tkt0.2
	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

// lib
	require_once("DynHtmlPage.php");
	require_once("DynHtmlBlock.php");

	$prevPage = "eventorder.php";

	$pageName = "Event Order";
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
	print "<div class='my_wrapper'><div class='my_footer'>\n";

	require_once("{$TKTDIR}logic.eventorder.php");

	print "</div></div>\n";
	$page->displayFooter();

	DynHtmlPage::upcoming();
	echo "</div><!-- colleft -->\n";
	echo "</div><!-- colmask leftmenu -->\n";

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
