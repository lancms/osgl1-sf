<?php

require_once ('config/config.php');

if (!config("usepage_profile"))
{
	nicedie($msg[9]);
}

if (!isset($_GET['action']))
{
	$action = "display";

}
else
{
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

if (($action == "display") && (isset($viewUSER)))
{
	$query = query("SELECT * FROM users WHERE ID = '".escape_string($viewUSER)."'");

	if(num($query) == 0)
	{
		nicedie($form['18']);
	}

	$row = fetch($query);

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
	profile_table($profile[9], resolve_groupname($row->ID));

	// TODO: Needs to show seatinfo from the new system.
}

echo "</table>";

if(acl_access("adminUsers"))
{
	echo "<br><a href=index.php?inc=useradmin&user=$viewUSER>$profile[11]</a>";
}

echo "</center>";
echo "</td></tr>";

?>
