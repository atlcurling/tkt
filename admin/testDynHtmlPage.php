<html><style>
table	{border: 1px black solid; max-width: 1000px;}
td		{white-space: pre-wrap; font-family: monospace;}
label	{color: green;}
input	{font-family: monospace;}
</style>

<?php

require_once("../settings.php");
#require_once("../tkt0.1/functions.php");
require_once("../tkt0.1/database.php");
require_once("../lib/DynHtmlPage.php");
require_once("../lib/DynHtmlBlock.php");

dbconnect();

echo "<title>{$_SERVER['REQUEST_URI']}</title>\n";
echo "<h1>{$_SERVER['REQUEST_URI']}</h1>";

?>

</head>
<body>

<?php

// Debug output functions

function printTestName($methodName) {
	echo "<h4>$methodName</h4>\n";
}

function printBox($any) {
	echo "<table><tr><td>";
	print_r($any);
	echo "</td></tr><table>\n";
}

// Method tests

printTestName("__construct()");
$page = new DynHtmlPage("Membership");
printBox($page);

printTestName("initFromPost()");
$page->initFromPost();
printBox($page);

printTestName("load()");
$page->load("Membership");
printBox($page);

printTestName("save()");
echo "<p><i>Not implemented.</i></p>\n";

printTestName("render()");
$page->render();
printBox($page);

printTestName("display()");
$page->display();

printTestName("displayEditForm()");
echo "<h5>read-write with multiple buttons</h5>\n";
$page->displayEditForm(false, ["Add", "Change", "Delete"], NULL, 40, 10);
echo "<h5>read-write with Change button</h5>\n";
$page->displayEditForm(false, "Change");
echo "<h5>readonly with Delete button</h5>\n";
$page->displayEditForm(true, "Delete", NULL, 80, 16);
echo "<h5>readonly with no button</h5>\n";
$page->displayEditForm(true, "", NULL, 120, 4);

// Debug data

echo "<hr/>\n";
echo "<h3>\$_POST</h3><pre>\n";
print_r($_POST);
echo "</pre>\n";

?>

</body>
</html>
