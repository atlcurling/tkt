<?php

	require_once("{$TKTDIR}xactlog.php");

	$action = postvalue("action", getvalue("action", "login"));

	$errlist = "";
	$presentform = 0;

	dbconnect();

	$x = new XactLog();

	switch ($action) {

/* Login / Register - prompt for info */

	case "login":
		$presentform = 1;

		$firstnm = "";
		$lastnm = "";
		$phonenbr = "";
		$usernm = "";
		$usernm2 = "";
		$passwd = "";
		$passwd2 = "";

		loginprompt(false);
		break;

/* Login phase 2 - check usernm and passwd, login if match */

	case "Log In":
		$usernm = postvalue("usernm", "");
		$passwd = postvalue("passwd", "");

		$pwcheck = dbgetsingleton(
			"SELECT (PASSWORD('$passwd') = passwd) pwcheck " .
			"  FROM user " .
			"  WHERE usernm = '$usernm'", 
			"pwcheck");

		if ($pwcheck) {
			h1("Login successful");
			$user = new User();
			$user->loadByUserNm($usernm);
			$_SESSION["user"] = ($user);

			$x->log("Login Succeeded", "Login succeeded for $usernm", $user->userix);

		/* Check for waiting list pickups */

			$sql =
				"SELECT r.eventix, e.eventnm, e.eventdt, COUNT(*) wlcnt, IF(o.rcnt IS NULL, 0, o.rcnt) rcnt \n" .
				"  FROM registration r \n" .
				"    JOIN event e ON (r.eventix = e.eventix) \n" .
				"    LEFT OUTER JOIN (SELECT eventix, COUNT(*) rcnt FROM registration WHERE NOT waiting AND releasetime IS NOT NULL GROUP BY eventix) o ON (r.eventix = o.eventix) \n" .
				"  WHERE r.userix = {$user->userix} \n" .
				"    AND r.waiting \n" .
				"    AND rcnt > 0 \n" .
				"    AND e.eventdt >= CURDATE() \n" .
				"  GROUP BY e.eventdt \n" .
				"  ORDER BY e.eventdt";

			dispsql($sql);
			$result = mysql_query($sql)
				or die("Error selecting waiting list entries. " . mysql_error());

			$rows = mysql_num_rows($result);
			if ($rows) {
				echo "<h3>Waiting List Notifications</h3>\n";
				echo "<ul>\n";
				while ($row = mysql_fetch_assoc($result)) {
					$s = sprintf("There are now %d released released reservations available for the event %s on %s.",
						$row['rcnt'], $row['eventnm'], $row['eventdt']);
					echo "<li>$s</li>\n";
					$x->log("Login WL Availability", $s, $usernm, $row['eventix']);
				}
				echo "</ul>\n";

				echo "<p><a href='eventstatus.php'>Go to the event status page to purchase these released reservations.</a></p>\n";

			}
		} else {
			h1("Login failed");
			$presentform = 1;

			$x->log("Login Failed", "Login failed for $usernm", $user->userix);
		}

		loginprompt(false);

		break;

/* 
 * Registration phase 2 - check that required fields are filled and that e-mail and password entries match
 *
 * Rules:
 * 1) All fields are required
 * 2) usernm must be unique
 * 3) usernm must match usernm2
 * 4) passwd must be passwd2
 *
 */

	case "Register":
		$firstnm = postvalue("firstnm", "");
		$lastnm = postvalue("lastnm", "");
		$phonenbr = postvalue("phonenbr", "");
		$usernm = postvalue("usernm", "");
		$usernm2 = postvalue("usernm2", "");
		$passwd = postvalue("passwd", "");
		$passwd2 = postvalue("passwd2", "");

		$errlist = "<ul style='background-color: red; padding: 8px 40px 8px 40px;'>";
		$errors = 0;

	/* Required field checks */

		if (! $firstnm) { $errlist .= "<li>First name is required.</li>"; $errors ++; }
		if (! $lastnm) { $errlist .= "<li>Last name is required.</li>"; $errors ++; }
		if (! $phonenbr) { $errlist .= "<li>Phone number is required.</li>"; $errors ++; }
		if (! $usernm) { $errlist .= "<li>E-mail address is required.</li>"; $errors ++; }
		if (! $usernm2) { $errlist .= "<li>E-mail address again is required.</li>"; $errors ++; }
		if (! $passwd) { $errlist .= "<li>Password is required.</li>"; $errors ++; }
		if (! $passwd2) { $errlist .= "<li>Password again is required.</li>"; $errors ++; }

	/* Repeat entry checks */

		if ($usernm != $usernm2) { $errlist .= "<li>E-mail addresses do not match.</li>"; $errors ++; }
		if ($passwd != $passwd2) { $errlist .= "<li>Passwords do not match.</li>"; $errors ++; }

	/* User name uniqueness check */

		$count = dbgetsingleton("SELECT COUNT(*) cnt FROM user WHERE usernm = '$usernm'", "cnt");
		if ($count) {
			$errlist .= "<li>E-mail address \"$usernm\" has already been registered.</li>";
			$errors ++;
		}

		$errlist .= "</ul>\n";

		if ($errors) $presentform = 1;
		else {
			$errlist = "";

		/* Create user record */

			$user = new User($usernm, $firstnm, $lastnm, $phonenbr, false, $passwd);
			$user->save();
			$user->passwd = "";
			$_SESSION["user"] = ($user);

			echo "<p>Congratulations! You have been registered and are logged in.</p>\n";
			$x->log("Registration Succeeded", "New user $usernm ($firstnm $lastnm) has been registered.", $user->userix);
		}

		loginprompt(false);

		break;

	case "logout":
		h1("Logout");
		if (isset($_SESSION) && array_key_exists("user", $_SESSION)) {
			$usernm = $_SESSION["user"]->usernm;
			$userix = $_SESSION["user"]->userix;
			unset($_SESSION["user"]);
			$x->log("Logout Succeeded", "Logout succeeded for $usernm", $userix);
		} else {
			$x->log("Logout Succeeded Anonymously", "Anonymous logout succeeded.");
		}
		$usernm = "";
		$userix = 0;

		echo "<p>You have been logged out.</p>";
		loginprompt(false);
		break;
	}

	if ($presentform) {
?>
	<table><tr><td class="loginbox">
		<form action='<?php echo $page ?>' method='post'>
			<h3>Log In</h3>
			<table><tr>
				<td colspan=2>If you already have an account, log in here.</td>
			</tr><tr>
				<td>E-mail address</td>
				<td><input type='text' name='usernm' size=40 maxlength=64></td>
			</tr><tr>
				<td>Password</td>
				<td><input type='password' name='passwd' size=40 maxlength=64></td>
			</tr><tr>
				<td colspan=2><input type='submit' name='action' value='Log In'></td>
			</tr></table>
		</form>
	</td></tr><tr><td class="loginbox">
		<form action='<?php echo $page ?>' method='post'>
			<h3>Register</h3>
			<table><tr>
				<td colspan=2>If you do not have an account, start your registration here. All fields are required.<?php echo $errlist; ?></td>
			</tr><tr>
				<td>First name</td>
				<td><input type='text' name='firstnm' value='<?php echo $firstnm ?>' 
					size=40 maxlength=64></td>
			</tr><tr>
				<td>Last name</td>
				<td><input type='text' name='lastnm' value='<?php echo $lastnm ?>' 
					size=40 maxlength=64></td>
			</tr><tr>
				<td colspan=2><hr/></td>
			</tr><tr>
				<td>Phone number</td>
				<td><input type='text' name='phonenbr' value='<?php echo $phonenbr ?>'
					size=40 maxlength=64></td>
			</tr><tr>
				<td colspan=2><hr/></td>
			</tr><tr>
				<td>E-mail address</td>
				<td><input type='text' name='usernm' value='<?php echo $usernm ?>'
					size=40 maxlength=64></td>
			</tr><tr>
				<td>E-mail address again</td>
				<td><input type='text' name='usernm2' value='<?php echo $usernm2 ?>'
					size=40 maxlength=64></td>
			</tr><tr>
				<td colspan=2><hr/></td>
			</tr><tr>
				<td>Password</td>
				<td><input type='password' name='passwd' size=40 maxlength=64></td>
			</tr><tr>
				<td>Password again</td>
				<td><input type='password' name='passwd2' size=40 maxlength=64></td>
			</tr><tr>
				<td colspan=2><input type='submit' name='action' value='Register'></td>
			</tr></table>
		</form>
	</td></tr></table>
<?php
	}

	$returnurl = 'index.php';
	if (isset($_SESSION) && array_key_exists("prevpage", $_SESSION))
		$returnurl = $_SESSION["prevpage"];
	echo "<a href='$returnurl'>Return</a>\n";
?>

</body>
</html>
