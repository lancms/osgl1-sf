<?php

require_once 'config/config.php';

if(!config("usepage_profile")) die($msg[9]);



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
	echo $profile['15'];
	include $base_path."style/bottom.php";
	die();
}
else
{
	$viewUSER = $_GET['uid'];
}

if($action == "display" && isset($viewUSER)) {



	$query = mysql_query("SELECT * FROM users WHERE ID = $viewUSER") or die(mysql_error());



	if(mysql_num_rows($query) == 0) {

		echo $form[18];

		include $base_path."style/bottom.php";

		die();

	}



	$row = mysql_fetch_object($query);



	$permission = $row->AllowPublic;

	// Check if the user allows others than admins to see his profile.

	if (($permission == 2) && (!acl_access("isAdmin")))
	{
		echo $profile['0'];
		include $base_path."style/bottom.php";
		die();
	}
	elseif (($permission == 1) && (getcurrentuserid() == 1))
	{
		echo $profile['1'];
		include $base_path."style/bottom.php";
		die();
	}

	// else: it looks like the user allows even anonymous users to view the profile :)

	echo "<center>".$profile[2].$row->nick."<br><br>";

	echo "<table>";

	profile_table($profile[3], $row->name);

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
function profile_table($profileLeft, $profileRight) {

	echo "<tr><td class=profileLeft>$profileLeft</td><td class=profileRight>";

	echo $profileRight;

	echo "</td></tr>";

}
*/
?>
