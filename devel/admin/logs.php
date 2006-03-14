<?php

require_once ('config/config.php');

if (!acl_access("logs"))
{
	nicedie($admin['noaccess']);
}


if (isset($_GET['action']))
{
	$action = $_GET['action'];
}
if (isset($_GET['userid']))
{
	$userid = $_GET['userid'];
}

echo "<a href='admin.php?adminmode=logs&action=last'>".lang("Show last logentries", "admin_logs")."</a><br>\n";
echo "<a href='admin.php?adminmode=logs&action=user'>".lang("Show logentries for user", "admin_logs")."</a><br>\n";
echo "<br><br>";

if (!isset($action))
{
	$action ='last';
}

if ($action == 'last')
{
		echo "<table class='log' border=1>\n";
		echo "<tr class='logheader'><td class='logheader' colspan=5><b>".lang("Last 10 logentries", "admin_logs")."</b></td></tr>\n";
		echo "<tr class='log'><td class='log'>".lang("Userid", "admin_logs")."</td><td class='log'>".lang("Time", "admin_logs")."</td><td class='log'>".lang("Action", "admin_logs")."</td><td>".lang("Message", "admin_logs")."</td><td>".lang("IP-address", "admin_logs")."</td></tr>\n";
		showlog (10);
		echo "</table>\n";
	}
elseif ($action == 'user')
{
	if (!$userid)
	{
		echo lang("Select a user", "admin_logs").":\n";
		echo "<form action='admin.php' method='GET'>\n";
		echo "<input type='hidden' name='action' value='user'>\n";
		echo "<input type='hidden' name='adminmode' value='logs'>\n";
		
		echo "<select name='userid'>\n";
		
		$query = sprintf ("SELECT ID, nick FROM users");
		$result = query ($query);
		while ($user = fetch ($result))
		{
			echo "<option value='$user->ID'>$user->ID $user->nick</option>\n";
		}

		echo "</select>\n";
		
		echo "<input type='submit'>\n";
		echo "</form>\n";
	}
	elseif (is_numeric($userid))
	{
		echo "<form action='admin.php' method='GET'>\n";
		echo "<input type='hidden' name='action' value='user'>\n";
		echo "<input type='hidden' name='adminmode' value='logs'>\n";
		
		echo "<select name='userid'>\n";
		
		$query = sprintf ("SELECT ID, nick FROM users");
		$result = query ($query);
		while ($user = fetch ($result))
		{
			if ($userid == $user->ID)
			{
				$checked = 'SELECTED';
			}
			echo "<option $checked value='$user->ID'>$user->ID $user->nick</option>\n";
			unset ($checked);
		}

		echo "</select>\n";
		
		echo "<input type='submit'>\n";
		echo "</form>\n";
		echo "<table class='log' border=1>\n";
		echo "<tr class='logheader'><td class='logheader' colspan=5><b>".lang("Last 10 logentries for", "admin_logs")." #$userid</b></td></tr>\n";
		echo "<tr class='log'><td class='log'>".lang("Userid", "admin_logs")."</td><td class='log'>".lang("Time", "admin_logs")."</td><td class='log'>".lang("Action", "admin_logs")."</td><td>".lang("Message", "admin_logs")."</td><td>".lang("IP-address", "admin_logs")."</td></tr>\n";
		showlog (10, $userid);
		echo "</table>\n";
	}
}
