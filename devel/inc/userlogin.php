<?php
require_once 'config/config.php';
if(getuserrank() < 1) die($admin[noaccess]);

$action = $_GET['action'];
$user = $_GET['user'];


if(!isset($action)) $action = "main";

if($action == "main") {

	$query = mysql_query("SELECT * FROM users WHERE ID != 1") or die(mysql_error());

	$num = mysql_num_rows($query);
	echo '<table cellspacing=1 border=1>';
	for($i=0;$i<$num;$i++) {
		$row = mysql_fetch_object($query);

		echo "<tr><td>";
		if(getuserrank() == 2) echo "<td><a href=index.php?inc=profile&uid=$row->ID>";
		echo "$row->nick</a></td><td>";
		if($row->isHere == 0) echo "<a href=index.php?inc=userlogin&action=login&user=$row->ID>$form[41]</a>";
		else echo "<a href=index.php?inc=userlogin&action=logout&user=$row->ID>$form[42]</a>";
	//	echo "|";

		echo "</td>";

	}

echo "</table>";

} elseif($action == "login") {
	$query = mysql_query("UPDATE users SET isHere = 1 WHERE ID = $user") or die(mysql_error());
	refresh("index.php?inc=userlogin", 0);
} elseif($action == "logout") {
	$query = mysql_query("UPDATE users SET isHere = 0 WHERE ID = $user") or die(mysql_error());
	refresh("index.php?inc=userlogin", 0);
}
?>