<?php

require_once ('config/config.php');

if (!acl_access("config"))
{
	nicedie($admin['noaccess']);
}


if (isset($_GET['action']))
{
	$action = $_GET['action'];
}


/* Define the config-variables we want to have a checkbox on */
$checkbox[] = "usepage_faq";
$checkbox[] = "usepage_register";
$checkbox[] = "usepage_poll";
$checkbox[] = "usepage_static";
$checkbox[] = "usepage_profile";
$checkbox[] = "usepage_seat";
$checkbox[] = "usepage_compo";
$checkbox[] = "usepage_news";
$checkbox[] = "usepage_partyweb";
$checkbox[] = "seatreg_open";
$checkbox[] = "usepage_wannabe";
$checkbox[] = "usepage_compopoll";
$checkbox[] = "disable_userstyle";
$checkbox[] = "usepage_show_stats";

if (!isset($action))
{
	echo "<form method=POST action=admin.php?adminmode=config&action=save>";
	for($i = 0; $i < count($checkbox); $i++)
	{
		$value = config($checkbox[$i]);
		echo "<br><input type=checkbox name='".$checkbox[$i]."' ";
		if ($value)
		{
			echo "CHECKED ";
		}
		echo "value=1> ".lang($checkbox[$i], "admin_config", "checkbox-item in admin/config.php, as they are displayed on the page");
	}
	echo "<br><input type=submit value='".lang("Save", "admin_config", "form[15]")."'>";
	echo "</form>";
}

elseif ($action == "save")
{
	for($i = 0; $i < count($checkbox); $i++)
	{
		$value = $checkbox[$i];
		$post = $_POST[$value];
		//echo "<br>".$value." --- ".$post;
		if (!$post)
		{
			$post = "0";
		}
		config($checkbox[$i], $post);
	}
	refresh("admin.php?adminmode=config");
}

?>
