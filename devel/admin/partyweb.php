<?php

require_once $base_path.'config/config.php';

if(getuserrank() != 2) {
	die($admin[noaccess]);
}
$action = $_GET['action'];
$edit = $_GET['edit'];



if(!isset($action)) {

$query = mysql_query("SELECT * FROM partyweb ORDER BY menuname ASC");

echo "<table>";
echo "<tr><th>ID/edit</th><th>Menuname</th><th>Display in menu</th><th>Display in partymode</th></tr>";

while($r = mysql_fetch_object($query)) {

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
echo "<input type=text name='menuname'> Menuname";
echo "<br><input type=submit value='$form[15]'>";
echo "</form>";

}


elseif($action == "edit" && isset($edit)) {

$query = mysql_query("SELECT * FROM partyweb WHERE ID = $edit");
$row = mysql_fetch_object($query);

echo "<form method=post action=admin.php?adminmode=partyweb&edit=$edit&action=save>";

echo "<br><input type=text name=menuname size=20 value='$row->menuname'> Menuname";
echo "<br><textarea name=text cols=65 rows=15>$row->text</textarea>";
echo "<br><input type=checkbox name=display_menu";
if($row->display_menu == 1) echo " CHECKED";
echo " value=1> Display Menu";

echo "<br><input type=checkbox name=display_partymode";
if($row->display_partymode == 1) echo " CHECKED";
echo " value=1> Display Partymode";

echo "<br><input type=checkbox name=delete> Delete page";

echo "<br><input type=submit value='$form[15]'>";
echo "</form>";

}

elseif($action == "save" && isset($edit) && !isset($_POST['delete'])) {
$menuname = $_POST['menuname'];
$text = addslashes($_POST['text']);

echo $display_menu;
echo "<br>".$display_partymode;
$display_menu = $_POST['display_menu'];
$display_partymode = $_POST['display_partymode'];

if(!$display_menu) $display_menu = 0;
else $display_menu = 1;
if(!$display_partymode) $display_partymode = 0;
else $display_partymode = 1;

mysql_query("UPDATE partyweb SET menuname = '$menuname', 
	text = '$text', 
        display_menu = $display_menu, 
        display_partymode = $display_partymode WHERE ID = $edit")
        or die(mysql_error());
 
refresh("admin.php?adminmode=partyweb", 5);
echo "edit successfull";
} elseif($action == "save" && isset($edit) && isset($_POST['delete'])) {
mysql_query("DELETE FROM partyweb WHERE ID = $edit") or die(mysql_error());
refresh("admin.php?adminmode=partyweb", 0);
}

elseif($action == "add") {
$menuname = $_POST['menuname'];

mysql_query("INSERT INTO partyweb SET menuname = '$menuname'");
refresh("admin.php?adminmode=partyweb", 0);
echo "New page added";
}
