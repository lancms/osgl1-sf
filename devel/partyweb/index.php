<?php

require_once ('../config/config.php');

$mode = $_GET['mode'];
$viewpage = $_GET['viewpage'];

$to_random = NULL;

function text2html($text)
// TODO: Move this to functions.php!
{
	$text = stripslashes($text);
	$text = nl2br($text);
	return $text;
}

if (empty($viewpage) && empty($mode))
{
	$q = query("SELECT ID FROM partyweb WHERE display_menu = 1 ORDER BY ID DESC LIMIT 0,1");
	if (num($q) == 0) header("Location: ?mode=nopage");
	else
	{
		$r = fetch($q);
		header("Location: ?viewpage=$r->ID");
	}
die();
}

require_once ($base_path.'partyweb/style/top.php');

if (empty($mode)) {
	require_once ($base_path.'partyweb/style/menu.php');
}

if ($viewpage)
{
	$q = query("SELECT * FROM partyweb WHERE ID = '".escape_string($viewpage)."'");
	$r = fetch($q);

	echo '<td height="100%" align="center" valign="top" class="tbl_main">';

	echo text2html($r->text);
}
elseif ($mode == "party")
{
	$q = query("SELECT ID FROM partyweb WHERE display_partymode = 1");

	while($r = fetch($q))
	{
	$to_random[] = $r->ID;
	}

	$rand = rand(0, count($to_random)-1);

	$display = $to_random[$rand];

	$query = query("SELECT * FROM partyweb WHERE ID = '".escape_string($display)."'");

	$page = fetch($query);
	echo '<td height="100%" align="center" valign="top" class="tbl_main">';
	echo text2html($page->text);
}
elseif($mode == "nopage")
{
	echo '<td height="100%" align="center" valign="top" class="tbl_main">';
	echo "Sorry, admin has not put in any pages here yet";
}

require_once ($base_path.'partyweb/style/bottom.php');

?>
