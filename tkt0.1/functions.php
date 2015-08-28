<?php

function heading ($title)
{
  echo "<title>$title</title>";
}

function warning ($msg)
{
  echo "<span class='warnmsg'>$msg</span>";
}

function error ($msg)
{
  echo "<span class='errmsg'>$msg</span>";
}

function nb_top ()
{
  global $site, $siteuri;
  echo "<a class='navbar' href='$siteuri'>$site</a>\n";
}

function nb_level1 ($l1tag, $l1url)
{
  echo " &lt; <a class='navbar' href='$l1url'>$l1tag</a>\n";
}

function nb_level2 ($l1tag, $l1url, $l2tag, $l2url)
{
  nb_level1($l1tag, $l1url);
  echo " &lt; <a class='navbar' href='$l2url'>$l2tag</a>\n";
}

function heading_nb_top ()
{
	global $site, $siteuri;

	echo "<a href='$siteuri'>";
	heading($site);
	nb_top();
}

function heading_nb_level1 ($l1tag, $l1url)
{
	global $site, $siteuri;

	echo "<a href='$siteuri'>";
	heading($site . " &lt; " . $l1tag);
	nb_top();
	nb_level1($l1tag, $l1url);
}

function heading_nb_level2 ($l1tag, $l1url, $l2tag, $l2url)
{
	global $site, $siteuri;

	echo "<a href='$siteuri'>";
	heading($site . " &lt; " . $l1tag . " &lt; " . $l2tag);
	nb_top();
	nb_level2($l1tag, $l1url, $l2tag, $l2url);
}

function getvalue($key, $default = "")
{
	return(array_key_exists($key, $_GET)) ? $_GET[$key] : $default;
}

function postvalue($key, $default = "")
{
	return(array_key_exists($key, $_POST)) ? $_POST[$key] : $default;
}

function h1($s) { echo "<h1>$s</h1>\n"; }

function dispdebugelem($varname, $var) {
	echo "<td class='debug'><h5>$varname</h5>\n";
	echo "<pre>";
	print_r($var);
	echo "</pre></td>\n";
}

function dispdebug()
{
	global $debug;
 
	if ($debug)
	{
		echo "<div style='height: 64px'></div>\n";
		echo "<table class='debug'><tr>\n";
		dispdebugelem("_GET", $_GET);
		dispdebugelem("_POST", $_POST);
		if (isset($_SESSION)) dispdebugelem("_SESSION", $_SESSION);
		echo "</tr><tr>\n";
		echo "<td></td>\n";
		dispdebugelem("_SERVER['REQUEST_URI']", $_SERVER['REQUEST_URI']);
		dispdebugelem("_SERVER", $_SERVER);
		echo "</tr></table>\n";
	}
}

function loginprompt($setprevpage = true) {
	$class = (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7')) ? 'loginprompt-ie7' : 'loginprompt';
	echo "<span class='$class'>";
	
	if (isset($_SESSION) && array_key_exists("user", $_SESSION)) {
		$user = $_SESSION["user"];
		$firstnm = $_SESSION["user"]->firstnm;
		$firstnm = $user->firstnm;
		echo "Hello $firstnm (<a href='login.php?action=logout' class='loginprompt'>log out</a>)";
	} else {
		echo "<a href='login.php' class='loginprompt'>login / register</a>";
	}
	echo "</span>\n";

	if ($setprevpage) $_SESSION["prevpage"] = $_SERVER["REQUEST_URI"];
}

?>

