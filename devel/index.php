<?php

require './config/config.php';

include $base_path."style/top.php";
if(isset($_GET['inc'])) {
    if(strchr($_GET['inc'], ".")) die("hacking?");

    include "inc/".$_GET['inc'].".php";
} elseif(isset($_GET['page'])) {
	$query = mysql_query("SELECT * FROM static WHERE header LIKE '".$_GET['page']."'") or die(mysql_error());
	$object = mysql_fetch_object($query);

	echo display_text($object->text);


} else {
   $query = mysql_query("SELECT * FROM static WHERE header LIKE 'index'") or die(mysql_error());
   $o = mysql_fetch_object($query);
   echo display_text($o->text);

    if(config("usepage_news") && $usenews) {
		echo "<br><br><hr><br>";
		include 'inc/news.php';
	}
}


include $base_path."style/bottom.php";
?>
