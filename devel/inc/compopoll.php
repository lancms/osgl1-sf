<?php

require_once ('config/config.php');

if (!config("usepage_compopoll"))
{
	// FIXME: lang()
	nicedie("Vi kjører ikke noen compoavstemning nå......");
}

if(getcurrentuserid() == 1)
{
	// FIXME: lang() and ACLs.
	nicedie("Logg inn FØR du prøver å gjøre noe her...");
}

if(getuserrank() > 0)
{
	// FIXME: lang() and ACLs.
	nicedie("Sorry, men jeg tror vi dropper at crew fyller ut her.... Lak");
}

$action = $_GET['action'];

if (!isset($action))
{
	echo $msg['41'];
	echo "<table>";
	echo "<form method=POST action=index.php?inc=compopoll&action=editvote>";
	$q = query("SELECT * FROM compoPoll");
	while ($r = fetch($q))
	{
		$ruser = query("SELECT * FROM compoPollA WHERE pollID = '".escape_string($r->ID)."' AND userID = '".escape_string(getcurrentuserid())."'");
		$r2 = fetch($ruser);
		echo "<tr><td>";
		echo $r->question;
		echo "</td><td>";
		echo "<select name=\"$r->ID\">";
		$answer = $r2->answer;
		if($answer < 1)
		{
			$answer = 0;
		}
		for($i = 0; $i<6; $i++)
		{
			echo "<option value=$i";
			if($i == $answer)
			{
				echo " SELECTED";
			}
			echo ">".$compopoll[$i];
			echo "</option>";
		}
		echo "</td><td>";
		echo "</td></tr>";
	}
	echo "<tr><td></td><td><input type=submit value='Lagre'></td>";
	echo "</form>";
	echo "</table>";
}

elseif ($action == "editvote")
{
	$q = query("SELECT * FROM compoPoll");
	while($r = fetch($q))
	{
		$question = $r->ID;
		$answer = $_POST[$question];
		$test = query("SELECT * FROM compoPollA WHERE userID = '".escape_string(getcurrentuserid())."' AND pollID = '".escape_string($question)."'");
		if(num($test) == 0)
		{
			query("INSERT INTO compoPollA SET pollID = '".escape_string($question)."',
				userID = '".escape_string(getcurrentuserid())."',
				answer = '".escape_string($answer)."'");
		}
		else
		{
			query("UPDATE compoPollA SET answer = '".escape_string($answer)."' WHERE pollID = '".escape_string($question)."' AND userID = '".escape_string(getcurrentuserid())."'");
		}
	} // End while
refresh("index.php?inc=compopoll", 0);
} // End action == "editvote"

?>
