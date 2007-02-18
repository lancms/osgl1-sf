<?php
require_once ('config/config.php');
require_once ($base_path."style/top.php");

if(!acl_access("displayAdmin"))
{
	nicedie($admin['noaccess']);
}

if(isset($_GET['adminmode']))
{
	$adminmode = $_GET['adminmode'];
}

if(!isset($adminmode))
{
	if(acl_access("partyweb"))
	{
		echo "<br><a href=admin.php?adminmode=partyweb>".lang("PartyAdmin", "admin_index", "Menuitem in admin.php to view PartyAdmin-interface")."</a>";
	}

	if(acl_access("faq"))
	{
		echo "<br><a href=admin.php?adminmode=faq>".lang("FAQadmin", "admin_index", "Menuitem in admin.php to view FAQadmin-interface")."</a>";
	}

	if(acl_access("static"))
	{
		echo "<br><a href=admin.php?adminmode=static>".lang("StaticAdmin", "admin_index", "Menuitem in admin.php to view static files")."</a>";
	}

	if(acl_access("adminUsers"))
	{
		echo "<br><a href=admin.php?adminmode=userlist>".lang("Users", "admin_index", "Menuitem in admin.php to edit users")."</a>";
	}

	if(acl_access("onlineUsers"))
	{
		echo "<br><a href=admin.php?adminmode=userlist&action=online>".lang("Online Users", "admin_index", "Menuitem in admin.php to list users currently online")."</a>";
	}

	if(acl_access("poll"))
	{
		echo "<br><a href=admin.php?adminmode=poll>".lang("Polls", "admin_index", "Menuitem in admin.php to view and edit polls")."</a>";
	}

	if(acl_access("news"))
	{
		echo "<br><a href=admin.php?adminmode=news>".lang("News", "admin_index", "Menuitem in admin.php to view/edit/add news")."</a>";
	}

	if(acl_access("ACL"))
	{
		echo "<br><a href=admin.php?adminmode=acl>".lang("Accessmanagement", "admin_index", "Menuitem on admin.php to manipulate groups and ACL-rights")."</a>";
		echo "<br><a href=admin.php?adminmode=export>".lang("User Export", "admin_index", "Menuitem on admin.php to export crew")."</a>";
	}

	if(acl_access("wannabe")) echo "<br><a href=admin.php?adminmode=wannabemin>Wannabe admin</a>";

	if(acl_access("compomaster"))
	{
		echo "<br><a href=admin.php?adminmode=compomaster>".lang("CompoMaster", "admin_index", "Menuitem in admin.php to manipulate compos")."</a>";
	}

	if(acl_access("compopoll"))
	{
		echo "<br><a href=admin.php?adminmode=compopolladmin>".lang("Compopolladmin", "admin_index", "Menuitem in admin.php to view/edit/add compopolls")."</a>";
	}

	if(acl_access("config"))
	{
		echo "<br><a href=admin.php?adminmode=config>".lang("System Configurations", "admin_index", "Menuitem in admin.php to change config")."</a>";
	}
	if (acl_access("logs"))
	{
		echo "<br><a href=admin.php?adminmode=logs>".lang("View logs", "admin_index", "Menuitem in admin.php to view logs")."</a>";
	}

	if(acl_access("tasks"))
	{
		echo "<br><a href=admin.php?adminmode=tasks>".lang("Taskmanager", "admin_index", "Menuitem in admin.php to list and add tasks")."</a>";
	}
	if(acl_access("kioskAdmin"))
	{
		echo "<br><a href=admin.php?adminmode=kiosk>".lang("Kioskadmin", "admin_index", "Menuitem in admin.php to mange the kiosk")."</a>";
	}
}
elseif ($adminmode != "")
{
	if (strchr($_GET['adminmode'], ".")) {
		dblog(10, "User attempted to put . in GET[adminmode].");
		nicedie("Sorry, you are not allowed to put . in URL. Logged!");
	}
	require_once ("admin/".$adminmode.".php");
}
else
{
	nicedie("Admin.php doesn't have a clue what you want.");
}
require_once ($base_path."style/bottom.php");
?>
