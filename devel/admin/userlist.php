<?php
require 'config/config.php';

$action = $_GET['action'];

if (($action == "display") || (!isset($action)))
{
	if (!acl_access("adminUsers"))
	{
		nicedie ($admin['noaccess']);
	}
		
	echo "<table>";
	$query = query("SELECT * FROM users WHERE ID != 1 ORDER BY ID ASC");

	$num = num($query);
	echo "<tr><th>$profile[8]</th>";
	echo "</tr>";
	for($i=0;$i<$num;$i++)
	{
		$row = fetch($query);

		echo "<tr><td><a href=index.php?inc=useradmin&user=$row->ID>$row->nick</a></td>";
		echo "</tr>";
	}
	echo "</table>";
}
elseif ($action == "online")
{
	if (!acl_access("onlineUsers"))
	{
		nicedie($admin['noaccess']);
	}
	
	echo "<table>";
	echo "<tr><th>$profile[8]</th><th>IP</th><th>".$userlist['0']."</th><th>".$userlist['1']."</th></tr>";
	$query = query("SELECT * FROM session ORDER BY userID");
	$num = num($query);

	for($i=0;$i<$num;$i++)
	{
		$row = fetch($query);

		$nick = query("SELECT nick FROM users WHERE ID = '".escape_string($row->userID)."");
		$nick = fetch($nick);
		$nick = $nick->nick;

		echo "<tr><td>$nick</td><td>$row->IP</td><td>";
		echo date("H:i",$row->logUNIX)."";
		echo "</td>";
		echo "<td>";
		echo $row->userURL;
		echo "</td>";
		echo "</tr>";

	}

	echo "</table>";

}

?>
