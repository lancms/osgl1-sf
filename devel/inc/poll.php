<?php

require_once 'config/config.php';

if (!config("usepage_poll"))
{
	nicedie($msg[1]);
}

if (!isset($_GET['action']))
{
	$action = "display";
}
else
{
	$action = $_GET['action'];
}

if (($action=="display") && (!isset($_GET[poll])))
{
	$query = query("SELECT * FROM pollQ ORDER BY ID ASC");
	if(num($query) == 0)
	{
		echo $form[20];
	}
	
	for($i=0;$i<num($query);$i++)
	{
		$polls = fetch($query);
		echo "<a href=index.php?inc=poll&poll=$polls->ID>$polls->text</a><br>\n";
	}
}
elseif (($action=="display") && (isset($_GET['poll'])))
{
	$poll = $_GET[poll];

	$queryQ = query("SELECT * FROM pollQ WHERE ID = '".mysql_escape_string($poll)."'");
	$row = fetch($queryQ);		// get the poll data (name etc.)
	$maxVotes = $row->maxVotes;			// maxVotes denotes how many votes is allowed per user.
	if($row->isOpen == 0)
	{
		echo "<font size=18>$msg[8]</font><br>";	// find out whether this poll is open or not
	}
	
	$totalVotes = query("SELECT * FROM pollVoted WHERE pollID = '".mysql_escape_string($poll)."'");
	$totalVotes = num($totalVotes);
	echo $row->text;

	$queryV = query("SELECT votes FROM pollA WHERE QID = '".mysql_escape_string($poll)."'");	// get how many votes has been made on this poll

	if(num($queryV) < 1)	// if mysql_num_rows($queryV) is less than one (probably equals 0)
	{
		echo "Det er ingen ting å stemme på her.";	// you can't vote on a poll that does not exist.
		return;
	}
	echo "<br>".$form[46].$totalVotes."<br><br>\n";	// display total votes
	$mxvotes = 0;	// set a temporary variable for calculating percent.

	for($i=0;$i<num($queryV);$i++)
	{
		$row = fetch($queryV);
		$mxvotes += $row->votes;	// mxvotes is the true votecount.
	}

	if($mxvotes > 0)
	{
		$mxcountvotes = 100 / $mxvotes;	// make into percentage.
	}

	$uid = getcurrentuserid();	// check userid.

	$queryU = query("SELECT * FROM pollVoted WHERE userID = '".mysql_escape_string($uid)."' AND pollID = '".mysql_escape_string($poll)."'");	// create a query that finds out whether this user has voted before or not on this poll.

	$denyvote = FALSE;	// set default value to FALSE

	if((num($queryU) >= $maxVotes) or (getcurrentuserid() == 1))	// if this user has exceeded the maxvote count,
	{
		$denyvote = TRUE;	// deny.
	}


	$queryV = query("SELECT * FROM pollA WHERE QID = '".mysql_escape_string($poll)."'");	// retrieve all the alternatives.

	echo "<table border=0><tr><td>\n";
	for($i=0;$i<num($queryV);$i++)
	{
		$row = fetch($queryV);

		$w = $row->votes * $mxcountvotes; // get percentage of votes.
		$w = round($w, 2);	// round it down with 2 decimals

		if($denyvote)
			$atxt = $row->Atext;	// if vote is denied, don't display the link.
		else
			$atxt = "<a href=index.php?inc=poll&action=castvote&AID=".$row->AID.">".$row->Atext."</a>";

		echo ($i + 1).". $atxt<br><table border=0 cellspacing=0 cellpadding=0><tr><td><table bgcolor=red height=8 border=0 cellspacing=0 cellpadding=0 width=$w><tr><td></td></tr></table></td><td><font size=-2>&nbsp;&nbsp; $w %</font></td></tr></table>\n";
	}
	echo "</td></tr></table>\n";
	
	echo "<br>".$form[44].$maxVotes;
}
elseif (($action == "castvote") && (isset($_GET['AID'])))
{
	$uid = getcurrentuserid();
	$AID = $_GET['AID'];

	$q = query("SELECT * FROM pollA WHERE AID = '".mysql_escape_string($AID)."'");
	$qo = fetch($q);
	$qid = $qo->QID;
	
	$maxQ = query("SELECT * FROM pollQ WHERE ID = '".mysql_escape_string($qid)."'");
	$maxR = fetch($maxQ);
	$maxVote = $maxR->maxVotes;

	$userQ = query("SELECT * FROM pollVoted WHERE userID = '".mysql_escape_string($uid)."' AND pollID = '".mysql_escape_string($qid)."'");
	$userNUM = num($userQ);

	if($userNUM >= $maxVote)
	{
	 	nicedie($form[37]);
	}
	
	query("UPDATE pollA SET votes = votes +1 WHERE AID = '".mysql_escape_string($AID)."'");
	query("INSERT INTO pollVoted SET userID = '".mysql_escape_string($uid)."', pollID = '".mysql_escape_string($qid)."'");
	refresh("index.php?inc=poll&poll=$qid", "0");
	echo $form[49];
}
?>
