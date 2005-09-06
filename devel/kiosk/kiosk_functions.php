<?php

function my_basket_total() {
	$crewsale = crewsale();
	if($crewsale) $userow = "cPrice";
	else $userow = "price";
	$sID = session_id();
	$q = query("SELECT * FROM temp_basket WHERE sID = '$sID'");
	while($r = fetch($q)) {
		$winfo = wareinfo($r->wareID);
		
		$rabatt = ware_rabatt($r->wareID);
		
		if($rabatt && !$crewsalg) 
			$totalprice = $totalprice + ($rabatt * $r->amount);
		else $totalprice = $totalprice + ($winfo->$userow * $r->amount);
}
	return $totalprice;
}

function my_box() {
	$sID = session_id();
	$q = query("SELECT * FROM session WHERE sID = '$sID'");
	$r = fetch($q);
	return $r->kiosk_box;
}

function crewsale() {
	$sID = session_id();
	$q = query("SELECT * FROM session WHERE sID = '$sID'");
	$r = fetch($q);
	return $r->crewSale;
}

function toggle_crewsale() {
	$sID = session_id();
	$current = crewsale();
	if($current == 1) $new = 0;
	else $new = 1;
	query("UPDATE session SET crewSale = $new WHERE sID = '$sID'");
}

function ware_rabatt($wareID) {
	
	$now = time();
	$q = query("SELECT * FROM kiosk_rabatter WHERE wareID = '$wareID' AND startTime <= $now AND stopTime >= $now AND active = 1");
	$r = fetch($q);
	
	if(num($q) == 0) return FALSE;
	else return $r->newPrice;
	
}

function wareinfo ($barcode) {
$q = query("SELECT * FROM kiosk_warez WHERE barcode = '$barcode'");
$r = fetch($q);
return $r;
}