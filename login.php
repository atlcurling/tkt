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

	$pageName = "Login";
	$page = "login.php";
	$debug = 0;

	DynHtmlPage::docHeader($pageName);

	echo "<div class='colmask leftmenu'>\n";

	DynHtmlPage::header();

	dbconnect();

	echo "<div class='colleft'>\n";

	$p = new DynHtmlPage($pageName);
	$p->load($pageName);
	$p->title = "";

	$p->displayHeader();

	require_once("{$TKTDIR}logic.login.php");

	$p->displayFooter();

	DynHtmlPage::upcoming();
	echo "</div><!-- colleft -->\n";

	echo "</div><!-- colmask leftmenu -->\n";

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
