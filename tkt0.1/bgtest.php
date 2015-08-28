<html>
<body>

<?php

function barfrag($col, $wid = 16)
{
	echo "<span style='border: black 1px solid; background-color: $col; padding: 0 {$wid}px 0 0;'></span>";
}

function bargraph($x, $xcol, $n = 0, $ncol = "", $wid = 16)
{
	if ($n == 0) $n = $x;
	if ($ncol = "") $ncol = $xcol;

	echo "<span style='border: black 1px solid'>";
	for ($i = 0; $i < $x; $i ++) barfrag($xcol, $wid);
	for ($i = $x; $i < $n; $i ++) barfrag($ncol, $wid);
	echo "</span>\n";
}

?>

<h2>Reservations</h2>
Limit: 24 curlers<br/>
Openings: 7 curlers<br/>
<?php bargraph(17, "red", 24, "white"); ?>

<h2>Waiting List</h2>
Waiting: 14 curlers<br/>
<?php bargraph(14, "yellow"); ?>

<table width=100%>
<tr>
<td colspan=2 align=center><h3>Reserved Curling - Mon Jan 9, 2011</h2></td>
</tr><tr>
<td width=50%>
<table width=100%><tr>
<td width=50% align=left>Reserved: 17 curlers</td><td width=50% align=right>Openings: 7</td>
</tr><tr>
<td colspan=2 width=1%><?php bargraph(17, "red", 24, "white"); ?></td>
<td><input type="button" name="event1" value="Make Reservation"></td>
</tr></table>
</td><td width=50%>
<table width=100%><tr>
<td>Waiting list: 14 curlers</td>
</tr><tr>
<td>
<?php bargraph(14, "yellow"); ?>
<input type="button" name="event1" value="Add to Waiting List">
</td>
</tr></table>
</tr>
</table>

</body>
</html>
