<?php

require_once 'config/config.php';

$qQ = mysql_query("SELECT * FROM pollQ ORDER BY ID DESC LIMIT 0,1");

$rQ = mysql_fetch_object($qQ);

echo "<b>$rQ->text</b>";

$num = mysql_query("SELECT * FROM pollVoted WHERE userID = ".getcurrentuserid()." AND pollID = $rQ->ID");
if(mysql_num_rows($num) >= $rQ->maxVotes) $votable = FALSE;
elseif(getcurrentuserid() == 1) $votable = FALSE;
else $votable = TRUE;


$qA = mysql_query("SELECT * FROM pollA WHERE QID = $rQ->ID");
while($rA = mysql_fetch_object($qA)) {
	echo "<br><br>";
	if($votable) echo "<a href=index.php?inc=poll&action=castvote&AID=$rA->AID>";
	echo $rA->Atext;
	if($votable) echo "</a>";
	if($rA->votes == NULL) $rA->votes = 0;
	echo " ($rA->votes)";

}
