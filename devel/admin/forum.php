<?php

/* This system is not maintained any more!! */
require 'config/config.php';

if(getuserrank() != 2) {
	die($admin[noaccess]);
}
$action = $_GET['action'];
if(!isset($action)) $action = "list";

if($action == "list") {
	$q = mysql_query("SELECT * FROM forumCats");
	echo "<table>";
	while($r = mysql_fetch_object($q)) {
		echo '<tr><td>';
		echo $r->name;
		echo '</td><td>';
		echo $r->info;
		echo '</td></tr>';

	}

	echo '</table>';

	echo '<br><hr><br><br>';
	echo '<form method=post action=admin.php?adminmode=forum&action=addCat>';
	echo '<input type=text name=name> '.$form[50];
	echo '<br><input type=text name=info> '.$form[51];
	echo '<br><input type=submit value=\''.$form[15].'\'>';
	echo '</form>';

}

elseif($action == "addCat") {
	$name = $_POST['name'];
	$info = $_POST['info'];

	mysql_query("INSERT INTO forumCats SET name = '$name', info = '$info'") or die(mysql_error());
	refresh("admin.php?adminmode=forum", "0");
}

