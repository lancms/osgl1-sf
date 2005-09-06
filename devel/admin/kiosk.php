<?php
require_once 'config/config.php';
if(!acl_access("kioskAdmin")) nicedie($admin[noaccess]);;

$action = $_GET['action'];
$text = $_GET['text'];
if(!isset($action)) {

?>
<br><br><?php if(isset($text)) echo $text; ?>
<li><a href=admin.php?adminmode=kiosk&action=addware>Legg til varer</a>
<br><li><a href=admin.php?adminmode=kiosk&action=wareadmin>Endre varer</a>
<br><li><a href=kasser.php>Kassadministrasjon</a>
<br><li><a href=admin.php?adminmode=kiosk&action=rabatter>Rabattadministrasjon</a>
<?php

}

elseif($action == "addware") {

?>
<form method=POST action=admin.php?adminmode=kiosk&action=doaddware>
<input name=name type=text> Navn
<br><input type=text name=price> Pris
<br><input type=text name=cPrice> Crewpris
<br><input type=text name=inPrice> Innkjøpspris
<br><input type=text name=barcode> Strekkode/ID
<br><input type=submit value='Legg til varen'>
</form>
<?php


}
elseif($action == "doaddware") {
$name = $_POST['name'];
$price = $_POST['price'];
$barcode = $_POST['barcode'];
$cPrice = $_POST['cPrice'];
$inPrice = $_POST['inPrice'];
if(empty($barcode)) die("Du m&aring; ha en strekkode");
$q = query("SELECT * FROM kiosk_warez WHERE barcode = '$barcode'");
if(num($q)) die("Varen ligger allerede inne :/");

query("INSERT INTO kiosk_warez SET barcode = '$barcode',
	price = '$price',
	name = '$name',
	cPrice = '$cPrice',
	inPrice = '$inPrice'
	");

refresh("admin.php?adminmode=kiosk&text=Varen er lagt til", 0);
}

elseif($action == "wareadmin") {
	
	$q = query("SELECT * FROM kiosk_warez");
	
	echo "<table>";
	?><tr><th>Navn</th><th>Brukerpris</th><th>Crewpris</th></tr><?php
	while($r = fetch($q)) {
		echo "<tr><td>";
		echo "<a href=admin.php?adminmode=kiosk&action=editware&ware=$r->barcode>";
		echo $r->name;
		echo "</a></td><td>";
		echo $r->price;
		echo "</td><td>";
		echo $r->cPrice;
		echo "</td></tr>";
	}
	echo "</table>";
	
}
elseif($action == "editware" && isset($_GET['ware'])) {
	
	$ware = $_GET['ware'];
	$winfo = wareinfo($ware);
	
	echo "<form method=POST action=admin.php?adminmode=kiosk&action=doeditware&ware=$ware>";
	echo "<input type=text name=name value='$winfo->name'> Navn";
	echo "<br><input type=text name=price value='$winfo->price'> Pris";
	echo "<br><input type=text name=cPrice value='$winfo->cPrice'> Crewpris";
	echo "<br><input type=text name=inPrice value='$winfo->inPrice'> Innkjøpspris";
	if($winfo->active == 1) $selected = "CHECKED";
	echo "<br><input type=checkbox name=active value=1 $selected> Aktiv?";
	echo "<br><input type=submit value='Lagre'></form>";
	
	
}
elseif($action == "doeditware" && isset($_GET['ware'])) {
	$ware = $_GET['ware'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$cPrice = $_POST['cPrice'];
	$inPrice = $_POST['inPrice'];
	$active = $_POST['active'];
	if(!isset($active)) $active = 0;
	
	query("UPDATE kiosk_warez SET
		name = '$name',
		price = '$price',
		cPrice = '$cPrice',
		inPrice = '$inPrice',
		active = '$active'
		WHERE barcode = '$ware'");
	refresh("Location: admin.php?adminmode=kiosk&text=varen er oppdatert", 0);
}
elseif($action == "rabatter") {
	
	$q = query("SELECT * FROM kiosk_rabatter");
	echo "<table>";
	while($r = fetch($q)) {
		echo "<tr><td>";
		echo $r->name;
		echo "</td><td>";
		$winfo = wareinfo($r->wareID);
		echo $winfo->name;
		echo "</td><td>";
		if($r->active == 1) echo "Aktiv";
		else echo "Ikke aktiv";
	}
	
	
	?>
	<form method=POST action=admin.php?adminmode=kiosk&action=addRabatt>
	<input type=text name=name size=25> Rabattnavn
	<br><input type=text name=startTime size=15> starttidspunkt (YYYY-MM-DD TT:MM)
	<br><input type=text name=stopTime size=15> stoptidspunkt (YYYY-MM-DD TT:MM)
	<br><select name=ware>
	<?php
		$q = query("SELECT * FROM kiosk_warez");
		while($r = fetch($q)) {
			echo "<option value=$r->barcode>$r->name</option>";
		}
	?>
	</select>
	<br><input type=text name=newPrice> Pris når rabatten gjelder..
	<br><input type=submit value='Legg til rabatt'>
	</form>
	<?
	
}

elseif($action == "addRabatt") {
	$startTime = $_POST['startTime'];
	$stopTime = $_POST['stopTime'];
	$name = $_POST['name'];
	$wareID = $_POST['ware'];
	$newPrice = $_POST['newPrice'];
	
	$convertStart = strtotime($startTime);
	$convertStop = strtotime($stopTime);
	
	$q = query("INSERT INTO kiosk_rabatter SET 
		wareID = $wareID, 
		startTime = $convertStart,
		stopTime = $convertStop,
		name = '$name',
		newPrice = $newPrice,
		active = 1
	");
	refresh("Location: admin.php?adminmode=kiosk&action=rabatter", 0);
}
