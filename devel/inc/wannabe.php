<?php
require_once 'config/config.php';

if(!config("usepage_wannabe"))
	nicedie($msg[1]);

if(getcurrentuserid() == 1)
	nicedie("Hvorfor i HULESTE er du her? logg inn <b>FØRST</b>");

$action = $_GET['action'];

$q = query("SELECT * FROM users WHERE ID = ".getcurrentuserid());
$r = fetch($q);
$qT = query("SELECT * FROM config WHERE config = 'wannabetext'");
$rT = fetch($qT);
echo $rT->large;
if(!isset($action)) {
	echo "<table><tr><td>";

	echo "</td><td><form method=POST action=index.php?inc=wannabe&action=cyclewannabe>";
	if($r->wannabe == "1") $buttontext = $wannabe[1];
	else $buttontext = $wannabe[0];

	echo "<input type=submit value='$buttontext'>";
	echo "</form>";
	echo "</table>";
}

if(!isset($action) && $r->wannabe == 1) {
	$q2 = query("SELECT * FROM wannabe WHERE ID = ".getcurrentuserid());
	$r2 = fetch($q2);
	
	echo "<table>";
	echo "<form method=POST action=index.php?inc=wannabe&action=editwannabe>";
	
	$canKioskCrew = display_checkbox("canKioskCrew", $r2->canKioskCrew);
	profile_table($wannabe['canKioskCrew'], $canKioskCrew);
	
	$turnOn = display_checkbox("turnOn", $r2->turnOn);
	profile_table($wannabe['turnOn'], $turnOn);
	
	$canCake = display_checkbox("canCake", $r2->canCake);
	profile_table($wannabe['canCake'], $canCake);
	
	$leaderType = display_checkbox("leaderType", $r2->leaderType);
	profile_table($wannabe['leaderType'], $leaderType);

	$canTechCrew =  display_checkbox("canTechCrew", $r2->canTechCrew);
	profile_table($wannabe['canTechCrew'], $canTechCrew);
	
	$canTechLinuxCrew = display_checkbox("canTechLinuxCrew", $r2->canTechLinuxCrew);
	profile_table($wannabe['canTechLinuxCrew'], $canTechLinuxCrew);
	
	$karaoke = display_checkbox("karaoke", $r2->karaoke);
	profile_table($wannabe['karaoke'], $karaoke);
	
	$canNetCrew =  display_checkbox("canNetCrew", $r2->canNetCrew);
	profile_table($wannabe['canNetCrew'], $canNetCrew);
	
	$canSecCrew = display_checkbox("canSecCrew", $r2->canSecCrew);
	profile_table($wannabe['canSecCrew'], $canSecCrew);
	
	$canPartyCrew = display_checkbox("canPartyCrew", $r2->canPartyCrew);
	profile_table($wannabe['canPartyCrew'], $canPartyCrew);
	$canGameCrew = display_checkbox("canGameCrew", $r2->canGameCrew);
	profile_table($wannabe['canGameCrew'], $canGameCrew);
	
	$canCarryTablesCrew = display_checkbox("canCarryTablesCrew", $r2->canCarryTablesCrew);
	profile_table($wannabe['canCarryTablesCrew'], $canCarryTablesCrew);
	
	
	profile_table($wannabe['aboutme'], "<textarea name=aboutme cols=60 rows=15>".$r2->aboutme."</textarea>");
	
	profile_table($wannabe['experience'], "<textarea name=experience cols=60 rows=15>".$r2->experience."</textarea>");
	profile_table($wannabe['myRequests'], "<textarea name=myRequests cols=60 rows=15>".$r2->myRequests."</textarea>");
	
	profile_table($wannabe['why'], "<textarea name=why cols=60 rows=15>".$r2->why."</textarea>");
	
	echo "<tr><td></td><td><input type=submit value='Lagre'></td></tr>";
	echo "</form></table>";
}

elseif($action == "editwannabe") {
	$aboutme = $_POST['aboutme'];
	$canKioskCrew = $_POST['canKioskCrew'];
	$canTechCrew = $_POST['canTechCrew'];
	$canNetCrew = $_POST['canNetCrew'];
	$canSecCrew = $_POST['canSecCrew'];
	$canPartyCrew = $_POST['canPartyCrew'];
	$why = $_POST['why'];
	$experience = $_POST['experience'];
	$canTechLinuxCrew = $_POST['canTechLinuxCrew'];
	$canCarryTablesCrew = $_POST['canCarryTablesCrew'];
	$canGameCrew = $_POST['canGameCrew'];
	$turnOn = $_POST['turnOn'];
	$karaoke = $_POST['karaoke'];
	$canCake = $_POST['canCake'];
	$leaderType = $_POST['leaderType'];
	$myRequests = $_POST['myRequests'];
	
	$check = query("SELECT * FROM wannabe WHERE ID = ".getcurrentuserid());
	if(num($check) == 0) query("INSERT INTO wannabe SET ID = ".getcurrentuserid());
	
	query("UPDATE wannabe SET
		aboutme = '$aboutme',
		canKioskCrew = '$canKioskCrew',
		canTechCrew = '$canTechCrew',
		canNetCrew = '$canNetCrew',
		canSecCrew = '$canSecCrew',
		canPartyCrew = '$canPartyCrew',
		experience = '$experience',
		why = '$why',
		canTechLinuxCrew = '$canTechLinuxCrew',
		canCarryTablesCrew = '$canCarryTablesCrew',
		canGameCrew = '$canGameCrew',
		turnOn = '$turnOn',
		karaoke = '$karaoke',
		canCake = '$canCake',
		leaderType = '$leaderType',
		myRequests = '$myRequests',
		
		lastUpdated = ".time()." WHERE ID = ".getcurrentuserid());
	refresh("index.php?inc=wannabe", 0);

}

elseif($action == "cyclewannabe") {
	$now = $r->wannabe;
	if($now == 0) $tobe = 1;
	else $tobe = 0;
	
	query("UPDATE users SET wannabe = $tobe WHERE ID = ".getcurrentuserid());
	refresh("index.php?inc=wannabe");
}

function display_checkbox($name, $selected) {
	if($selected) $SELECT = "CHECKED";
	return "<input type=checkbox name='$name' value=1 $SELECT>";
}
