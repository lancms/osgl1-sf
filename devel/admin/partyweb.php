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

	echo "<table>";
	echo "<tr><th>ID/edit</th><th>".$partyweb['0']."</th><th>".$partyweb['1']."</th><th>".$partyweb['2']."</th></tr>";

	while($r = fetch($query))
	{
		echo "<tr><td>";
		echo "<a href=admin.php?adminmode=partyweb&action=edit&edit=$r->ID>";
		echo $r->ID;
		echo "</td><td>";
		echo $r->menuname;
		echo "</td><td>";
		echo $true_false[$r->display_menu];
		echo "</td><td>";
		echo $true_false[$r->display_partymode];
		echo "</td></tr>";
	}
	echo "</table>";

	echo "<form method=POST action=admin.php?adminmode=partyweb&action=add>";
	echo "<input type=text name='menuname'> ".$partyweb['0'];
	echo "<br><input type=submit value='$form[15]'>";
	echo "</form>";

}
elseif (($action == "edit") && (isset($edit)))
{
	$query = query("SELECT * FROM partyweb WHERE ID = '".escape_string($edit)."'");
	$row = fetch($query);

	echo "<form method=post action=admin.php?adminmode=partyweb&edit=$edit&action=save>";

	echo "<br><input type=text name=menuname size=20 value='$row->menuname'> ".$partyweb['0'];
	echo "<br><textarea name=text cols=65 rows=15>$row->text</textarea>";
	echo "<br><input type=checkbox name=display_menu";
	if ($row->display_menu == 1)
	{
		echo " CHECKED";
	}
	echo " value=1> ".$partyweb['1'];

	echo "<br><input type=checkbox name=display_partymode";
	if ($row->display_partymode == 1)
	{
		echo " CHECKED";
	}
	echo " value=1> ".$partyweb['2'];

	echo "<br><input type=checkbox name=delete> ".$partyweb['3'];

	echo "<br><input type=submit value='$form[15]'>";
	echo "</form>";
}
elseif (($action == "save") && (isset($edit)) && (!isset($_POST['delete'])))
{
	$menuname = escape_string ($_POST['menuname'];
	$text = addslashes($_POST['text']);
	$display_menu = $_POST['display_menu'];
	$display_partymode = $_POST['display_partymode'];
	
	echo $display_menu;
	echo "<br>".$display_partymode;

	if (!$display_menu)
	{
		$display_menu = 0;
	}
	else
	{
		$display_menu = 1;
	}
	if (!$display_partymode)
	{
		$display_partymode = 0;
	}
	else
	{
		$display_partymode = 1;
	}

	query("UPDATE partyweb SET menuname = '".escape_string($menuname)."',
		text = '".escape_string($text)."',
		display_menu = '".escape_string($display_menu)."',
		display_partymode = '".escape_string($display_partymode)."' WHERE ID = '".escape_string($edit)."'
	");

	refresh("admin.php?adminmode=partyweb", 5);
	echo $partyweb['4'];
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
	echo $partyweb['5'];
}

?>
