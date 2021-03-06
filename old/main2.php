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

	$pageName = "Home Page";
	$debug = 0;

	DynHtmlPage::docHeader($pageName);
	
	echo "<div class='colmask leftmenu'>\n";

	DynHtmlPage::header();

	loginprompt(); 
	dbconnect();
	
	echo "<meta property='fb:admins' content='100000225422795' />\n";
 	echo "<div class='colleft'>\n";

	$page = new DynHtmlPage($pageName);
	$page->load($pageName);
	$page->displayHeader();

	foreach($page->block as $block) 
		if ($block->seq < 1000) 
			$block->display();
	
# Database functions
	function getEventTypeMinDate($eventcdptrn) {
		$sql = "SELECT MIN(eventdt) ed FROM event where eventcd LIKE '$eventcdptrn' AND active AND eventdt >= CURDATE()";
		return dbgetsingleton($sql, "ed");
	}

	function getEventTypeCount($eventcdptrn) {
		$sql = "SELECT COUNT(*) cnt FROM event WHERE eventcd LIKE '$eventcdptrn' AND active AND eventdt >= CURDATE()";
		return dbgetsingleton($sql, "cnt");
	}

	function makeEventQuery($eventcdptrn) {
		return "SELECT DATE_FORMAT(e.eventdt, '%a %b %e, %Y') edt, 
					TIME_FORMAT(e.advstarttm, '%l:%i %p') etm, 
					TIME_FORMAT(e.teardowntm, '%l:%i %p') etmend, 
					e.mbrprice, e.guestprice 
				FROM `event` e 
				WHERE e.eventcd LIKE '$eventcdptrn' AND active AND CURDATE() <= e.eventdt 
				ORDER BY e.eventdt";
	}

# Event printing functions
	
	function printOpenCurling() {
		$b = new DynHtmlBlock();
		$b->leftRaw = "<img align='left' width=400 height=256 src='image/Tatem.delivery.jpeg' />";
			
		$eventcdptrn = "OC%";

		if (getEventTypeCount($eventcdptrn) > 0) {
			$sql = makeEventQuery($eventcdptrn);
			
			$res = mysql_query($sql)
				or die("Error during event select. " . mysql_error());
			$ix = 0;
			
			while ($row = mysql_fetch_object($res)) {
				if ($ix == 0) {
					$b->header = "Open Curling on $row->edt";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "The curling season continues in Atlanta! ";
					$b->rightRaw .= "Our next Open Curling event is scheduled for <strong>$row->edt at $row->etm</strong>. ";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "The member price is \$$row->mbrprice, and the event is \$$row->guestprice for non-members. ";
					$b->rightRaw .= "All are welcome -- we will have some capability for teaching first-timers. ";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "Sign up for Open Curling is online. ";
					$b->rightRaw .= "Make sure you <a href='login.php'>Login or Register</a> and then go to the ";
					$b->rightRaw .= "<a href='eventstatus.php'>Events page</a> to sign up and pay for upcoming sessions. ";
					$b->rightRaw .= "</p>";
				} else {
					if ($ix == 1) {
						$b->bottomRaw .= "<p>Remaining dates for Open Curling:\n";
						$b->bottomRaw .= "<ul>\n";
					}
					$b->bottomRaw .= "<li>$row->edt at $row->etm</li>\n";
				}

				$ix ++;
			}
			
			if ($ix > 1) {
				$b->bottomRaw .= "</ul>\n";
				$b->bottomRaw .= "See the <a href='eventstatus.php'>Events page</a> for more details and signup.</p>\n";
			}
						
			$b->display();
		}
	}
	
	function printLearnToCurl () {
		$b = new DynHtmlBlock();
		$b->leftRaw = "<img align='left' width=400 height=256 src='image/Maxwell.delivery.jpeg' />";

		$eventcdptrn = "LTC%";

		if (getEventTypeCount($eventcdptrn) > 0) {
			$sql = makeEventQuery($eventcdptrn);
			
			$res = mysql_query($sql)
				or die("Error during event select. " . mysql_error());
			$ix = 0;

			while ($row = mysql_fetch_object($res)) {
				if ($ix == 0) {
					$b->header = "Learn to Curl on $row->edt";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "We want to teach you the great sport of curling and we have an event specifically designed for doing so. ";
					$b->rightRaw .= "Our next Learn to Curl is scheduled for <strong>$row->edt at $row->etm</strong>. ";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= ($row->mbrprice == $row->guestprice) ?
						"The price for this event is \$$row->guestprice. " :
						"The member price is \$$row->mbrprice, and the event is \$$row->guestprice for non-members. ";
					$b->rightRaw .= "All are welcome -- no experience is necessary. ";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "We recommend signing up for Learn to Curls online since they can fill quickly. ";
					$b->rightRaw .= "Make sure you <a href='login.php'>Login or Register</a> and then go to the ";
					$b->rightRaw .= "<a href='eventstatus.php'>Events page</a> to sign up and pay. ";
					$b->rightRaw .= "</p>";
				} else {
					if ($ix == 1) {
						$b->bottomRaw .= "<p>Remaining Learn to Curls:\n";
						$b->bottomRaw .= "<ul>\n";
					}
					$b->bottomRaw .= "<li>$row->edt</li>\n";
				}

				$ix ++;
			}
			if ($ix > 1) {
				$b->bottom .= "</ul>\n";
				$b->bottom .= "See the <a href='eventstatus.php'>Events page</a> for more details and signup.</p>\n";
			}

			$b->display();
		}
	}

	function printPickUpCurling () {
		$b = new DynHtmlBlock();
		$b->leftRaw = "<img align='left' width=400 height=256 src='image/Maxwell.delivery.jpeg' />";

		$eventcdptrn = "PC%";
#		$eventcdptrn = "LTC%";

		if (getEventTypeCount($eventcdptrn) > 0) {
			$sql = makeEventQuery($eventcdptrn);
			
			$res = mysql_query($sql)
				or die("Error during event select. " . mysql_error());
			$ix = 0;
			while ($row = mysql_fetch_object($res)) {
				if ($ix == 0) {
					$b->header = "Pickup Curling on $row->edt";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "Our leagues are up and running througn Feb 5. ";
					$b->rightRaw .= "Didn't get in on the league? ";
					$b->rightRaw .= "We will be starting a new league in early March.";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "Pickup Curling is every Wednesday through Feb 5 at 7:30pm. ";
					$b->rightRaw .= "Our next Pickup Curling is at <strong>$row->edt at $row->etm</strong>. ";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= ($row->mbrprice == $row->guestprice) ?
						"The price for this event is \$$row->guestprice. " :
						"The member price is \$$row->mbrprice, and the event is \$$row->guestprice for non-members. ";
					$b->rightRaw .= "Only curlers that have already learned the basics of curling should come to Pickup Curling ";
					$b->rightRaw .= "&mdash; there will be no instruction available. ";
					$b->rightRaw .= "</p>";

					$b->bottomRaw .= "<p>";
					$b->bottomRaw .= "Just like with all events, we recommend registering online. ";
					$b->bottomRaw .= "Make sure you <a href='login.php'>Login or Register</a> and then go to the ";
					$b->bottomRaw .= "<a href='eventstatus.php'>Events page</a> to sign up and pay. ";
					$b->bottomRaw .= "</p>";
				} else {
					if ($ix == 1) {
						$b->bottomRaw .= "<p>Remaining Pickup Curling:\n";
						$b->bottomRaw .= "<ul>\n";
					}
					$b->bottomRaw .= "<li>$row->edt</li>\n";
				}

				$ix ++;
			}
			if ($ix > 1) {
				$b->bottomRaw .= "</ul>\n";
				$b->bottomRaw .= "See the <a href='eventstatus.php'>Events page</a> for more details and signup.</p>\n";
			}

			$b->display();
		}
	}

	function printOpenHouse () {
		$b = new DynHtmlBlock();
		$b->leftRaw = "<img align='left' width=400 height=256 src='image/Tatem.delivery.jpeg' />";

		$eventcdptrn = "OH%a";

		if (getEventTypeCount($eventcdptrn) > 0) {
			$sql = makeEventQuery($eventcdptrn);
			
			$res = mysql_query($sql)
				or die("Error during event select. " . mysql_error());
			$ix = 0;
			while ($row = mysql_fetch_object($res)) {
				if ($ix == 0) {
					$b->header = "Open House on $row->edt";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "Our Open House is the perfect event for a person who wants a taste of what curling is all about. ";
					$b->rightRaw .= "The Open House is about a 45-minute experience that will give you a chance to get out on the ice, ";
					$b->rightRaw .= "throw a few stones and get the basics.";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "The Open House will be on <strong>$row->edt from $row->etm until about $row->etmend</strong>. ";
					$b->rightRaw .= "Register online to sign up for a specific start time. ";
					$b->rightRaw .= "(Your participation will begin within the 30-minute period you register for.) ";
					$b->rightRaw .= "</p>";

					$b->rightRaw .= "<p>";
					$b->rightRaw .= "The price for this event is \$$row->guestprice. ";
					$b->rightRaw .= "</p>";

					$b->bottomRaw .= "<p>";
					$b->bottomRaw .= "To make sure you get the time slot you want, we recommend registering online. ";
					$b->bottomRaw .= "Make sure you <a href='login.php'>Login or Register</a> and then go to the ";
					$b->bottomRaw .= "<a href='eventstatus.php'>Events page</a> to sign up and pay. ";
					$b->bottomRaw .= "</p>";
				} else {
					if ($ix == 1) {
						$b->bottomRaw .= "<p>Additional Open Houses:\n";
						$b->bottomRaw .= "<ul>\n";
					}
					$b->bottomRaw .= "<li>$row->edt</li>\n";
				}

				$ix ++;
			}
			if ($ix > 1) {
				$b->bottomRaw .= "</ul>\n";
				$b->bottomRaw .= "See the <a href='eventstatus.php'>Events page</a> for more details and signup.</p>\n";
			}

			$b->display();
		}
	}


# Print the events in order by what comes first

	$ocdt = getEventTypeMinDate("OC%");
	$ltcdt = getEventTypeMinDate("LTC%");
	$pucdt = getEventTypeMinDate("PC%");
	$ohdt = getEventTypeMinDate("OH%a");
	
	$occnt = getEventTypeCount("OC%");
	$ltccnt = getEventTypeCount("LTC%");
	$puccnt = getEventTypeCount("PC%");
	$ohcnt = getEventTypeCount("OH%a");
	
	if ($debug) {
		echo "<table style='border: thin solid black'>\n";
		echo "<tr><th>Event Type</th><th>Next Date</th><th>Count</th></tr>\n";
		echo "<tr><td>Open Curling</td><td>$ocdt</td><td>$occnt</td></tr>\n";
		echo "<tr><td>Learn to Curl</td><td>$ltcdt</td><td>$ltccnt</td></tr>\n";
		echo "<tr><td>Pickup Curling</td><td>$pucdt</td><td>$puccnt</td></tr>\n";
		echo "<tr><td>Open House</td><td>$ohdt</td><td>$ohcnt</td></tr>\n";
		echo "</table>\n";
	}

#	if ($ocdt < $ltcdt) {
#		if ($pucdt < $ocdt) {
#			printPickupCurling();
#			printOpenCurling();
#			printLearnToCurl();
#		} else {
#			printOpenCurling();
#			if ($pucdt < $ltcdt) {
#				printPickupCurling();
#				printLearnToCurl();
#			} else {
#				printPickupCurling();
#				printLearnToCurl();
#			}
#		}
#	} else {
#		if ($pucdt < $ltcdt) {
#			printPickupCurling();
#			printLearnToCurl();
#			printOpenCurling();
#		} else {
#			printLearnToCurl();
#			if ($pucdt < $ocdt) {
#				printPickupCurling();
#				printOpenCurling();
#			} else {
#				printOpenCurling();
#				printPickupCurling();
#			}
#		}
#	}

	printOpenHouse();
	printLearnToCurl();
	printOpenCurling();
	printPickupCurling();
				
	foreach($page->block as $block) 
		if ($block->seq >= 1000) 
			$block->display();

	$page->displayFooter();

	DynHtmlPage::upcoming();

	print "</div><!-- colleft -->\n";
	print "</div><!-- colmask -->\n";


	DynHtmlPage::footer();
	DynHtmlPage::docFooter();

?>
