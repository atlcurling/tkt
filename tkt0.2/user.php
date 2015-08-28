<?php

class User {
	public $usernm;
	public $userix;
	public $passwd;
	public $firstnm;
	public $lastnm;
	public $phonenbr;
	public $member;
	public $admin;

	public function __construct($i_usernm = "", $i_firstnm = "", $i_lastnm = "", $i_phonenbr = "", $i_member = false, $i_passwd = "") {
		if ($i_usernm) $this->usernm = $i_usernm;
		if ($i_firstnm) $this->firstnm = $i_firstnm;
		if ($i_lastnm) $this->lastnm = $i_lastnm;
		if ($i_phonenbr) $this->phonenbr = $i_phonenbr;
#		$this->member = $i_member;
		if ($i_passwd) $this->passwd = $i_passwd;
	}

	public function loadByUserNm($usernm) {
		$sql = 
			"SELECT usernm, userix, firstnm, lastnm, phonenbr, member, admin " .
			"  FROM user " .
			"  WHERE usernm = '$usernm'";
		dispsql($sql);
		$result = mysql_query($sql) or
			die("Error loading User for $usernm. " . mysql_error());
		$o = mysql_fetch_object($result, "User");

		$this->usernm = $o->usernm;
		$this->userix = $o->userix;
		$this->firstnm = $o->firstnm;
		$this->lastnm = $o->lastnm;
		$this->phonenbr = $o->phonenbr;
		$this->member = $o->member;
		$this->admin = $o->admin;
	}

	public function save() {
		if (! $this->userix) {
			$this->member += 0;
			$this->admin += 0;
			$sql =
				"INSERT INTO user SET " .
				"    usernm = '{$this->usernm}', " .
				"    passwd = PASSWORD('{$this->passwd}'), " .
				"    firstnm = '{$this->firstnm}', " .
				"    lastnm = '{$this->lastnm}', " .
				"    phonenbr = '{$this->phonenbr}', " .
				"    member = '{$this->member}', " .
				"    admin = $this->admin";
#			if ($debug) dispsql($sql);
			$result = mysql_query($sql) or
				die("Error inserting user $this->usernm. " . mysql_error());

			$this->userix = mysql_insert_id();
		} else {
			$sql =
				"UPDATE user SET " .
				"    usernm = '{$this->usernm}', " .
				"    firstnm = '{$this->firstnm}', " .
				"    lastnm = '{$this->lastnm}', " .
				"    phonenbr = '{$this->phonenbr}', " .
				"    member = '{$this->member}', " .
				"    admin = $this->admin" .
				"  WHERE userix = {$this->userix}";
#			if ($debug) dispsql($sql);
			$result = mysql_query($sql) or
				die("Error updating user $this->usernm. " . mysql_error());
		}
	}

	public static function getSession() {
		if (isset($_SESSION) && array_key_exists("user", $_SESSION)) {
			return $_SESSION["user"];
		} else {
			return null;
		}
	}

	public static function isAdmin() {
		return 
			$_SESSION["user"]->admin + 0;
		return isset($_SESSION) && array_key_exists("user", $_SESSION) && 
			$_SESSION["user"]->admin;
	}
}

