<?php

require_once ('./config/config.php');


if (isset($_GET['inc']))
{

	require_once ($base_path."style/top.php");
	if (strchr($_GET['inc'], "."))
	{
		// XXX: Generic string. Should be lang()ified.
		nicedie($msg['29']);
		dblog(10, "User attempted to put . in GET[inc].");
	}
	require_once ("inc/".$_GET['inc'].".php");
}
elseif (isset($_GET['page']))
{
	require_once ($base_path."style/top.php");
	$page = $_GET['page'];
	$query = query("SELECT * FROM static WHERE header LIKE '".escape_string($page)."'");
	$object = fetch($query);
	if($object->useNL2BR == 1)
	{
		echo display_text($object->text);
	}
	else
	{
		echo $object->text;
	}
}
elseif( isset($_GET['kiosk'])) {
	if(strchr($_GET['kiosk'], ".")) nicedie($msg['29']);
	require_once ("kiosk/".$_GET['kiosk'].".php");
}
else
{
	require_once ($base_path."style/top.php");
	$query = query("SELECT * FROM static WHERE header LIKE 'index'");
	$o = fetch($query);
	echo display_text($o->text);

	if ((config("usepage_news")) && ($usenews))
	{
		echo "<br><br><hr><br>";
		require_once ('inc/news.php');
	}
}

require_once ($base_path."style/bottom.php");
?>
