<?php
require_once 'config/config.php';
if(!acl_access("loginUser"))
{
	nicedie($admin['noaccess']);
}

$action = $_GET['action'];
$user = $_GET['user'];
$ticketarray = NULL;
$ticketarray .= "</select>";

if (!isset($action))
{
	$action = "search";
}
if ($action == "search")
{
	echo "<form method=POST action=index.php?inc=userlogin&action=main>";
	echo "<input type=text name=search> <input type=submit value='".$msg['37']."'>";
}

elseif ($action == "ticketselect")
{
	$user = $_REQUEST['userID'];
	$adminID = getcurrentuserid();
	$ticket = $_POST['ticket'];
	$search = $_GET['search'];

	query("UPDATE users SET ticketType = '".mysql_escape_string($ticket)."', ticketAuthorize = '".mysql_escape_string($adminID)."' WHERE ID = '".mysql_escape_string($user)."'");
	if(isset($search))
	{
		refresh("index.php?inc=userlogin&action=main&search=$search", 0);
	}
	else
	{
		refresh("index.php?inc=userlogin", 0);
	}
}
elseif ($action == "main")
{
	$search = $_REQUEST['search'];

	$query = query("SELECT * FROM users WHERE ID != 1 AND nick LIKE '%".mysql_escape_string($search)."%' OR ID != 1 AND name LIKE '%".($search)"%'");
	$num = num($query);
	echo "<a href=index.php?inc=userlogin>Tilbake til søkesiden</a>";
	echo '<table cellspacing=1 border=1>';
	while($row = fetch($query))
	{
		echo "<tr><td>";
		echo "<td><a href=index.php?inc=profile&uid=$row->ID>";
		echo "$row->nick</a></td>";
		echo "<td><form method=POST action=index.php?inc=userlogin&action=ticketselect&userID=$row->ID&search=$search>";

		echo "<select name=ticket>";
		for($i=0;$i<count($tickettype);$i++)
		{
			echo "<option value=$i";
			if($row->ticketType == $i)
			{
				echo " SELECTED";
			}
			echo ">$tickettype[$i]</option>";
		}
		echo "<input type=hidden name=userID value=$row->ID>";
		echo "</td><td><input type=submit value='".$msg['38']."'>";
		echo "</form></td>";
		if($row->isHere == 0)
		{
			echo "<td bgcolor=green><a href=index.php?inc=userlogin&action=login&user=$row->ID>$form[41]</a>";
		}
		else
		{
			echo "<td bgcolor=red><a href=index.php?inc=userlogin&action=logout&user=$row->ID>$form[42]</a>";
		}
		echo "</td><td>";
		echo $row->name;
		echo "</td><td>";
		if (($row->seatX == -1) && ($row->seatY == -1))
		{
			$hasSeat = $msg['39'];
		}
		else
		{
			$hasSeat = $row->seatX." / ".$row->seatY;
		}
		echo $hasSeat;
		echo "</td><td>";
		echo $row->birthDAY."/".$row->birthMONTH." ".$row->birthYEAR;
		echo "</td><td>";
		echo $row->street." ".$row->postNr." ".$row->postPlace;
		echo "</td></tr>";
	}
echo "</table>";
} 
elseif ($action == "login")
{
	$query = query("UPDATE users SET isHere = 1 WHERE ID = '".mysql_escape_string($user)."'");
	refresh("index.php?inc=userlogin", 0);
}
elseif($action == "logout")
{
	$query = query("UPDATE users SET isHere = 0 WHERE ID = '".mysql_escape_string($user)."'");
	refresh("index.php?inc=userlogin", 0);
}
?>
