<?php

require_once ('config/config.php');

if (!acl_access("wannabe"))
{
	nicedie ($admin['noaccess']);
}

$action = $_GET['action'];

if (!isset($action))
{
	echo "<a href=admin.php?adminmode=wannabemin&action=edittext>Rediger wannabeinfo</a>";
	echo "<br><a href=admin.php?adminmode=wannabemin&action=listWannabes>Se hvem som søker</a>";
	
}
elseif ($action == "edittext")
{
	echo "<form method=POST action=admin.php?adminmode=wannabemin&action=doedittext>";
	echo "<textarea name=tekst cols=75 rows=25>";
	$qT = query("SELECT * FROM config WHERE config = 'wannabetext'");
	$rT = fetch($qT);
	echo $rT->large;
	echo "</textarea><input type=submit value='Lagre'></form>";
}
elseif ($action == "doedittext")
{
	$tekst = $_POST['tekst'];
	config("wannabetext", 1);
	query("UPDATE config SET large = '".escape_string($tekst)."' WHERE config = 'wannabetext'");
	refresh("admin.php?adminmode=wannabemin", 0);
}
elseif ($action == "listWannabes")
{
	$q = query("SELECT * FROM users WHERE wannabe = 1 AND isCrew = 0 AND wannabeDenied != 1");
	echo "<table>";
	while($r = fetch($q))
	{	
		$test = query("SELECT * FROM wannabe WHERE ID = '".escape_string($r->ID)."'");
		if(num($test) == 1)
		{
			$haveIQ = query("SELECT * FROM wannabeAdmin WHERE userID = '".escape_string($r->ID)."' AND adminID = '".escape_string(getcurrentuserid())."'");
			$haveI = fetch($haveIQ);
			if($haveI->shoudBeCrew == 1)
			{
				$image = "ja";
			}
			else
			{
				$image = "nei";
			}
			echo "<tr><td>";
			if(num($haveIQ) != 0)
			{
				echo "<img src=images/".$image.".gif>";
			}
			echo "</td><td>";
			echo "<a href=?adminmode=wannabemin&action=viewUserApplication&user=$r->ID>$r->nick</a>";
			echo "</td><td>";
		
			$comments = query("SELECT * FROM wannabeAdmin WHERE userID = '".escape_string($r->ID)."'");
			echo "(".num($comments).")";
			echo "</td><td>";
			echo $r->name;
			echo "</td><td>";
			echo $r->cellphone;
			echo "</td><td>";
			echo $r->EMail;
			echo "</td></tr>";
			
		}
	}
	echo "</table>";
}
elseif ($action == "viewUserApplication")
{
	$user = $_GET['user'];
	$q = query("SELECT * FROM wannabe WHERE ID = '".escape_string($user)."'");
	$r = fetch_array($q);
	
	$column_count = mysql_num_fields($q);
	
	echo "<table><tr><td>";
	echo "<a href=admin.php?adminmode=wannabemin&action=listWannabes>Tilbake til listen</a></td><td>";
	echo "Info om: ";
	display_nick($user);
	echo "</td></tr>";

	for ($column_num = 1;$column_num < $column_count;$column_num++)
	{
		$field_name = mysql_field_name($q, $column_num);
		$Left = $wannabe[$field_name];
		$data = $r[$column_num];
		
		if ($data == "1")
		{
			$data = "<img src=images/ja.gif>";
		}
		elseif ($data == "0")
		{
			$data = "<img src=images/nei.gif>";
		}
		if ($field_name == "lastUpdated")
		{
			$data = convert_timestamp($data);
		}
		else
		{
			$data = nl2br($data);
		}
		$Right = $data;
		profile_table($Left, $Right);
	}
	echo "</table>\n\n";

	$qu = query("SELECT * FROM wannabeAdmin WHERE userID = '".escape_string($user)."'");
	echo "<table>";
	while ($ru = fetch($qu))
	{
		if ($ru->adminID == getcurrentuserid())
		{
			echo "<form method=POST action=admin.php?adminmode=wannabemin&action=editAdminInfo&user=$user>";
			echo "<tr><td></td><td>";
			if ($ru->shoudBeCrew)
			{
				$selected = "CHECKED";
			}
			echo "<input type=checkbox name=shoudBeCrew value=1 $selected> Anbefales?";
			echo "</td><td>";
			echo "<textarea name=moreinfo cols=50 rows=7>$ru->moreinfo</textarea>";
			echo "</td><td><input type=submit value='Lagre oppdatering'></form>";
		}
		else
		{
			echo "<tr><td>";
			echo display_nick($ru->adminID);
			echo "</td><td>";
			$data = $ru->shoudBeCrew;
			if ($data == "1")
			{
				$data = "<img src=images/ja.gif>";
			}
			elseif ($data == "0")
			{
				$data = "<img src=images/nei.gif>";
			}
			echo $data;
			echo "</td><td>$ru->moreinfo</td></tr>";
		}	
	}
	$test = query("SELECT * FROM wannabeAdmin WHERE adminID = '".escape_string(getcurrentuserid())."' AND userID = '".escape_string($user)."'");
	if (num($test) == 0)
	{
		echo "<tr><td><a href=?adminmode=wannabemin&action=addComment&user=$user>Legg til kommentar</a></td></tr>";
	}
	echo "</table>";
	}
	elseif ($action == "addComment")
	{
		$user = $_GET['user';
		query("INSERT INTO wannabeAdmin SET adminID = '".escape_string(getcurrentuserid())."', userID = '".escape_string($user)."'");
		refresh("admin.php?adminmode=wannabemin&action=viewUserApplication&user=$user", 0);
	}
	elseif ($action == "editAdminInfo")
	{
		$user = $_GET['user'];
		$shoudBeCrew = $_POST['shoudBeCrew'];
		$moreinfo = $_POST['moreinfo'];
		$adminID = getcurrentuserid();
		query("UPDATE wannabeAdmin SET
			moreinfo = '".escape_string($moreinfo)."',
			shoudBeCrew = '".escape_string($shoudBeCrew)."',
			lastUpdated = '".escape_string(time())."'
			WHERE userID = '".escape_string($user)."' AND adminID = '".escape_string($adminID)."'");
		refresh("?adminmode=wannabemin&action=viewUserApplication&user=$user", 0);
	}
	elseif ($action == "viewAllApplication")
	{
		$q = query("SELECT * FROM wannabe");
		while($r = fetch_array($q)) {
		$user = $r[0];
		$column_count = mysql_num_fields($q);
		echo "<table><tr><td>";
		echo "<a href=admin.php?adminmode=wannabemin&action=listWannabes>Tilbake til listen</a></td><td>";
		echo "Info om: ";
		display_nick($user);
		echo "</td></tr>";

		for($column_num = 1;$column_num < $column_count;$column_num++)
		{
			$field_name = mysql_field_name($q, $column_num);
			$Left = $wannabe[$field_name];
			$data = $r[$column_num];
			if ($data == "1")
			{
				$data = "<img src=images/ja.gif>";
			}
			elseif ($data == "0")
			{
				$data = "<img src=images/nei.gif>";
			}
			if ($field_name == "lastUpdated")
			{
				$data = convert_timestamp($data);
			}
			else
			{
				$data = nl2br($data);
			}
			$Right = $data;
			profile_table($Left, $Right);
		}
		echo "</table>\n\n";

		$qu = query("SELECT * FROM wannabeAdmin WHERE userID = '".escape_string($user)."'");
		echo "<table>";
		while($ru = fetch($qu))
		{
			echo "<tr><td>";
			echo display_nick($ru->adminID);
			echo "</td><td>";
			$data = $ru->shoudBeCrew;
			if ($data == "1")
			{
				$data = "<img src=images/ja.gif>";
			}
			elseif ($data == "0")
			{
				$data = "<img src=images/nei.gif>";
			}
			echo $data;
			echo "</td><td>$ru->moreinfo</td></tr>";
		}
		$test = query("SELECT * FROM wannabeAdmin WHERE adminID = '".escape_string(getcurrentuserid())."' AND userID = '".escape_string($user)."'");
		if (num($test) == 0)
		{
			echo "<tr><td><a href=?adminmode=wannabemin&action=addComment&user=$user>Legg til kommentar</a></td></tr>";
		}
		echo "</table>";
	}	
}

?>
