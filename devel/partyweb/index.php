<?php
require_once '../config/config.php';
$mode = $_GET['mode'];
$viewpage = $_GET['viewpage'];

$to_random = NULL;
function text2html($text) {
$text = stripslashes($text);
$text = nl2br($text);
return $text;

}

if(empty($viewpage) && empty($mode)) {
$q = query("SELECT ID FROM partyweb WHERE display_menu = 1 ORDER BY ID DESC LIMIT 0,1");
if(num($q) == 0) header("Location: ?mode=nopage");
else {
	$r = fetch($q);
	header("Location: ?viewpage=$r->ID");
	}
die();
}

include_once $base_path.'partyweb/style/top.php';

if(empty($mode)) {
include_once $base_path.'partyweb/style/menu.php';
}

if($viewpage) {
$q = mysql_query("SELECT * FROM partyweb WHERE ID = $viewpage");
$r = mysql_fetch_object($q);

echo '<td height="100%" align="center" valign="top" class="tbl_main">';

echo text2html($r->text);

}



elseif($mode == "party") {

$q = mysql_query("SELECT ID FROM partyweb WHERE display_partymode = 1");

while($r = mysql_fetch_object($q)) {

$to_random[] = $r->ID;

}

$rand = rand(0, count($to_random)-1);

$display = $to_random[$rand];
//echo "<br><br>";


$query = mysql_query("SELECT * FROM partyweb WHERE ID = $display") or die(mysql_error());

$page = mysql_fetch_object($query);
echo '<td height="100%" align="center" valign="top" class="tbl_main">';
echo text2html($page->text);
}

elseif($mode == "nopage") {
echo '<td height="100%" align="center" valign="top" class="tbl_main">';
echo "Sorry, admin has not put in any pages here yet";
}


include_once $base_path.'partyweb/style/bottom.php';
