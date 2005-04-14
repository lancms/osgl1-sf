<?php

require_once ('config/config.php');

if (!config("usepage_compo"))
{
	// FIXME: lang().
	nicedie("Vi bruker IKKE compooppsettet, nei!");
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
			// FIXME: lang().
			echo "Du har ikke registrert plass, og kan derfor ikke melde deg på i compoene....";
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
				echo "<img src=images/ja.gif>";
			}
			else
			{
				echo "<img src=images/nei.gif>";
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
		// FIXME: lang().
		echo "<br><a href=?inc=compo&action=iDontWannaPlay&compo=$compo>nei, nei, nei; dette vil jeg ikke være med på mer!</a>";
	}
	elseif ((!$isPlayingCompo) && ($canCompete))
	{
		if ($r->gameType <= 1)
		{
		// FIXME: lang()
			echo "<br><a href=?inc=compo&action=signmeup&compo=$compo>Meld meg på!</a>";
		}
		else
		{
		// FIXME: lang()
			echo "<br><br><b>Meld meg på</b><table>";
			echo "<form method=POST action=index.php?inc=compo&compo=$compo&action=signmeup>";
			echo "<tr><td><input type=text name=klan></td><td> Klan</td>";
			echo "<tr><td><input type=password name=pass></td><td>klanpassord (fåes av klanleder)</td></tr>";
			echo "<tr><td></td><td><input type=submit value='I want to play!'></form></td></tr>";
			echo "</table>";
		}
	}
} //end action == compoinfo

elseif (($action == "signmeup") && (isset($compo)))
{
	if (!$canCompete)
	{
		// FIXME: lang()
		nicedie("Nope; Du får ikke lov til å konkurrere....");
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
			// FIXME: lang()
			nicedie("Det er ikke tillatt med flere spillere i klanen enn ".$r->players."!");
		}

		if(num($check) != 0)
		{
			query("INSERT INTO compoReg SET clanID = '".escape_string($clan->ID)."', compoID = '".escape_string($compo)."', userID = '".escape_string(getcurrentuserid())."'");
		}
		else
		{
			// FIXME: lang()
			nicedie("feil klannavn/passord");
		}
	}
	// FIXME: lang()
	echo "Du er påmeldt";
	refresh("?inc=compo&action=compoinfo&compo=$compo", 0);
}
elseif (($action == "iDontWannaPlay") && (isset($compo)))
{
	query("DELETE FROM compoReg WHERE compoID = '".escape_string($compo)."' AND userID = '".escape_string(getcurrentuserid())."'");
	// FIXME: lang()
	echo "Du er meldt av compoen";
	refresh("?inc=compo&action=compoinfo&compo=$compo", 0);
}
else
{
	nicedie();
}

?>
