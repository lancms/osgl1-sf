<?php

require 'config/config.php';


$action = $_GET['action'];

if($action == "display" || !isset($action)) {
	if(!acl_access("adminUsers")) die($admin[noaccess]);
	echo "<table>";

	$query = mysql_query("SELECT * FROM users WHERE ID != 1 ORDER BY ID ASC") or die(mysql_error());



	$num = mysql_num_rows($query);

	echo "<tr><th>$profile[8]</th>";

	echo "</tr>";

	for($i=0;$i<$num;$i++) {

		$row = mysql_fetch_object($query);



		echo "<tr><td><a href=index.php?inc=useradmin&user=$row->ID>$row->nick</a></td>";

		echo "</tr>";



	}

	echo "</table>";

}

elseif($action == "online") {
	if(!acl_access("onlineUsers")) die($admin[noaccess]);

	echo "<table>";

	echo "<tr><th>$profile[8]</th><th>IP</th><th>Last page-view</th><th>Side</th></tr>";

	$query = mysql_query("SELECT * FROM session ORDER BY userID") or die(mysql_error());

	$num = mysql_num_rows($query);



	for($i=0;$i<$num;$i++) {

		$row = mysql_fetch_object($query);



		$nick = mysql_query("SELECT nick FROM users WHERE ID = $row->userID");

		$nick = mysql_fetch_row($nick);

		$nick = $nick[0];



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
