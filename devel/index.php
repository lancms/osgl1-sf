<?php

require './config/config.php';

include $base_path."style/top.php";
if(isset($_GET['inc'])) {
	if(strchr($_GET['inc'], "."))
		nicedie($msg['29']);

    include "inc/".$_GET['inc'].".php";
} elseif(isset($_GET['page'])) {
	$page = mysql_escape_string ($_GET['page']);
	$query = query("SELECT * FROM static WHERE header LIKE '".$page."'");
	$object = fetch($query);
	if($object->useNL2BR == 1)
		echo display_text($object->text);
	else echo $object->text;


} else {
   $query = query("SELECT * FROM static WHERE header LIKE 'index'");
   $o = fetch($query);
   echo display_text($o->text);

    if(config("usepage_news") && $usenews) {
		echo "<br><br><hr><br>";
		include 'inc/news.php';
	}
}
//echo "<br>".lang("This is a test", "index");

include $base_path."style/bottom.php";
?>
