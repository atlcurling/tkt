<?php

require_once("{$TKTDIR}user.php");
require_once("Post.php");

class DynHtmlPage {

	public $ppagenm = '';
	public $pagenm = '';

	public $ptitle = '';
	public $title = '';

	public $pintroRaw = '';
	public $introRaw = '';
	public $introRendered = '';

	public $rendered = '';

	public $block;

	public static function docHeader($pageName) {
		global $BASEDIR, $IMGDIR;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>ATLcurling: <?= $pageName ?></title>
	<link href="<?= $BASEDIR ?>style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<div id='Page'>
<?php
	}

	public static function docFooter() {
		echo "</div><!-- Page -->\n";
		dispdebug();
		echo "</body>\n";
		echo "</html>\n";
	}

	public static function menu ($istop) {
		global $BASEDIR, $IMGDIR;

		$m = array(
			array("Home", 			"index.php",			0),
			array("FAQ", 			"faq.php",				0),
			array("About Us", 		"aboutus.php",			0),
			array("Membership", 	"joinus.php",			0),
			array("Events", 		"eventstatus.php",		0),
			array("Leagues", 		"leagues.php",			0),
			array("Photos", 		"photos.php",			0),
			array("Publications",	"pubs.php",				0),
			array("Media", 			"media.php",			0),
			array("Calendar", 		"calendar.php",			0),
			array("Wiki", 			"/wiki",				0),
			array("Contact Us", 	"contactus.php",		0),
			array("Reports",		"reports/index.php",	1));
			
		echo "<div id='Header'>\n";
		echo "<img src='{$IMGDIR}CurlingSheetTitle.png'/>\n";

		echo "<ul>\n";
		$i = 0;
		foreach ($m as $e) {
			if (! $e[2] || ($e[2] && User::isAdmin())) {
				$url = $BASEDIR . $e[1];
				$img = $IMGDIR . 
					(($i % 2 == 0) ? "Blue" : "Red") . 
					"CurlingStone20L.png";
				$label = $e[0];
				echo "<li><a href='$url'><img src='$img'/>$label</a></li>\n";
				$i ++;
			}
		}
		echo "</ul>\n";

		echo "</div>\n";
	}

	public static function header() {
		DynHtmlPage::menu(true);
	}


	public static function upcoming() {
		echo "<div class='col2'>\n";
		echo "	<div id='Title'>Upcoming Events</div>\n";

		dbconnect();

		$sql = 
			"SELECT eventcd, eventgrouped, eventnm, DATE_FORMAT(eventdt, '%a %b %e, %Y') dt, " .
			"    TIME_FORMAT(advstarttm, '%l:%i %p') tm, description " .
			"  FROM event " .
			"  WHERE eventdt >= CURDATE() " .
			"    AND active " .
			"  ORDER BY eventdt, advstarttm ";
			
		$result = mysql_query($sql);
		$preveventcdpfx = '';
		while ($row = mysql_fetch_object($result)) {
			$eventcdpfx = substr($row->eventcd, 0, strlen($row->eventcd) - 1);
			if (! $row->eventgrouped || ($row->eventgrouped && $preveventcdpfx != $eventcdpfx)) {
				echo "  <div class='event'>\n";
				echo "    <div id='event-title'>$row->eventnm</div>\n";
				echo "    <div id='event-datetime'>$row->dt @ $row->tm</div>\n";
				echo "    <div id='event-detail'>$row->description</div>\n";
				echo "  </div>\n";
				$preveventcdpfx = $eventcdpfx;
			}
		}
		echo "</div><!-- col2 -->\n";
	}

	public static function footer() {
?>
<div id="Footer">
    <p>
		<a href="index.php">Home</a> &nbsp; -- &nbsp; 
		<a href="faq.php">FAQ</a> &nbsp; -- &nbsp; 
		<a href="aboutus.php">About Us</a> &nbsp; -- &nbsp; 
		<a href="joinus.php">Membership</a> &nbsp; -- &nbsp; 
		<a href="eventstatus.php">Events</a> &nbsp; -- &nbsp; 
		<a href="leagues.php">Leagues</a> &nbsp; -- &nbsp; 
		<a href="photos.php">Photos</a> &nbsp; -- &nbsp; 
		<a href="pubs.php">Publications</a> &nbsp; -- &nbsp; 
		<a href="media.php">Media</a> &nbsp; -- &nbsp; 
		<a href="schedule.php">Calendar</a> &nbsp; -- &nbsp; 
		<a href="/wiki" target="_blank">Wiki</a> &nbsp; -- &nbsp; 
		<a href="contactus.php">Contact Us</a>

	</p>
	<p>Curl with us! Copyright &copy; 2012 Atlanta Curling Club, Inc., All Rights Reserved</p>
</div><!-- Footer -->
<?php
	}

	function __construct($pagenm = "unknown") {
		$this->init($pagenm);
	}

	public function init($pagenm) {
		$this->pagenm = $pagenm;
		$this->title = "Atlanta Curling Club: $pagenm";
	}

	public function initFromPost() {
		$this->ppagenm = Post::value("ppagenm");
		$this->pagenm = Post::value("pagenm");
		$this->ptitle = Post::value("ptitle");
		$this->title = Post::value("title");
		$this->pintroRaw = Post::value("pintro");
		$this->introRaw = Post::value("intro");
	}

	public function load($pagenm) {
		$apagenm = $pagenm ? $pagenm : $this->pagenm;

		$sql = "SELECT title, intro " . 
			"FROM page " .
			"WHERE pagenm = '$apagenm';";
		$result = mysql_query($sql) or die("load() failed. " . mysql_error());
		$row = mysql_fetch_object($result);

		$this->title = "Atlanta Curling Club: $row->title";
		$this->introRaw = $row->intro;
		
		mysql_free_result($result);

		$sql = "SELECT b.seq, b.header, b.left, b.right, b.bottom " .
			"FROM block b " .
			"WHERE pagenm = '$apagenm' " .
			"ORDER BY seq;";
		$result = mysql_query($sql) or die("load() of blocks failed. " .
			mysql_error());
		while ($row = mysql_fetch_object($result)) {
			$this->block[] = new DynHtmlBlock($this->pagenm, $row->seq, 
				$row->header, $row->left, $row->right, $row->bottom);
		}

		mysql_free_result($result);
	}

	public function save() {
		$sql = "REPLACE INTO page (pagenm, title, intro) " . 
			"VALUES ('$this->pagenm', '$this->title', '$this->intro');";
		$result = mysql_query($sql) or die("save() failed. " . mysql_error());
		mysql_free_result($result);
	}

	public function delete() {
		$sql = "DELETE FROM page WHERE pagenm = '$pagenm';";
		$result = mysql_query($sql) or die("delete() failed. " . mysql_error());
		mysql_free_result($result);
	}

	public function render() {
		$this->introRendered .= $this->introRaw;

		$this->rendered = "";

		$this->rendered .= "<h1>$this->title</h1>\n";
		if ($this->introRendered) {
			$this->rendered .= "<div class='my_wrapper'>\n";
			$this->rendered .= "<div class='my_footer'>$this->introRendered</div><!-- my_footer -->\n";
			$this->rendered .= "</div><!-- my_wrapper -->\n";
		}

		return $this->rendered;
	}

	public function displayHeader() {
		print "<div class='col1'>\n";
		if (! $this->rendered) $this->render();
		print $this->rendered;
	}

	public function displayFooter() {
		print "</div><!-- col1 -->\n";
	}

	public function display() {
		$this->displayHeader();
		foreach ($this->block as $block) $block->display();
		$this->displayFooter();
	}

	public function displayEditForm($readonly = 0, $submit = "Submit", $url = "", $cols = 60, $rows = 12) {
		$ro = $readonly ? "readonly" : "";

		print "<form action='$url' method='post'>\n";

		print "<input type='hidden' name='ppagenm' value='$this->pagenm'>\n";
		print "<input type='hidden' name='ptitle' value='$this->title'>\n";
		print "<input type='hidden' name='pintro' value='$this->introRaw'>\n";

		print "<table>\n";
		print "<tr><td><label>pagenm</label></td><td><input type='text' name='pagenm' size=16 $ro value='$this->pagenm'></td></tr>\n";
		print "<tr><td><label>title</label></td><td><input type='text' name='title' size=64 $ro value='$this->title'></td></tr>\n";
		print "<tr><td><label>intro</label></td><td><textarea cols=$cols rows=$rows name='intro' $ro>\n";
		print "$this->introRaw\n";

		print "</textarea></td></tr>\n";
		if ($submit) {
			print "<tr><td colspan=2 style='text-align: center;'>\n";
			if (is_array($submit)) {
				foreach ($submit as $i => $button) {
					if ($i > 0) print "&nbsp;";
					print "<input type='submit' name='$button' value='$button'>";
				}
			} else {
				print "<input type='submit' name='$submit' value='$submit'>\n";
			}
			print "</td></tr>\n";
		}
		print "</table>\n";
		print "</form>\n";
	}
		
}
