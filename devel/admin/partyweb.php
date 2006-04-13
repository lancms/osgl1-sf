<?php

require_once $base_path.'config/config.php';

if(!acl_access("partyweb"))
{
	nicedie($admin[noaccess]);
}

$action = $_GET['action'];
$edit = $_GET['edit'];


if (!isset($action))
{
	$query = query("SELECT * FROM partyweb ORDER BY menuname ASC");
	$q = query("SELECT * FROM partyweb_screens");
	
	echo "<table>";
	echo "<tr><th>ID/edit</th><th>".lang("Menuname", "admin_partyweb", "partyweb[0]")."</th><th>".lang("Display in menu", "admin_partyweb", "partyweb[1]")."</th>";
	while($rS = fetch($q)) {
	echo "<th>$rS->name</th>";
	}
	echo "</tr>";

	while($r = fetch($query))
	{
		echo "<tr><td>";
		echo "<a href=admin.php?adminmode=partyweb&action=edit&edit=$r->ID>";
		echo $r->ID;
		echo "</td><td>";
		echo $r->menuname;
		echo "</td><td>";
		echo $true_false[$r->display_menu];
		echo "</td>";
		$q = query("SELECT * FROM partyweb_showscreen WHERE slideID = $r->ID ORDER BY screenID ASC");
		while($r = fetch($q)) {
			if($r->partyshow == 1) echo "<td><img src=images/yes.gif></td>";
			else echo "<td><img src=images/no.gif></td>";
		}
		
		echo "</tr>";
	}
	echo "</table>";

	echo "<form method=POST action=admin.php?adminmode=partyweb&action=add>";
	echo "<input type=text name='menuname'> ".lang("Menuname", "admin_partyweb", "partyweb[0]");
	echo "<br><input type=submit value='".lang("Save", "admin_partyweb", "form[15]")."'>";
	echo "</form>";

	echo "<form method=POST action=admin.php?adminmode=partyweb&action=addscreen>";
	echo "<br><br><input type=text name='screenname'> ".lang("Name of screen to add", "admin_partyweb");
	echo "<br><input type=submit value='".lang("Add", "admin_partyweb")."'>";
	echo "</form>";

}
elseif (($action == "edit") && (isset($edit)))
{
	$query = query("SELECT * FROM partyweb WHERE ID = '".escape_string($edit)."'");
	$row = fetch($query);

	echo "<form method=post action=admin.php?adminmode=partyweb&edit=$edit&action=save>";

	echo "<br><input type=text name=menuname size=20 value='$row->menuname'> ".lang("Menuname", "admin_partyweb", "partyweb[0]");
	echo "<br><textarea name=text cols=65 rows=15>$row->text</textarea>";
	echo "<br><input type=checkbox name=display_menu";
	if ($row->display_menu == 1)
	{
		echo " CHECKED";
	}
	echo " value=1> ".lang("Display in menu", "admin_partyweb", "partyweb[1]");

	$q = query("SELECT * FROM partyweb_screens");
	while($r = fetch($q)) {
		$q2 = query("SELECT * FROM partyweb_showscreen WHERE screenID = $r->ID AND slideID = '".escape_string($edit)."'");
		$r2 = fetch($q2);
		echo "<br><input type=checkbox name=screen$r->ID";
		if($r2->partyshow == 1) echo " CHECKED";
		echo " value=1> ".lang("Display on screen:", "admin_partyweb").$r->name;
	}
	echo "<br><input type=checkbox name=delete> ".lang("Delete page", "admin_partyweb", "partyweb[3]");

	echo "<br><input type=submit value='".lang("Save", "admin_partyweb", "form[15]")."'>";
	echo "</form>";
}
elseif (($action == "save") && (isset($edit)) && (!isset($_POST['delete'])))
{
	$menuname = escape_string ($_POST['menuname']);
	$text = addslashes($_POST['text']);
	$display_menu = $_POST['display_menu'];
	$q = query("SELECT * FROM partyweb_screens");
	$num = num($q);
	while($r = fetch($q)) {
		$post = $_POST['screen'.$r->ID];
		if($post != 1) $post = 0;
		query("INSERT INTO partyweb_showscreen SET partyshow = $post, screenID = $r->ID, slideID = '".escape_string($edit)."'
			ON DUPLICATE KEY UPDATE partyshow = $post");
	}

#	echo $display_menu;
#	echo "<br>".$display_partymode;

	if (!$display_menu)
	{
		$display_menu = 0;
	}
	else
	{
		$display_menu = 1;
	}
	

	query("UPDATE partyweb SET menuname = '".escape_string($menuname)."',
		text = '".escape_string($text)."',
		display_menu = '".escape_string($display_menu)."'
		WHERE ID = '".escape_string($edit)."'
	");
	

	refresh("admin.php?adminmode=partyweb", 5);
	echo lang("Update complete.", "admin_partyweb", "partyweb[4]");
}
elseif (($action == "save") && (isset($edit)) && (isset($_POST['delete'])))
{
	query("DELETE FROM partyweb WHERE ID = '".escape_string($edit)."'");
	refresh("admin.php?adminmode=partyweb", 0);
}
elseif ($action == "add")
{
	$menuname = $_POST['menuname'];
	query("INSERT INTO partyweb SET menuname = '".escape_string($menuname)."'");
	refresh("admin.php?adminmode=partyweb", 0);
	echo lang("New page added.", "admin_partyweb", "partyweb[5]");
}
elseif($action == "addscreen") {
	$screenname = $_POST['screenname'];
	query("INSERT INTO partyweb_screens SET name = '".escape_string($screenname)."'");
	refresh("admin.php?adminmode=partyweb", 0);
	echo lang("New screen added.", "admin_partyweb");
}

?>
