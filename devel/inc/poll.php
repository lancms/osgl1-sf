<?php

require_once 'config/config.php';
if(!config("usepage_poll")) die($msg[1]);

db_connect();
if(!isset($_GET['action'])) {
    $action = "display";
} else {
    $action = $_GET['action'];
}



if($action=="display" && !isset($_GET[poll])) {
    $query = mysql_query("SELECT * FROM pollQ ORDER BY ID ASC") or die(mysql_error());
    if(mysql_num_rows($query) == 0) echo $form[20];

    for($i=0;$i<mysql_num_rows($query);$i++) {
        $polls = mysql_fetch_object($query);

        echo "<a href=index.php?inc=poll&poll=$polls->ID>$polls->text</a><br>\n";
    }
} elseif($action=="display" && isset($_GET[poll])) {

    $poll = $_GET[poll];

    $queryQ = mysql_query("SELECT * FROM pollQ WHERE ID = $poll") or die(mysql_error());
    $row = mysql_fetch_object($queryQ);
    $maxVotes = $row->maxVotes;
    if($row->isOpen == 0) echo "<font size=18>$msg[8]</font><br>";
	$totalVotes = mysql_query("SELECT * FROM pollVoted WHERE pollID = $poll");
	$totalVotes = mysql_num_rows($totalVotes);
    echo $row->text;

    $queryV = mysql_query("SELECT votes FROM pollA WHERE QID = $poll")
        or die(mysql_error());

    if(mysql_num_rows($queryV) < 1)
    {
        echo "Det er ingen ting å stemme på her.";
        return;
    }
	echo "<br>".$form[46].$totalVotes."<br><br>\n";
    $mxvotes = 0;

    for($i=0;$i<mysql_num_rows($queryV);$i++)
    {
        $row = mysql_fetch_object($queryV);
        $mxvotes += $row->votes;
    }

    if($mxvotes > 0)
        $mxcountvotes = 100 / $mxvotes;


        $uid = getcurrentuserid();

    $queryU = mysql_query("SELECT * FROM pollVoted WHERE userID = $uid AND pollID = $poll")
        or die(mysql_error());

    $denyvote = FALSE;

    if((mysql_num_rows($queryU) >= $maxVotes) or (getcurrentuserid() == 1))
        $denyvote = TRUE;


    $queryV = mysql_query("SELECT * FROM pollA WHERE QID = $poll")
        or die(mysql_error());



    for($i=0;$i<mysql_num_rows($queryV);$i++)
    {
        $row = mysql_fetch_object($queryV);

        $w = $row->votes * $mxcountvotes;
        $w = round($w, 2);

        if($denyvote)
            $atxt = $row->Atext;
        else
            $atxt = "<a href=index.php?inc=poll&action=castvote&AID=".$row->AID.">".$row->Atext."</a>";

        echo ($i + 1).". $atxt<br><table border=0 cellspacing=0 cellpadding=0><tr><td><table bgcolor=red height=8 border=0 cellspacing=0 cellpadding=0 width=$w><tr><td></td></tr></table></td><td><font size=-2>&nbsp;&nbsp; $w %</font></td></tr></table>\n";
    }
	echo "<br>".$form[44].$maxVotes;
}
elseif($action == "castvote" && isset($_GET['AID']))
{
 $uid = getcurrentuserid();
 $AID = $_GET['AID'];

 $q = mysql_query("SELECT * FROM pollA WHERE AID = '$AID'");
 $qo = mysql_fetch_object($q);
 $qid = $qo->QID;

 $maxQ = mysql_query("SELECT * FROM pollQ WHERE ID = '$qid'");
 $maxR = mysql_fetch_object($maxQ);
 $maxVote = $maxR->maxVotes;

 $userQ = mysql_query("SELECT * FROM pollVoted WHERE userID = '$uid' AND pollID = '$qid'");
 $userNUM = mysql_num_rows($userQ);

 if($userNUM >= $maxVote) die($form[37]);

 mysql_query("UPDATE pollA SET votes = votes +1 WHERE AID = '$AID'") or die(mysql_error());
 mysql_query("INSERT INTO pollVoted SET userID = '$uid', pollID = '$qid'") or die(mysql_error());
 refresh("index.php?inc=poll&poll=$qid", "0");
 echo $form[49];

}


?>