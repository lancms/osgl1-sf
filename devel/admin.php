<?php
require_once 'config/config.php';
include $base_path."style/top.php";

if(getuserrank() != 2) {
	die($admin[noaccess]);
}

if(isset($_GET['adminmode'])) {
	$adminmode = $_GET['adminmode'];
}

if(!isset($adminmode)) {

	echo "<a href=admin.php?adminmode=faq>Edit FAQ</a>";
	echo "<br><a href=admin.php?adminmode=static>Edit static files</a>";
	echo "<br><a href=admin.php?adminmode=userlist>Edit users</a>";
	echo "<br><a href=admin.php?adminmode=userlist&action=online>View online users</a>";
	echo "<br><a href=admin.php?adminmode=poll>Polls</a>";
	echo "<br><a href=admin.php?adminmode=news>News-admin</a>";
	echo "<br><a href=admin.php?adminmode=kiosk>Kiosk-admin</a>";
	echo "<br><a href=admin.php?adminmode=random>Random-quote-admin</a>";
	echo "<br><a href=admin.php?adminmode=compo>compo-admin</a>";
	echo "<br><a href=admin.php?adminmode=forum>ForumAdmin</a>";
    echo "<br><a href=admin.php?adminmode=partyweb>PartyAdmin</a>";
    echo "<br><a href=admin.php?adminmode=config>Config</a>";
    echo "<br><a href=admin.php?adminmode=wannabemin>Wannabe admin</a>";

} elseif($adminmode != "") {
	include_once "admin/".$adminmode.".php";
} else {
	die("ERROR?");
}
include $base_path."style/bottom.php";
?>
