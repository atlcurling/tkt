<?php

function dbconnect ()
{
	global $ENV;
	global $dbname;
	global $dbuser;
	global $dbpasswd;
	
  	$res = mysql_connect("localhost", $dbuser, $dbpasswd) or
    	die("dbconnect: Unable to connect to database. " . mysql_error());

  	$db = mysql_select_db($dbname, $res) or
    	die("dbconnect: Unable to select database '$dbname'. " . mysql_error());

  	return $db;
}

function dispsql ($sql)
{
	global $debug;
	
	if ($debug) {
		echo "<table class='dispsql'>";
		echo "<tr><td class='dispsql dispsqlhdr'>SQL</td><td class='dispsql dispsqldtl'>$sql</td></tr>";
		echo "</table>";
	}
}

function disprowvert ($row)
{
  echo "<table class='disprow'>";
  foreach ($row as $key => $value)
    {
      echo "<tr><td class='disprow'>$key</td><td class='disprow'>$value</td></tr>";
    }
  echo "</table>";
}

function disprowvertpass ($row, $pass)
{
  echo "<table class='disprow'>";
  foreach ($row as $key => $value)
    {
      if ($key == $pass)
	echo "<tr><td class='disprow'>$key</td><td class='disprow'><pre>$value</td></tr>";
      else
	echo "<tr><td class='disprow'>$key</td><td class='disprow'>$value</td></tr>";
    }
  echo "</table>";
}

function disprowhorhdrcells($result)
{
	for ($i = 0; $i < mysql_num_fields($result); $i ++)
	{
		$field = mysql_field_name($result, $i);
		echo "<th class='disprow'>$field</th>";
	}
}

function disprowhorhdr($result)
{
	echo "<table class='disprow'>";
	echo "<tr>";
	disprowhorhdrcells($result);
	echo "</tr>\n";
}

function disprowhor($row)
{
	echo "<tr>";
	$i = 0;
	foreach ($row as $key => $value)
	{
		$class = "field_$key";
		echo "<td class='disprow $class'>$value</td>";
		$i ++;
	}
	echo "</tr>\n";
}

function disprowhordtl($result)
{
	while ($row = mysql_fetch_assoc($result))
		disprowhor($row);
}

function disprowhorftr()
{
	echo "</table>";
}

function disphor($res) {
	disprowhorhdr($res);
	disprowhordtl($res);
	disprowhorftr();
}

function dbgetrow($sql) {
	$res = mysql_query($sql)
		or die("Error processing query $sql. " . mysql_error());
	$row = mysql_fetch_assoc($res);

	return $row;
}

function dbgetsingleton($sql, $column) {
	$row = dbgetrow($sql);
	return $row[$column];
}

?>
