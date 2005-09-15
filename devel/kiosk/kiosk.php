<?php
require_once 'config/config.php';
require_once 'kiosk/kiosk_functions.php';

$action = $_GET['action'];
$display_bytt_kasse = TRUE; 
if(crewsale()) $pricerow = "cPrice";
else $pricerow = "price";

if(!isset($action)) {
include_once $base_path."style/".'top.php';
include_once 'kiosk/kiosk_top.php';
?>
<form method=POST action=index.php?kiosk=kiosk&action=selg name=barfield>
<input type=text name=barcode>
<input type=submit value='legg til handlekurv!'>
</form>
<script language="JavaScript"> document.forms['barfield'].barcode.focus(); </script>

<form method=POST action=index.php?kiosk=kiosk&action=sale>
<select name=barcode>
<?php

$q = query("SELECT * FROM kiosk_warez WHERE active = 1");
while($r = fetch($q)) {
echo "<option value=$r->barcode>$r->name</option>";
}

?>
</select>
<input type=submit value='legg til handlekurv'></form><br><br>
<?php
$q = query("SELECT * FROM temp_basket WHERE sID = '".$_COOKIE[$cookiename]."' ORDER BY unixtime DESC");
echo "</td><td>";
echo "<div class=total_kurv>".my_basket_total()."</div>";
echo "<form method=POST action=index.php?kiosk=kiosk&action=gjorsalget>
<input type=text name=veksel size=3 value=0>
<br><input type=submit value='SELG!'></form>";
echo "</td><td valign=top>";


/* Gjør det mulig å bytte kasse */

echo "<form method=POST action=index.php?kiosk=kiosk&action=changebox>";
$currentkasse = my_box();
echo "<select name=nykasse>";
$qk = query("SELECT * FROM kiosk_box");
while($rk = fetch($qk)) {
	echo "<option value=$rk->ID";
	if($rk->ID == $currentkasse) echo " SELECTED";
	echo ">$rk->boxname ($rk->content)</option>";
}
echo "</select>";
echo "<input type=submit value='Bytt kasse'>";
echo "</form>";



/* Lister ut alt som ligger i kurven */
echo "<tr><td>";
echo "<table>";

/* Denne bruker vi ikke allikevel fordi vi heller vil ha en opp antall av hver...*/
/*
while($r = fetch($q)) {

echo "<tr><td>";
$winfo = wareinfo($r->wareID);
echo $winfo->name;
echo "</td><td><b>";
echo $winfo->$pricerow;
echo "</b></td><td>";
echo "<form method=POST action=index.php?kiosk=kiosk&action=fjernsalg><input type=hidden name=fjernID value='$r->ID'><input type=submit value='Fjern varen'></form>";
echo "</td></tr>";

}

*/

while($r = fetch($q)) {
	$winfo = wareinfo($r->wareID);
	echo "<tr><td>";
	echo $winfo->name;
	
	echo "</td><td>";
	echo $r->amount;
	
	echo "</td><td>";
	echo "<form method=POST action=index.php?kiosk=kiosk&action=fjernsalg><input type=hidden name=fjernID value='$r->ID'><input type=submit value='Fjern vare'></form>";
	echo "</td><td>";
	echo "(".$winfo->$pricerow.")"; 
	echo "</td></tr>";
}

echo "</table>";

echo "</td><td>";
if(isset($_GET['veksel']))
echo "<div class=viktig_info>".$_GET['veksel']."</div>";

//echo "</td>";
include_once 'kiosk/kiosk_bottom.php';
}

elseif($action == "sale") {
$barcode = $_POST['barcode'];
$sID = $_COOKIE[$cookiename];
$q = query("SELECT * FROM kiosk_warez WHERE barcode = '$barcode'");
if(num($q) != 0) {
	$exists = query("SELECT * FROM temp_basket WHERE sID = '$sID' AND wareID = '$barcode'");
	if(num($exists) == 0) {
	query("INSERT INTO temp_basket SET sID = '".$_COOKIE[$cookiename]."', wareID = '$barcode', unixtime = ".time());
	} else {
		query("UPDATE temp_basket SET amount = amount + 1 WHERE sID = '$sID' AND wareID = '$barcode'");
	}
	header("Location: index.php?kiosk=kiosk");
	}
else die("WTF? Ingen har lagt inn den varen her.....");
}

elseif($action == "gjorsalget") {
$q = query("SELECT * FROM temp_basket WHERE sID = '".$_COOKIE[$cookiename]."'");
if(num($q) == 0) {
	include_once 'top.php';
	die("Prøve å faktisk selge noe før du gjør et salg? *hva skal man gjøre med de håpløse selgerne her*");
}

$userID = getcurrentuserid();
$crewsalg = crewsale();
$total = my_basket_total();
$kasse = my_box();
query("INSERT INTO kiosk_history_sales_overall SET salesperson = $userID,
	crewsale = $crewsalg,
	money = $total,
	box = $kasse
	");
query("UPDATE kiosk_box SET content = content + $total WHERE ID = $kasse");

while($r = fetch($q)) {
$winfo = wareinfo($r->wareID);
$price = $winfo->$pricerow;
$rabatt = ware_rabatt($r->wareID);
if($rabatt) $price = $rabatt;
if($rabatt) $rabatt = 1;
$amount = $r->amount;
while($amount) {
	
	query("INSERT INTO kiosk_history_sales SET salesperson = '$userID',
		logUNIX = '".time()."',
		wareID = '".$r->wareID."',
		warePrice = '".$price."',
		crewSalg = ".crewsale().",
		kasse = '$kasse',
		rabatt = '$rabatt'
		");
	$amount--;
}


query("DELETE FROM temp_basket WHERE ID = $r->ID");
}
$veksel = $_POST['veksel'];

if($veksel > 0) {
	$tilbake = $veksel - $total;
	header("Location: index.php?kiosk=kiosk&veksel=$tilbake");
} else
	header("Location: index.php?kiosk=kiosk");
}

elseif($action == "fjernsalg" && isset($_POST['fjernID'])) {
$fjernID = $_POST['fjernID'];
$sID = $_COOKIE[$cookiename];
$q = query("SELECT * FROM temp_basket WHERE sID = '$sID' AND ID = $fjernID");
$r = fetch($q);
if($r->amount == 1)
	query("DELETE FROM temp_basket WHERE ID = $fjernID AND sID = '$sID'");
else query("UPDATE temp_basket SET amount = amount - 1 WHERE ID = $fjernID");
header("Location: index.php?kiosk=kiosk");
}



elseif($action == "togglecrewsale") {
	toggle_crewsale();
        header("Location: index.php?kiosk=kiosk");
}

elseif($action == "changebox") {
	$nykasse = $_POST['nykasse'];
	$sID = session_id();
	query("UPDATE session SET kiosk_box = $nykasse WHERE sID = '$sID'");
	header("Location: index.php?kiosk=kiosk");
}
