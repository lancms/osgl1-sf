<?php
require_once 'config/config.php';
include $base_path."style/top.php";

if(!acl_access("displayAdmin")) {
	nicedie($admin['noaccess']);
}

if(isset($_GET['adminmode'])) {
	$adminmode = $_GET['adminmode'];
}

if(!isset($adminmode)) {

if(acl_access("compomaster")) echo "<a href=admin.php?adminmode=compomaster>compo-admin</a>";
if(acl_access("partyweb")) echo "<br><a href=admin.php?adminmode=partyweb>PartyAdmin</a>";
	
if(acl_access("faq")) echo "<br><a href=admin.php?adminmode=faq>Edit FAQ</a>";
if(acl_access("static")) echo "<br><a href=admin.php?adminmode=static>Edit static files</a>";
if(acl_access("adminUsers")) echo "<br><a href=admin.php?adminmode=userlist>Edit users</a>";
if(acl_access("onlineUsers")) echo "<br><a href=admin.php?adminmode=userlist&action=online>View online users</a>";
if(acl_access("poll")) echo "<br><a href=admin.php?adminmode=poll>Polls</a>";
if(acl_access("news")) echo "<br><a href=admin.php?adminmode=news>News-admin</a>";
#	echo "<br><a href=admin.php?adminmode=kiosk>Kiosk-admin</a>"; // Doesn't work
#	echo "<br><a href=admin.php?adminmode=random>Random-quote-admin</a>";
if(acl_access("ACL")) echo "<br><a href=admin.php?adminmode=acl>ACL-admin</a>";
#	echo "<br><a href=admin.php?adminmode=forum>ForumAdmin</a>";
    
if(acl_access("config")) echo "<br><a href=admin.php?adminmode=config>Config</a>";
if(acl_access("wannabe")) echo "<br><a href=admin.php?adminmode=wannabemin>Wannabe admin</a>";
if(acl_access("compopoll")) echo "<br><a href=admin.php?adminmode=compopolladmin> Compoavstemningsadmin</a>";


} elseif($adminmode != "") {
	include_once "admin/".$adminmode.".php";
} else {
	// Default reason works?
	nicedie();
}
include $base_path."style/bottom.php";
?>
