<?php
require_once 'config/config.php';
$getX = $_GET['x'];
$getY = $_GET['y'];
$action = $_GET['action'];
//echo "X = $getX AND Y = $getY";
if(config("seatreg_open") && getcurrentuserid() != 1) $canSit = TRUE;
elseif(acl_access("isCrew")) $canSit = TRUE;
else $canSit = FALSE;

$seatopen = config("seatreg_open");

if(!isset($action)) {

	if(!$seatopen) echo "<b>Plassregistreringa har _IKKE_ åpnet ennå</b><br>";
	
$crewseats = config("crewseats");
$normalseats = config("normalseats");

$dbs = mysql_query("SELECT count(*) FROM users WHERE seatX != -1 AND seatY != -1 AND isCrew = 0")
	or die(mysql_error());

$q = mysql_fetch_row($dbs);
$cnt = $q[0];

echo "Ledige seter : ".($normalseats-$cnt)." (altså er $cnt tatt)<br>\n";
?>
<a href=index.php>Back to tha main page</a><br>
<map name=roommap>
<?php
include "seatmap.php";
?>
</map>
<form action=seat.php method=get>
<input type=checkbox <?php if(isset($_GET["zoom"]) && $_GET["zoom"] == "on") { echo "checked"; }; ?> name=zoom> Zoom (vis navn)<br><br>
<input type=submit value="vis">
</form>

<?php
$hasSeatQ = query("SELECT * FROM users WHERE ID = ".getcurrentuserid());
$hasSeat = fetch($hasSeatQ);
if($hasSeat->seatX != -1) echo "<a href=seat.php?action=cancel>Avbestill plassen</a><br>";
if(isset($_GET["x"])) {
	$coords = "?x=".$_GET["x"]."&y=".$_GET["y"];
	$q = query("SELECT * FROM users WHERE seatX = '$getX' AND seatY = '$getY'");
	$r = fetch($q);
	if(num($q) != 0) echo "<a href=index.php?inc=profile&uid=$r->ID>".$r->nick."</a> sitter her<br>";
	elseif($canSit && num($q) == 0) echo "<a href=seat.php$coords&action=seat>Ledig, jeg tar'n</a><br>";
	}
	
else
	$coords = "?nocoords=true";
?>
<img border=0 src="seatsel.php<?php echo $coords; if(isset($_GET["zoom"]) && $_GET["zoom"] == "on") { echo "&zoom=on"; }; ?>" usemap="#roommap">
<br><br>
<?php


echo "<br><font color=red>Rød</font>: ikke åpnet plass
<br><font color=blue>Blå</font>: deltagerplass; bare å ta
<br><font color=darkblue>Mørkblå</font>: dør
<br><font color=black>Svart</font>: vegg
<br><font color=#00FFAA>Lys grønt</font>: kiosken
<br><font color=orange>Oransj</font>: crew
";
}
elseif($action == "seat" && $canSit) {
	$testQ = query("SELECT * FROM users WHERE seatX = $getX AND seatY = $getY");
	if(num($testQ) != 0) die("Du kan _IKKE_ plassere deg der noen andre sitter!");
	query("UPDATE users SET seatX = $getX, seatY = $getY WHERE ID = ".getcurrentuserid());
	header("Location: seat.php?x=$getX&y=$getY");
}
elseif($action == "cancel") {
	query("UPDATE users SET seatX = -1, seatY = -1 WHERE ID = ".getcurrentuserid());
	header("Location: seat.php");
}
else die("Nope, ingenting av interresse her");
