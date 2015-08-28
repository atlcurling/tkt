<?php

function printOneBigFaq () {
	require_once("config/database.php");

	$debug = 0;

	$sql = '
	  SELECT c.id cid, c.name cname, f.id fid, f.thema fthema, f.content fcontent
	  FROM pwv_faqcategories c
		JOIN pwv_faqcategoryrelations r ON c.id = r.category_id
		JOIN pwv_faqdata f ON r.record_id = f.id
	  ORDER BY c.id, f.id
	  ';

	$db = new mysqli($DB['server'], $DB['user'], $DB['password'], $DB['db']);
	if ($db->connect_errno) 
		die("Error {$db->connect_errno} connecting to database {$DB['user']}. {$db->connect_error}");
	#print_r($db);

	if ($result = $db->query($sql)) {
		if ($debug) {
			echo "<pre>";
			print_r($result);
			echo "</pre>";
		}

	// Table of contents

		$pcid = 0;
		printf("<h2>Table of Contents</h2>\n");
		while ($row = $result->fetch_assoc()) {
			$cid = $row['cid'];
			if ($pcid != $cid) {
				if ($pcid) printf("</ol>\n");
				$anchor = $cid;
				printf("<b><a href='#$anchor'>{$row['cname']}</a></b></br>\n");
				printf("<ol>\n");
				$pcid = $cid;
			}
			$fid = $row['fid'];
			$anchor = "$cid-$fid";
			printf("<li><a href='#$anchor'>{$row['fthema']}</a></li>\n");
		}
		echo "</ol>";

		$result->data_seek(0);

	// Content

		$pcid = 0;
		while ($row = $result->fetch_assoc()) {
			$cid = $row['cid'];
			if ($pcid != $cid) {
				if ($pcid) printf("</ol>\n");
				$anchor = $cid;
				printf("<h2><a name='$anchor'>{$row['cname']}</a></h2>\n");
				printf("<ol>\n");
				$pcid = $cid;
			}
			$fid = $row['fid'];
			$anchor = "$cid-$fid";
			printf("<li><a name='$anchor'><strong>{$row['fthema']}</strong></a></li>{$row['fcontent']}\n");
		}
		echo "</ol>";

		$result->free();
	} else {
		die("Error {$db->errno} selecting reporting data. {$db->error}");
	}

	$db->close();
}

function testPrintOneBigFaq () {
	echo "<html><body>";
	printOneBigFaq();
	echo "</body></html>";
}
