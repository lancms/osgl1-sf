<?php
require_once 'config/config.php';
if(!acl_access("loginUser"))
{
	nicedie($admin['noaccess']);
}

$action = $_GET['action'];
$user = $_GET['user'];
$ticketarray = NULL;
$ticketarray .= "</select>"; // FIXME: WTF is this?

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
	$user = $_REQUEST['user'];
	$adminID = getcurrentuserid();
	$ticket = $_POST['ticket'];
	$search = $_GET['search'];

	query("UPDATE users SET ticketType = '".escape_string($ticket)."', ticketAuthorize = '".escape_string($adminID)."' WHERE ID = '".escape_string($user)."'");
	if(!empty($search))
	{
		refresh("index.php?inc=userlogin&action=main&search=$search", 0);
	}
	elseif(!empty($user))
	{
		refresh("index.php?inc=userlogin&action=main&search=$user", 0);
	}
	else
	{
		refresh("index.php?inc=userlogin", 0);
	}
}
elseif ($action == "main")
{
	$search = $_REQUEST['search'];

	$query = query("SELECT * FROM users WHERE ID != 1 AND (nick LIKE '%".escape_string($search)."%' OR name LIKE '%".escape_string($search)."%' OR ID = '$search')");
	$num = num($query);
	echo "<a href=index.php?inc=userlogin>Tilbake til søkesiden</a>";

	echo '<table cellspacing=1 border=1>';
	while($row = fetch($query))
	{
		echo "<tr><td>";
		echo "<td><a href=index.php?inc=profile&uid=$row->ID>";
		echo "$row->nick</a></td>";
		/* ** Moved to "Login"-page.
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
		*/
		if($row->ticketType == 0)
		{
			echo "<td bgcolor=green><a href=index.php?inc=userlogin&action=login&user=$row->ID>$form[41]</a>";
		}
		else
		{
			echo "<td bgcolor=red><a href=index.php?inc=userlogin&action=login&user=$row->ID>$form[42]</a>";
		}
		echo "</td><td>";
		echo $row->name;
		echo "</td><td>";
		if (($row->seatX == -1) && ($row->seatY == -1))
		{
			$hasSeat = lang("No seat", "inc_userlogin", "Text to display if the user does not have any seat");
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

elseif ($action == "login") {
	$escUser = escape_string($user);
	$q = query("SELECT * FROM users WHERE ID = ".$escUser);
	$r = fetch($q);
	echo "<table";
	if($r->userIsToBeDasked == 1) echo " bgcolor=yellow>";
	elseif($r->userIsToBeDasked == 2) echo " bgcolor=red>";
	echo ">";
	osgl_table("<a href=index.php?inc=userlogin>".lang("Back to searchpage", "inc_userlogin", "link to go back to userlogin main")."</a>","");
	if(acl_access("adminUsers")) $editLink = "<a href=index.php?inc=useradmin&user=$escUser>".lang("Edit user", "inc_userlogin", "Text to display if acl_access(adminUsers) to jump to the useradmin-page")."</a>";
/*
	if($r->isHere == 0) osgl_table($editLink, "<a href=?inc=userlogin&action=doLogin&user=$user>".lang("Mark as arrived", "inc_userlogin", "link to mark user as arrived")."</a>");
	else osgl_table($editLink, "<a href=?inc=userlogin&action=doLogout&user=$user>".lang("Mark as departed", "inc_userlogin", "link to mark user as departed")."</a>");
*/

	$ticketarray = "<form method=POST action=index.php?inc=userlogin&action=ticketselect&user=$r->ID&search=$search>";

			$ticketarray .= "<select name=ticket>";
			for($i=0;$i<count($tickettype);$i++)
			{
				$ticketarray .= "<option value=$i";
				if($r->ticketType == $i)
				{
					$ticketarray .= " SELECTED";
				}
				$ticketarray .= ">$tickettype[$i]</option>";
			}


			$ticketarray .= "<input type=hidden name=userID value=$row->ID>";
			$ticketarray .= "<input type=submit value='".$msg['38']."'>";
		$ticketarray .= "</form>";
	osgl_table($editLink, $ticketarray);
	osgl_table(lang("Users First name", "inc_userlogin", "Field to show in userlogin for first name"), $r->firstName);
	osgl_table(lang("Users Last name", "inc_userlogin", "Field to show in userlogin for last name"), $r->lastName);
	osgl_table(lang("Users birthday/birthmonth/birthyear", "inc_userlogin", "Field to show in userlogin for birthday"), $r->birthDAY."/".$r->birthMONTH."/".$r->birthYEAR);
	osgl_table(lang("Users email", "inc_userlogin", "Field to show in userlogin for email"), $r->EMail);
	osgl_table(lang("Users home address", "inc_userlogin", "Field to show in userlogin for street"), $r->street);
	osgl_table(lang("Users Postaddress (number place)", "inc_userlogin", "Field to show in userlogin for postaddress"), $r->postNr." ".$r->postPlace);
	osgl_table(lang("Users seatreservation", "inc_userlogin", "Field to show in userlogin for first name"), $r->seatX." / ".$r->seatY);



	echo "<form method=POST action=index.php?inc=userlogin&action=loginComments&user=$user>";
	osgl_table(lang("Crewcomments", "inc_userlogin", "textarea for admins/crew to put in their comments about the user in userlogin"), "<textarea name=comments cols=65 rows=10>$r->loginComments</textarea>");

	osgl_table("", "<input type=submit value='".lang("Save comments", "inc_userlogin", "submit-button to save comments")."'>");
	echo "</form>";

	if(acl_access("root")) {
		// Dask-code
		$daskarray = NULL;
		$daskarray .= "<form method=POST action=index.php?inc=userlogin&action=dask&user=$user>";
		$daskarray .= "<select name=dasklevel>";
		for($i=0;$i<count($dasklevels);$i++) {
			$daskarray .= "<option value=$i";
			if($i == $r->userIsToBeDasked) $daskarray .= " SELECTED";
			$daskarray .= ">$dasklevels[$i]</option>";
		}
		$daskarray .= "</select>";
		osgl_table($daskarray, "<input type=submit value='".lang("Submit", "inc_userlogin")."'>");
	} // End if acl_access = root
	echo "</table>";


}

elseif($action == "loginComments") {
	$escUser = escape_string($user);
	$comment = $_POST['comments'];

	query("UPDATE users SET loginComments = '".escape_string($comment)."' WHERE ID = $escUser");
	dblog(14, $user.":::".$comment);
	refresh("index.php?inc=userlogin&action=login&user=$user", 0);


}
elseif ($action == "doLogin")
{
	$query = query("UPDATE users SET isHere = 1 WHERE ID = '".escape_string($user)."'");
	refresh("index.php?inc=userlogin&action=login&user=$user", 0);
	dblog(12, "User arrived");
}
elseif($action == "doLogout")
{
	$query = query("UPDATE users SET isHere = 0 WHERE ID = '".escape_string($user)."'");
	refresh("index.php?inc=userlogin&action=login&user=$user", 0);
	dblog(13, "User departed");
}

elseif($action == "dask") {
	if(!acl_access("root")) die($admin['noaccess']);
	$dasklevel = $_POST['dasklevel'];
	$user = $_GET['user'];
	query("UPDATE users SET userIsToBeDasked = '$dasklevel' WHERE ID = $user");
	refresh("index.php?inc=userlogin&action=login&user=$user", 0);
	dblog(19, "$dasklevel");
}