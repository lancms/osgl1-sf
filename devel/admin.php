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

if(acl_access("partyweb")) echo "<br><a href=admin.php?adminmode=partyweb>".$admin['0']."</a>";
	
if(acl_access("faq")) echo "<br><a href=admin.php?adminmode=faq>".$admin['1']."</a>";
if(acl_access("static")) echo "<br><a href=admin.php?adminmode=static>".$admin['2']."</a>";
if(acl_access("adminUsers")) echo "<br><a href=admin.php?adminmode=userlist>".$admin['3']."</a>";
if(acl_access("onlineUsers")) echo "<br><a href=admin.php?adminmode=userlist&action=online>".$admin['4']."</a>";
if(acl_access("poll")) echo "<br><a href=admin.php?adminmode=poll>".$admin['5']."</a>";
if(acl_access("news")) echo "<br><a href=admin.php?adminmode=news>".$admin['6']."</a>";
if(acl_access("ACL")) echo "<br><a href=admin.php?adminmode=acl>".$admin['7']."</a>";

// Disabled. Needs rewrite and will be removed sometime soon.
//if(acl_access("wannabe")) echo "<br><a href=admin.php?adminmode=wannabemin>Wannabe admin</a>";

if(acl_access("compomaster")) echo "<br><a href=admin.php?adminmode=compomaster>".$admin['8']."</a>";
if(acl_access("compopoll")) echo "<br><a href=admin.php?adminmode=compopolladmin>".$admin['9']."</a>";

if(acl_access("config")) echo "<br><br><a href=admin.php?adminmode=config>".$admin['10']."</a>";


} elseif($adminmode != "") {
	include_once "admin/".$adminmode.".php";
} else {
	// Default reason works?
	nicedie();
}
include $base_path."style/bottom.php";
?>
