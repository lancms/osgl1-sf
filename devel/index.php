<?php

require_once ('./config/config.php');

require_once ($base_path."style/top.php");

if (isset($_GET['inc']))
{
	if (strchr($_GET['inc'], "."))
	{
		nicedie($msg['29']);
		dblog(10, "User attempted to put . in GET[inc].");
	}
	require_once ("inc/".$_GET['inc'].".php");
}
elseif (isset($_GET['page']))
{
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
else
{
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
