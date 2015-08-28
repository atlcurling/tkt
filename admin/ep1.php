<?php

	require_once("../settings2.php");
	require_once("{$TKTDIR}user.php");
	session_start();

	require_once('include.php');

// tkt0.1
	require_once("{$TKTDIR}functions.php");
	require_once("{$TKTDIR}database.php");

// lib
	require_once("DynHtmlPage2.php");
	require_once("DynHtmlBlock2.php");

	$pageName = "Funk";
	$debug = 0;

	DynHtmlPage::docHeader($pageName);

	echo "<div class='colmask leftmenu'>\n";

	DynHtmlPage::header();

	loginprompt();
	dbconnect();

	$page = new DynHtmlPage($pageName);
	$page->load($pageName);

	$col = 120;
	echo "<h4>Editing Page \"$pageName\"</h4>\n";
	$page->displayEditForm(true, "", NULL, $col - 8, 4);
	foreach ($page->block as $block) $block->displayEditForm(true, "", NULL, $col);
	
	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
