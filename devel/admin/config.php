<?php

require 'config/config.php';

if(!acl_access("config")) die($admin[noaccess]);


if(isset($_GET['action'])) {
	$action = $_GET['action'];
}


/* Define the config-variables we want to have a checkbox on */
$checkbox[] = "usepage_forum";
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
#$checkbox[] = "usepage_kiosk"; // Doesn't work
$checkbox[] = "usepage_compopoll";

if(!isset($action)) {
	echo "<form method=POST action=admin.php?adminmode=config&action=save>";
	for($i = 0; $i < count($checkbox); $i++) {
		$value = config($checkbox[$i]);
		echo "<br><input type=checkbox name='".$checkbox[$i]."' ";
		if($value) echo "CHECKED ";
		echo "value=1> ".$checkbox[$i];
	}
	echo "<br><input type=submit value='$form[15]'>";
	echo "</form>";
}

elseif($action == "save") {
	for($i = 0; $i < count($checkbox); $i++) {
		$value = $checkbox[$i];
		$post = $_POST[$value];
		//echo "<br>".$value." --- ".$post;
		if(!$post) $post = "0";
		config($checkbox[$i], $post);
	}
	refresh("admin.php?adminmode=config");
}
