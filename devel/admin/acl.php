<?php

require_once 'config/config.php';

if (!acl_access("ACL"))
{
	nicedie($admin[noaccess]);
}

$action = $_GET['action'];
$edit = $_GET['edit'];

if (!isset($action))
{
	$q = query("SELECT * FROM groups");
	echo "<table>";
	while($r = fetch($q))
	{
		echo "<tr><td>";
		echo "<a href=admin.php?adminmode=acl&action=edit&edit=$r->ID>$r->groupname</a>";
		echo "</td><td>";
		echo "<a href=admin.php?adminmode=acl&action=rename&edit=$r->ID>".lang("Rename", "admin_acl", "form[62]")."</a>";
		echo "</td><td>";
		echo "<a href=admin.php?adminmode=acl&action=delete&edit=$r->ID>".lang("Delete", "admin_acl", "form[16]")."</a>";
		echo "</td></tr>";
	}
	echo "</table>";
	
	echo "<br><br><br><hr><br>";
	echo "<form method=POST action=admin.php?adminmode=acl&action=add>";
	echo "<input type=text name=groupname><input type=submit value='".lang("Add group", "admin_acl", "form[61]")."'>";
	echo "</form>";
}
elseif ($action == "add")
{
	$groupname = $_POST['groupname'];
	$test = query("SELECT * FROM groups WHERE groupname LIKE '".escape_string($groupname)."'");
	if(num($test) != 0)
	{
		nicedielang ("A group with that name already exists.", "admin_acl", "form[63]");
	}
	query("INSERT INTO groups SET groupname = '".escape_string($groupname)."'");
	refresh("admin.php?adminmode=acl", 0);
}
elseif (($action == "edit") && (isset($edit)))
{
	echo "<a href=admin.php?adminmode=acl>Tilbake til Gruppeadmin</a><br>";
	
	echo "<form method=POST action=admin.php?adminmode=acl&action=updateGroup&edit=$edit>";
	echo "<table>";
	for ($i = 0;$i<count($acl);$i++)
	{
		$this_acl = $acl[$i];
		$q = query("SELECT * FROM acls WHERE groupID = '".escape_string($edit)."' AND access = '".escape_string($this_acl['access'])."'");
		$r = fetch($q);
		if (num($q) == 0)
		{
			$select = 0;
		}
		else
		{
			$select = $r->value;
		}
		echo "<tr><td><input type=checkbox name='".$this_acl['access']."'";
		if($select)
		{
			echo " CHECKED";
		}
		echo " value=1></td><td> ".$this_acl['name'];
		echo "</td></tr>";
	}
	echo "</table>";
	echo "<br><input type=submit value='".lang("Save", "admin_acl", "form[15]")."'>";
	echo "</form>";
	
	$q2 = query("SELECT * FROM users WHERE myGroup = '".escape_string($edit)."'");
	echo lang("Members:", "admin_acl", "form[64]")." (".num($q2).")";
	echo "<table>";
	
	while ($r2 = fetch($q2))
	{
		echo "<tr><td>";
		display_nick($r2->ID);
		echo "</td></tr>";
	}
	echo "</table>";
}
elseif ($action == "updateGroup")
{
	$edit = $_GET['edit'];
	for($i=0;$i<count($acl);$i++)
	{
		$this_acl = $acl[$i];
		$this_access = $this_acl['access'];
		//echo $this_acl['access'];
		$post = $_POST[$this_access];
		
		$test = query("SELECT * FROM acls WHERE groupID = '".escape_string($edit)."' AND access = '".escape_string($this_access)."'");
		if(num($test) == 0)
		{
			query("INSERT INTO acls SET groupID = '".escape_string($edit)."',
					access = '".escape_string($this_access)."',
					value = '".escape_string($post)."'");
		}
		else
		{
			query("UPDATE acls SET value = '".escape_string($post)."' WHERE access = '".escape_string($this_access)."' AND groupID = '".escape_string($edit)."'");
		} // End check if acl exists
		
	} // End for-loop
	refresh("admin.php?adminmode=acl&action=edit&edit=$edit", 0);
} 
elseif (($action == "delete") && (isset($edit)))
{
	$confirm = $_GET['confirm'];
	if ($confirm == "YES")
	{
		query("DELETE FROM groups WHERE ID = '".escape_string($edit)."'");
		query("DELETE FROM acls WHERE groupID = '".escape_string($edit)."'");
		query("UPDATE users SET myGroup = 1 WHERE myGroup = '".escape_string($edit)."'");
		refresh("admin.php?adminmode=acl", 2);
		echo lang ("Group deleted", "admin_acl", "form[65]");
	}
	else
	{
		$q = query("SELECT * FROM groups WHERE ID = '".escape_string($edit)."'");
		$r = fetch($q);
		echo lang("Delete group:", "admin_acl", "form[66]")." ".$r->groupname."?";
		echo "<br>";
		echo "<a href=admin.php?adminmode=acl&action=delete&edit=$edit&confirm=YES>".lang("Yes", "admin_acl", "true_false[1]")."</a> - ";
		echo "<a href=admin.php?adminmode=acl>".lang("No", "admin_acl", "true_false[0]")."</a>";
	}
	
}
elseif ($action == "rename" && isset($edit))
{
	$q = query("SELECT * FROM groups WHERE ID = '".escape_string($edit)."'");
	$r = fetch($q);
	echo "<form method=POST action=admin.php?adminmode=acl&action=dorename&edit=$edit>\n";
	echo "<input type=text name=name value='$r->groupname'><input type=submit value='".lang("Rename", "admin_acl", "form[62]")."'>";
	echo "</form>";
}
elseif (($action == "dorename") && (isset($edit)))
{
	$newName = ($_POST['name']);
	query("UPDATE groups SET groupname = '".escape_string($newName)."' WHERE ID = '".escape_string($edit)."'");
	echo lang("Renamed to", "admin_acl", "form[67]")." $newName";
	refresh("admin.php?adminmode=acl", 2);
}

?>
