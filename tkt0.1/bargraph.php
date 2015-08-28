<?php

function barfrag($col, $wid = 16)
{
	echo "<span style='border: black 1px solid; background-color: $col; padding: 0 {$wid}px 0 0;'></span>";
}

function bargraph($x, $xcol, $n = 0, $ncol = "", $wid = 16)
{
	if ($n == 0) $n = $x;
	if ($ncol == "") $ncol = $xcol;

	echo "<span style='border: black 1px solid'>";
	for ($i = 0; $i < $x; $i ++) barfrag($xcol, $wid);
	for ($i = $x; $i < $n; $i ++) barfrag($ncol, $wid);
	echo "</span>\n";
}

function bargraph2($x1, $x1col, $x2 = 0, $x2col = "", $n = 0, $ncol = "", $wid = 16)
{
	if ($x2col == "") $x2col = $x1col;
	if ($n == 0) $n = $x1 + $x2;
	if ($ncol == "") $ncol = $x1col;

	echo "<span style='border: black 1px solid'>";
	for ($i = 0; $i < $x1; $i ++) barfrag($x1col, $wid);
	for ($i = $x1; $i < $x1 + $x2; $i ++) barfrag($x2col, $wid);
	for ($i = $x1 + $x2; $i < $n; $i ++) barfrag($ncol, $wid);
	echo "</span>\n";
}

?>
