<?php
require_once 'config/config.php';

$action = $_GET['action']; 

$get_i = $_GET['i'];
$get_l = $_GET['l'];

if(!isset($action)) {
	include $base_path."style/top.php";
	require "imagemap.php";
	echo "<table width=100% border=0><tr><td><center><img src='seatimage.php' border=0 usemap='#seatmap'></center></td></tr></table>";
	
	
	
}

if(isset($get_i) && isset($get_l) && !isset($action)) {
	
	
	$q = query("SELECT * FROM config WHERE config = 'seatmap'");
	$r = fetch($q);
	$map = convert_seatmap($r->large);
	

	
	$seat = $map[$get_i][$get_l];
	$snum = $seatsign_number[$seat];
	
#echo $seatsign_number['d'];
	
	if($seatsign[$snum]['level'] == -2);
	else {
		echo "<br>";
		$q = query("SELECT * FROM users WHERE seatI = '$get_i' AND seatL = '$get_l'");
		if(getcurrentuserid() == 1) echo "anonym...";
		elseif(!config(seatreg_open) && getuserrank() < 1) echo "Ikke åpent";
		
		elseif(num($q) == 0 && $seatsign[$snum]['level'] <= getuserrank()) {
			echo "<a href=seat.php?action=join&i=$get_i&l=$get_l>Kapre denne plassen</a>";
		} elseif($seatsign[$snum]['level'] > getuserrank() && num($q) == 0) echo "Ikkje tilgang!";
		else {
			$r = fetch($q);
			echo "Her sitter: ";
			display_nick($r->ID);
		}
		
	}
	
	
}

if(!isset($action)) include $base_path."style/bottom.php";

elseif($action == "join" && isset($get_i) && isset($get_l)) {
	if(!config(seatreg_open) && getuserrank() < 1) die("Vi har <b>IKKE</b> åpnet ennå! hacking forbudt btw :P");
	$check = query("SELECT * FROM users WHERE seatI = $get_i AND seatL = $get_l");
	if(num($check) == 0)
		query("UPDATE users SET seatI = '$get_i', seatL = '$get_l' WHERE ID = ".getcurrentuserid());
	else die("Plassen er opptatt!");
	//echo "I = $get_i and L = $get_l";
	header("Location: seat.php?party=$party&i=$get_i&l=$get_l");
}
else "WTF?";
