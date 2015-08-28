<?php

	require_once("{$TKTDIR}xactlog.php");
	require_once("{$TKTDIR}order.php");

	loginprompt(false);
	$x = new XactLog();

	$user = User::getSession();
	$usernm = $user ? $user->usernm : "";
	$userix = $user ? $user->userix : "";

	$action = postvalue("action", getvalue("action"), "none");
	$orderix = postvalue("orderix");

	switch ($action) {

	/* *************************************************************************************************************************** */
	/* Submit Order: this is the first screen a user lands on when they submit an order from "eventstatus" */
	/* It shows the proposed order along with amounts and allows the user to either Confirm or Cancel */
	/* *************************************************************************************************************************** */

		case 'Submit Order':
			echo "<form action='eventorder.php' method='post'>\n";
			$memstatus = ($user->member ? "Member" : "Non-Member");
			echo "<h1>Event Order Confirmation - $usernm - $memstatus</h1>\n";
			echo "<br/>\n";

			echo "<table>";
			echo "<tr>\n";
			echo "<th width=16%>Event</th>";
			echo "<th width=16%>Date</th>";
			echo "<th width=16%>Activity</th>";
			echo "<th width=16%>Quantity</th>";
			echo "<th width=16%>Price</th>";
			echo "<th width=16%>Ext. Price</th>";
			echo "</tr>\n";

			$ix = 0;
			$totalamt = 0.00;
			$nadds = 0;
			$nwaits = 0;
			$nrels = 0;
			while (array_key_exists("eventnm$ix", $_POST)) {
				$eventix = $_POST["eventix$ix"];
				$eventnm = $_POST["eventnm$ix"];
				$eventdt = $_POST["eventdt$ix"];
				$add = postvalue("add$ix", 0);
				$addwait = postvalue("addwait$ix", 0);
				$remove = postvalue("remove$ix", 0);
				$price = round(postvalue("price$ix", 0.00) / $pricedivider, 2);
				$extamt = $add * $price;

				if ($add) {
					echo "<tr>";
					echo "<td>$eventnm</td>";
					echo "<td align=center>$eventdt</td>";
					echo "<td align=center>Reserve</td>";
					echo "<td align=center>$add</td>";
					printf("<td align=center>$%0.2f</td>", $price);
					printf("<td align=center>$%0.2f</td>", $extamt);
					echo "<input type='hidden' name='extamt$ix' value='$extamt'>";
					echo "</tr>\n";

					$totalamt += $extamt;
					$nadds ++;
				}

				if ($addwait) {
					echo "<tr>";
					echo "<td>$eventnm</td>";
					echo "<td align=center>$eventdt</td>";
					echo "<td align=center>Add to Waiting List</td>";
					echo "<td align=center>$addwait</td>";
					echo "</tr>\n";
					
					$nwaits ++;
				}

				if ($remove) {
					echo "<tr>";
					echo "<td>$eventnm</td>";
					echo "<td align=center>$eventdt</td>";
					echo "<td align=center>Release</td>";
					echo "<td align=center>$remove</td>";
					echo "</tr>\n";
					
					$nrels ++;
				}

				$ix ++;
			}

			echo "<tr>";
			echo "<th>Total</th>";
			echo "<td></td><td></td><td></td><td></td>";
			printf("<th style='border: white 2px solid'>$%0.2f</td>", $totalamt);
			echo "</tr>\n";

			echo "</table>\n";

			foreach ($_POST as $key => $value)
				if ($key != "action")
					echo "<input type='hidden' name='$key' value='$value'>\n";

			?>
			<div class="warnmsg">
			<h3 style="text-align: center;">Refund Policy</h3>
			<strong>All sales should be considered final.</strong>
			Once you have completed your purchase,
			if you release your reservations the purchase price will only be refunded if the reservations are purchased again by another user.
			Your funds will not be reimbursed immediately and may not be refunded at all if no other users purchase reservations for that event.
			</div>
			<?php
			
			if ($nrels) {
				?>
				<br/>
				<div class="warnmsg">
				<h3 style="text-align: center;">Released Reservations</h3>
				Once you click <strong>Confirm</strong> below, any reservations you have ordered released will no longer be available to you.
				</div>
				<br/><center>Clicking <strong>Confirm</strong> below indicates your acceptance of these policies
				and will release the requested reservations.</center>
				<?php
			} else {
				echo "<br/><center>Clicking <strong>Confirm</strong> below indicates your acceptance of this policy.</center>";
			}

			echo "<center><input type='submit' name='action' value='Confirm'> &nbsp; ";
			echo "<input type='button' name='action' value='Cancel' onClick='history.go(-1)'></center>\n";

			echo "<input type='hidden' name='totalamt' value='$totalamt'>\n";

			echo "</form>\n";

			break;

	/* *************************************************************************************************************************** */
	/* Confirm: where the user lands if they click Confirm */
	/* Creates the order in the database and */
	/* *************************************************************************************************************************** */

		case 'Confirm':

		/* Create the order in the orderhdr and orderdtl tables */

			echo "<h1>Event Order Placed - $usernm</h1>\n";

			dbconnect();

		/* Create orderhdr row */
			
			$totalamt = postvalue("totalamt", 0.00);

			$order = new Order();
			$orderix = $order->createOrderIx($userix);
			$order->setTotalAmt($totalamt);
			if ($debug) echo "<p>Your order number is <strong><big>$orderix</big></strong>.</p>\n";

			$x->log("Order Confirmed", "Order $orderix confirmed by user $usernm", $userix, $orderix);

			$ix = 0;
			$orderdtlix = 0;
			$totaladd = 0;
			while (array_key_exists("eventnm$ix", $_POST)) {
				$eventix = $_POST["eventix$ix"];
				$eventnm = $_POST["eventnm$ix"];
				$eventdt = $_POST["eventdt$ix"];
				$add = postvalue("add$ix", 0);
				$addwait = postvalue("addwait$ix", 0);
				$remove = postvalue("remove$ix", 0);
				$extamt = postvalue("extamt$ix", 0);
				
				$totaladd += $add;

			/* Adds */

				if ($add) {
				/* Order detail insertion */

					$orderdtlix ++;

					$sql =
						"INSERT INTO orderdtl SET \n" .
						"  orderix = $orderix, \n" .
						"  orderdtlix = $orderdtlix, \n" .
						"  itemix = 0, \n" .
						"  eventix = $eventix, \n" .
						"  action = 'A', \n" .
						"  qty = $add, \n" .
						"  extamt = $extamt";

					if ($debug > 1) dispsql($sql);

					$res = mysql_query($sql) or
						die("Error during orderdtl insert. " . mysql_error());

					$rows = mysql_affected_rows();
					if ($debug > 1) echo $rows . " row" . ($rows > 1 ? "s" : "") . " inserted.<br/>";
				}

			/* Add to waiting list */

				if ($addwait) {
				/* Order detail insertion */

					$orderdtlix ++;

					$sql =
						"INSERT INTO orderdtl SET \n" .
						"  orderix = $orderix, \n" .
						"  orderdtlix = $orderdtlix, \n" .
						"  itemix = 0, \n" .
						"  eventix = $eventix, \n" .
						"  action = 'W', \n" .
						"  qty = $addwait, \n" .
						"  extamt = 0.00";

					if ($debug > 1) dispsql($sql);

					$res = mysql_query($sql) or
						die("Error during orderdtl insert. " . mysql_error());

					$rows = mysql_affected_rows();
					if ($debug > 1) echo $rows . " row" . ($rows > 1 ? "s" : "") . " inserted.<br/>";
				}


			/* Removes */

				if ($remove) {
				/* Order detail insertion */

					$orderdtlix ++;

					$sql =
						"INSERT INTO orderdtl SET \n" .
						"  orderix = $orderix, \n" .
						"  orderdtlix = $orderdtlix, \n" .
						"  itemix = 0, \n" .
						"  eventix = $eventix, \n" .
						"  action = 'R', \n" .
						"  qty = $remove, \n" .
						"  extamt = 0.00";

					if ($debug > 1) dispsql($sql);

					$res = mysql_query($sql) or
						die("Error during orderdtl insert. " . mysql_error());

					$rows = mysql_affected_rows();
					if ($debug > 1) echo $rows . " row" . ($rows > 1 ? "s" : "") . " inserted.<br/>";
				}

				$ix ++;
			}

		/* Process Add Waits and Releases */
		/* Apply changes to registration */
			
			$sql =
				"SELECT o.orderdtlix, o.itemix, o.eventix, o.action, o.qty, e.eventnm \n" .
				"  FROM orderdtl o JOIN event e ON (o.eventix = e.eventix)\n" .
				"  WHERE orderix = $orderix \n" .
				"  ORDER BY orderdtlix";

			if ($debug > 1) dispsql($sql);

			$res = mysql_query($sql) or
				die("Error during orderdtl select. " . mysql_error());

			while ($row = mysql_fetch_assoc($res)) {
				$orderdtlix = $row["orderdtlix"];
				$itemix = $row["itemix"];
				$eventix = $row["eventix"];
				$action = $row["action"];
				$qty = $row["qty"];
				$eventnm = $row["eventnm"];

				switch ($action) {
				/* Process adds - ignore until we get confirmation from PayPal */
					case "A":
						break;

				/* Process removals */
					case "R":
						if ($debug > 1) 
							echo "Processing remove for eventix $eventix, " . 
								"userix $userix, quantity $qty.<br/>\n";
						else echo "<p>Releasing $qty reservations for $eventnm.</p>\n";

						$sql =
							"UPDATE registration \n" .
							"  SET releaseorderix = $orderix, \n" .
							"    releasetime = CURRENT_TIMESTAMP \n" .
							"  WHERE eventix = $eventix \n" .
							"    AND userix = $userix \n" .
							"    AND NOT waiting \n" .
							"    AND releasetime IS NULL \n" .
							"  LIMIT $qty";

						if ($debug) dispsql($sql);

						$res2 = mysql_query($sql) or
							die("Error during update. " . mysql_error());

						$rows = mysql_affected_rows();
						if ($debug > 1) echo $rows . " row" . ($rows != 1 ? "s" : "") . " updated.<br/>";

						$x->log("Reservations Released",
							"Order $orderix for $usernm released $rows reservations for event $eventix.",
							$userix, $orderix, $eventix);

						break;

				/* Process waiting list adds */
					case "W":
						if ($debug > 1)
							echo "Processing wait list adds for eventix $eventix, " .
								"userix $userix, quantity $qty.<br/>\n";
						else echo "<p>Adding you to the waiting list for $eventnm for $qty reservations.</p>\n";

						$sql = "INSERT INTO registration (eventix, userix, addorderix, waiting, ordertime) VALUES \n ";
						$values = "";
						for ($i = 0; $i < $qty; $i ++) $values .= ",\n ($eventix, $userix, $orderix, 1, CURRENT_TIMESTAMP)";
						if ($values) {
							$values = substr($values, 3);
							$sql .= $values;

							dispsql($sql);

							$res2 = mysql_query($sql) or
								die("Error during insert. " . mysql_error());

							$rows = mysql_affected_rows();
							if ($debug) echo $rows . " row" . ($rows != 1 ? "s" : "") . " inserted.<br/>";
							$x->log("Waiting List Add",
								"Order $orderix for $usernm added $rows waiting list reservations for event $eventix.",
								$userix, $orderix, $eventix);
						}

						break;
				}
			}

		/* Send to PayPal for purchases */
			
			if ($totaladd) {
			/* Save the orderix, because PayPal won't pass it back if the user rejects */
			
				$_SESSION["orderix"] = $orderix;
				
			/* PayPal form */
			
				echo "<br/><table width=100%><tr><td colspan=2>\n";
				echo "<center>Click <strong>Buy Now</strong> below to go to PayPal to complete your purchase.</center>\n";
			
				echo "</td></tr><tr><td width=50% style='text-align: center'>\n";
				echo "<form action='$PPbaseurl/cgi-bin/webscr' method='post'>\n";
				
				printf("Amount: $%.2f\n<br/>", $totalamt);
				echo "<input type='hidden' name='business' value='$PPbusiness'>\n";
				echo "<input type='hidden' name='cmd' value='_xclick'>\n";
				echo "<input type='hidden' name='invoice' value='$orderix'>\n";
				echo "<input type='hidden' name='amount' value='$totalamt'>\n";
				echo "<input type='hidden' name='item_name' value='Curling Reservation Order $orderix'>\n";
				echo "<input type='hidden' name='first_name' value='{$user->firstnm}'>\n";
				echo "<input type='hidden' name='last_name' value='{$user->lastnm}'>\n";
				echo "<input type='hidden' name='email' value='$usernm'>\n";
				echo "<input type='hidden' name='night_phone_a' value='{$user->phonenbr}'>\n";
				echo "<input type='hidden' name='return' value='{$BASEURL}{$page}?action=ppapprove'>\n";
				echo "<input type='hidden' name='cancel_return' value='{$BASEURL}{$page}?action=ppreject'>\n";
				echo "<input type='hidden' name='rm' value=2>\n";
				echo "<input type='hidden' name='notify_url' value='{$BASEURL}ppipn.php'>\n";

				echo "<input type='image' src='$PPbaseurl/en_US/i/btn/btn_buynowCC_LG.gif' ";
				echo "border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>\n";
				echo "<img alt='' border='0' src='$PPbaseurl/en_US/i/scr/pixel.gif' width='1' height='1'>\n"	;
				echo "</form>\n";
				
				echo "</td><td width=50% style='text-align: center'>\n";
	
				echo "<form action='eventorder.php' method='post'>\n";
				echo "<input type='submit' name='action' value='Reject'>\n";
							
				echo "<input type='hidden' name='usernm' value='$usernm'>\n";
				echo "<input type='hidden' name='userix' value='$userix'>\n";
				echo "<input type='hidden' name='orderix' value='$orderix'>\n";
				echo "</form>";
				
				echo "</td></tr></table>\n";
			} else {
			
				$_SESSION["orderix"] = 0;
			
				echo "<form action='eventstatus.php' method='post'>\n";
				echo "<input type='submit' name='action' value='Return to Events'>\n";
				echo "</form>\n";
				
			}

			break;

	/* *************************************************************************************************************************** */
	/* Approve: payment approved by user via PayPal */
	/* *************************************************************************************************************************** */

		case 'Approve':
		case 'ppapprove':

			if (array_key_exists("invoice", $_POST)) $orderix = $_POST["invoice"];
			
			echo "<h3>Payment for order $orderix approved.</h3>";
			
			dbconnect();
			$order = new Order();
			$order->orderix = $orderix;

			$x->log("PP Manual Approval Return", "Manual return from PayPal after user $usernm approved order $orderix.", $userix, $orderix, NULL, print_r($_POST, true));


		/* Return to the event status page */

			echo "<form action='eventstatus.php' method='post'>\n";
			echo "<input type='submit' name='action' value='Event Status'>\n";
			echo "</form>";

			$_SESSION["orderix"] = 0;
			
			break;

	/* *************************************************************************************************************************** */
	/* Reject: payment rejected by user via PayPal */
	/* *************************************************************************************************************************** */

		case 'Reject':
		case 'ppreject':

			$orderix = postvalue("invoice", (isset($_SESSION) && array_key_exists("orderix", $_SESSION)) ? $_SESSION["orderix"] : 0);
			
			echo "<h3>Payment for order $orderix rejected.</h3>";

			dbconnect();

			$order = new Order();
			$order->orderix = $orderix;
			$order->setPmtRejTime();

			$x->log("PP Manual Rejection Return", "Manual return from PayPal after user $usernm rejected order $orderix.", $userix, $orderix, NULL, print_r($_POST, true));

		/* Return to the event status page */

			echo "<form action='eventstatus.php' method='post'>\n";
			echo "<input type='submit' name='action' value='Event Status'>\n";
			echo "</form>";

			$_SESSION["orderix"] = 0;

			break;
			
		default:
			echo "<h1>Unknown action '$action'</h1>\n";
			break;
	}

?>

