<?php

require_once ('config/config.php');

if (!config("usepage_news"))
{
	nicedie($msg[9]);
}

$action = $_GET['action'];
$many = $_GET['many'];

if (!isset($action))
{
	$action = "view";
}

if (!isset($many))
{
	$many = $usenews;
}
elseif ($many == "ALL")
{
	$select = query("SELECT ID FROM news");
	$many = num($select);
}

if($action == "view")
{	
	$query = query("SELECT * FROM news ORDER BY ID DESC LIMIT 0,".$many);

	$num = num($query);

	if ($num == 0)
	{
		echo $msg[13];
	}

	for ($i=0;$i<$num;$i++)
	{
		$row = fetch($query);

		echo "<font class=newsHeader>".stripslashes($row->header).".</font>";
		echo "<br>";
		$queryNick = query("SELECT * FROM users WHERE ID = '".escape_string($row->poster)."'");

		$nickrow = fetch($queryNick);

		if (num($queryNick) == 0)
		{
			$nick_poster = $msg[17];
		}
		else
		{
			$nick_poster = $nickrow->nick;
			$nick_poster = "<a href=index.php?inc=profile&uid=$nickrow->ID>$nick_poster</a>";
		}

		echo "<font class=newsPoster>".$msg[14].$nick_poster."</font>";
		echo "<br>";
		echo "<font class=newsText>".stripslashes(nl2br($row->text))."</font>";
		if ($i < $num-1)
		{
			echo "<br><hr><br>";
		}
	}
}
?>
