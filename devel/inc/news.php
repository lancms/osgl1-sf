<?php
require_once 'config/config.php';
if(!config("usepage_news")) die($msg[9]);

$action = $_GET['action'];
$many = $_GET['many'];

if(!isset($action)) {
	$action = "view";
}


if(!isset($many)) $many = $usenews;
elseif($many == "ALL") {

	$select = mysql_query("SELECT ID FROM news");
	$many = mysql_num_rows($select);

}


if($action == "view") {
	
	$query = mysql_query("SELECT * FROM news ORDER BY ID DESC LIMIT 0,".$many) or die(mysql_error());

	$num = mysql_num_rows($query);

	if($num == 0) echo $msg[13];

	for($i=0;$i<$num;$i++) {

		$row = mysql_fetch_object($query);

		echo "<font class=newsHeader>$row->header</font>";
		echo "<br>";
		$queryNick = mysql_query("SELECT * FROM users WHERE ID = $row->poster") or die(mysql_error());

		$nickrow = mysql_fetch_object($queryNick);

		if(mysql_num_rows($queryNick) == 0) {
			$nick_poster = $msg[17];
		} else {
			$nick_poster = $nickrow->nick;
			$nick_poster = "<a href=index.php?inc=profile&uid=$nickrow->ID>$nick_poster</a>";
		}

		echo "<font class=newsPoster>".$msg[14].$nick_poster."</font>";
		echo "<br>";
		echo "<font class=newsText>".nl2br($row->text)."</font>";
		if($i < $num-1)
			echo "<br><hr><br>";
	}

}

?>