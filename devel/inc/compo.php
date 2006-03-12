<?php

require_once ('config/config.php');

if (!config("usepage_compo"))
{
	nicedielang("We do not use the composystem, no!", "inc_compo");
}

$action = $_GET['action'];
$compo = $_GET['compo'];
$hasSeat = query("SELECT * FROM users WHERE seatX != -1 AND seatY != -1 AND ID = '".escape_string(getcurrentuserid())."'");

if (getcurrentuserid() == 1)
{
	$canCompete = FALSE;
}
elseif (num($hasSeat) == 0)
{
	$canCompete = FALSE;
}
else
{
	$canCompete = TRUE;
}


if (!isset($action))
{
	if (!$canCompete)
	{
		if (getcurrentuserid() == 1);
		else
		{
			echo lang("You have not registered for a seat, and may therefor not sign up for any compos...", "inc_compo");
		}
	}
	$q = query("SELECT * FROM compo");
	
	echo "<table>";
	
	while ($r = fetch($q))
	{
		echo "<tr><td>";
		echo "<a href=?inc=compo&action=compoinfo&compo=$r->ID>";
		echo $r->name;
		echo "</a></td><td>";
		echo $compotype[$r->gameType];
		echo "</td><td>";
		echo "<a href=?inc=compo&action=viewrules&compo=$r->ID>Vis regler</a>";
		echo "</td></tr>";
	}
	echo "</table>";
}

elseif (($action == "viewrules") && (isset($compo)))
{
	echo "<a href=?inc=compo>Tilbake til hovedsiden</a><br>";
	$q = query("SELECT * FROM compo WHERE ID = '".escape_string($compo)."'");
	$r = fetch($q);
	echo nl2br($r->rules);
}

elseif (($action == "compoinfo") && (isset($compo)))
{
	echo "<a href=?inc=compo>Tilbake til hovedsiden</a><br>";
	$q = query("SELECT * FROM compo WHERE ID = '".escape_string($compo)."'");
	$r = fetch($q);
	$maxPlayers = $r->players;
	if ($r->isOpen == 0)
	{
		$canCompete = FALSE;
	}
	echo $r->name." er en ".$compotype[$r->gameType]." med ".$r->players." i hver runde.";
	echo "<br>";
	echo "<table>";

	if ($r->gameType <= 1)
	{
		echo "<tr><th>Spiller</th></tr>";
		$q2 = query("SELECT userID FROM compoReg WHERE compoID = '".escape_string($compo)."'");
		while ($r2 = fetch($q2))
		{
			echo "<tr><td>";
			display_nick($r2->userID);
			echo "</td></tr>";
		}
		 
	}
	else
	{
		echo "<tr><th>Klannavn</th><th>Spillere</th><th>Registrering OK (antall plasser fylt opp)</th></tr>";
		$q2 = query("SELECT DISTINCT clanID FROM compoReg WHERE compoID = '".escape_string($compo)."' ORDER BY clanID DESC");
		while ($r2 = fetch($q2))
		{
			$clanQ = query("SELECT * FROM Clan WHERE ID = '".escape_string($r2->clanID)."'");
			$clanR = fetch($clanQ);
			echo "<tr><td>".$clanR->name."</td><td>";
			$clanPlayersQ = query("SELECT * FROM compoReg WHERE clanID = '".escape_string($r2->clanID)."' AND compoID = '".escape_string($compo)."'");
			while ($clanPlay = fetch($clanPlayersQ))
			{
				display_nick($clanPlay->userID);
				echo " ";
			} // End while for display_nick
			echo "</td><td>";
			if (num($clanPlayersQ) == $maxPlayers)
			{
				echo "<img src=images/yes.gif>";
			}
			else
			{
				echo "<img src=images/no.gif>";
			}
			echo "</td></tr>";
		} // End while for displaying clans
		
	} // end if(gameType != 0)// else
	echo "</table>";
	$test = query("SELECT * FROM compoReg WHERE compoID = '".escape_string($compo)."' AND userID = '".escape_string(getcurrentuserid())."'");
	if(num($test) != 0)
	{
		$isPlayingCompo = TRUE;
	}
	else
	{
		$isPlayingCompo = FALSE;
	}
	
	if (($isPlayingCompo) && ($canCompete))
	{
		echo "<br><a href=?inc=compo&action=iDontWannaPlay&compo=$compo>".lang("No, no, no; I don't want to be a part of this any more!", "inc_compo")."</a>";
	}
	elseif ((!$isPlayingCompo) && ($canCompete))
	{
		if ($r->gameType <= 1)
		{
			echo "<br><a href=?inc=compo&action=signmeup&compo=$compo>".lang("Sign me up!", "inc_compo")."</a>";
		}
		else
		{
			echo "<br><br><b>".lang("Sign me up", "inc_compo")."</b><table>";
			echo "<form method=POST action=index.php?inc=compo&compo=$compo&action=signmeup>";
			echo "<tr><td><input type=text name=klan></td><td> ".lang("Clan", "inc_compo")."</td>";
			echo "<tr><td><input type=password name=pass></td><td>".lang("Clanpassword (ask your clanleader)", "inc_compo")."</td></tr>";
			echo "<tr><td></td><td><input type=submit value='".lang("I want to play!", "inc_compo")."'></form></td></tr>";
			echo "</table>";
		}
	}
} //end action == compoinfo

elseif (($action == "signmeup") && (isset($compo)))
{
	if (!$canCompete)
	{
		nicedielang("No; Youre not allowed to join this compo");
	}

	$q = query("SELECT * FROM compo WHERE ID = '".escape_string($compo)."'");
	$r = fetch($q);
	query("DELETE FROM compoReg WHERE compoID = '".escape_string($compo)."' AND userID = '".escape_string(getcurrentuserid())."'"); // Just in case he's tries to do something he shouldn't...
	if($r->gameType <= 1)
	{
		query("INSERT INTO compoReg SET compoID = '".escape_string($compo)."', userID = '".escape_string(getcurrentuserid())."'");
	}
	else
	{
		$clanname = $_POST['klan'];
		$pass = $_POST['pass'];
		$check = query("SELECT * FROM Clan WHERE name = '".escape_string($clanname)."' AND password = '".escape_string($pass)."'");
		$clan = fetch($check);
		$numCheck = query("SELECT * FROM compoReg WHERE compoID = '".escape_string($compo)."' AND clanID = '".escape_string($clan->ID)."'");
		if(num($numCheck) >= $r->players)
		{
			nicedie(lang("It is not allowed with more players in the clan than ", "inc_compo").$r->players."!");
		}

		if(num($check) != 0)
		{
			query("INSERT INTO compoReg SET clanID = '".escape_string($clan->ID)."', compoID = '".escape_string($compo)."', userID = '".escape_string(getcurrentuserid())."'");
		}
		else
		{
			nicedielang("wrong clanname/password", "inc_compo");
		}
	}
	echo lang("You have been signed up", "inc_compo");
	refresh("?inc=compo&action=compoinfo&compo=$compo", 0);
}
elseif (($action == "iDontWannaPlay") && (isset($compo)))
{
	query("DELETE FROM compoReg WHERE compoID = '".escape_string($compo)."' AND userID = '".escape_string(getcurrentuserid())."'");
	echo lang("You have been signed off this compo", "inc_compo");
	refresh("?inc=compo&action=compoinfo&compo=$compo", 0);
}
else
{
	nicedie("inc/compo has no fucking idea what action you are talking about");
}

?>
