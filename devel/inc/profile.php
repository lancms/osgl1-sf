<?php

require_once 'config/config.php';

if (!config("usepage_profile"))
{
	nicedie($msg[9]);
}

db_connect();

if(!isset($_GET['action'])) {

	$action = "display";

} else {

	$action = $_GET['action'];

}


if ((!isset($_GET['uid'])) && (getcurrentuserid() != 1))
{
	$viewUSER = getcurrentuserid();
}
elseif ((!isset($_GET['uid'])) && (getcurrentuserid() == 1))
{
	nicedie($profile['15']);
}
else
{
	$viewUSER = $_GET['uid'];
}

if($action == "display" && isset($viewUSER)) {

	$query = mysql_query("SELECT * FROM users WHERE ID = $viewUSER") or nicedie(mysql_error());


	if(mysql_num_rows($query) == 0) {
		nicedie($form['18']);
	}



	$row = mysql_fetch_object($query);



	$permission = $row->AllowPublic;

	// Check if the user allows others than admins to see his profile.

	if (($permission == 2) && (!acl_access("isAdmin")) && (!acl_access("isChief")) && (!acl_access("adminUsers")))
	{
		nicedie($profile['0']);
	}
	elseif (($permission == 1) && (getcurrentuserid() == 1))
	{
		nicedie($profile['1']);
	}

	// else: it looks like the user allows even anonymous users to view the profile :)

	echo "<center>".$profile[2].$row->nick."<br><br>";

	echo "<table>";

	profile_table($profile[3], $row->firstName." ".$row->lastName);

	profile_table($profile[4],$row->aboutMe);


/*
	// Needs update to new seat-system.

	echo "<tr><td class=profileLeft>$profile[5]</td><td class=profileRight>";

	if($row->seatX == -1 && $row->seatY == -1) echo $msg[11];

	else echo $msg[10]." ($row->seatX / $row->seatY)";

	echo "</td></tr>";
*/

	profile_table($profile[9], resolve_groupname($row->ID));

}

echo "</table>";

if(acl_access("adminUsers"))
{
	echo "<br><a href=index.php?inc=useradmin&user=$viewUSER>$profile[11]</a>";
}

echo "</center>";


/*
	// This also needs a update for the new seatssytem?

function profile_table($profileLeft, $profileRight) {

	echo "<tr><td class=profileLeft>$profileLeft</td><td class=profileRight>";

	echo $profileRight;

	echo "</td></tr>";

}
*/

?>
