<?php
require_once 'config/config.php';
if(!config("usepage_compopoll"))
	nicedie("Vi kjører ikke noen compoavstemning nå......");

if(getcurrentuserid() == 1)
	nicedie("Logg inn FØR du prøver å gjøre noe her...");

if(getuserrank() > 0)
	nicedie("Sorry, men jeg tror vi dropper at crew fyller ut her.... Lak");

$action = $_GET['action'];
if(!isset($action)) {

echo "Jauda, er bare å fylle inn det du mener om de forskjellige compoenforslagene....";
echo "<table>";
echo "<form method=POST action=index.php?inc=compopoll&action=editvote>";
$q = query("SELECT * FROM compoPoll");

while($r = fetch($q)) {
$ruser = query("SELECT * FROM compoPollA WHERE pollID = $r->ID AND userID = ".getcurrentuserid());
$r2 = fetch($ruser);
echo "<tr><td>";
echo $r->question;
echo "</td><td>";
echo "<select name=\"$r->ID\">";
$answer = $r2->answer;
if($answer < 1) $answer = 0;
for($i = 0; $i<6; $i++) {
	echo "<option value=$i";
	if($i == $answer) echo " SELECTED";
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

elseif($action == "editvote") {
$q = query("SELECT * FROM compoPoll");
while($r = fetch($q)) {
$question = $r->ID;
$answer = $_POST[$question];
$test = query("SELECT * FROM compoPollA WHERE userID = ".getcurrentuserid()." AND pollID = $question");
if(num($test) == 0) query("INSERT INTO compoPollA SET pollID = '$question',
	userID = '".getcurrentuserid()."',
	answer = '$answer'");
else query("UPDATE compoPollA SET answer = '$answer' WHERE pollID = '$question' AND userID = ".getcurrentuserid());
#echo $r->question." har blitt satt til: ".$answer;
} // End while
refresh("index.php?inc=compopoll", 0);

} // End action == "editvote"
