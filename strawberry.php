
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

	$pageName = "Strawberry";
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

?>
<div style="color: white; background-color: red;">
<table border=1>
<tr><th>index</th><th>square</th><th>cube</th></tr>
<tr><td>1</td><td>1</td><td>1</td></tr>
<tr><td>2</td><td>4</td><td>8</td></tr>
<tr><td>3</td><td>9</td><td>27</td></tr>
<tr><td>4</td><td>16</td><td>64</td></tr>
</table>
</div>
<br/>
<?

	print "</div></div>\n";
	$page->displayFooter();

	DynHtmlPage::upcoming();
	echo "</div><!-- colleft -->\n";
	echo "</div><!-- colmask leftmenu -->\n";

	DynHtmlPage::footer();
	DynHtmlPage::docFooter();
?>
