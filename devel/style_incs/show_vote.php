<?php

require_once 'config/config.php';

$qQ = query("SELECT * FROM pollQ ORDER BY ID DESC LIMIT 0,1");

$rQ = fetch($qQ);

if (!isset($rQ->ID))
{
	echo "No available polls at the time.";
}
elseif (isset($rQ->ID))
{
	echo "<b>$rQ->text</b>";

	$num = query("SELECT * FROM pollVoted WHERE userID = '".escape_string(getcurrentuserid())."' AND pollID = '".escape_string($rQ->ID)."'");
	if(num($num) >= $rQ->maxVotes)
	{
		$votable = FALSE;
	}
	elseif(getcurrentuserid() == 1)
	{
		$votable = FALSE;
	}
	else
	{
	$votable = TRUE;
	}

	$qA = query("SELECT * FROM pollA WHERE QID = '".escape_string($rQ->ID)."'");
	while($rA = fetch($qA)) {
		echo "<br><br>";
		if($votable)
		{
			echo "<a href=index.php?inc=poll&action=castvote&AID=$rA->AID>";
		}
		echo $rA->Atext;
		if($votable)
		{
			echo "</a>";
		}
		if($rA->votes == NULL)
		{
			$rA->votes = 0;
		}
		echo " ($rA->votes)";
	}
}

?>
