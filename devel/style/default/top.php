<?php
require_once 'config/config.php';

$style = user_style();
#if($style == "default") {
/*	$q = mysql_query("SELECT * FROM config WHERE config = 'default_style'");
	$r = mysql_fetch_object($q);
	$style = $r->value;
	*/
#	$style = config("default_style");
##}
#echo config("default_style");
include $base_path."style/".$style."/top.php";
#die("spam:".$style);
