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

    if(!$seatopen) echo "<b>".lang("The seatreservation has not yet opened!", "seat", "Text to display when the seatreg has not opened yet")."</b><br><br>";

$crewseats = config("crewseats");

//$normalseats = config("normalseats"); //Outdated, using room.ini instead..

$file = file("room.ini");
foreach($file as $line) {
$normalseats1 = substr($line,$key);
$normalseats2 = $normalseats2 + substr_count($normalseats1, "d");
};

$dbs = query("SELECT count(*) FROM users WHERE seatX != -1 AND seatY != -1");
$q = fetch($dbs);
$cnt = $q[0];

print $seat['10']." ".($normalseats2-$cnt)."<br>";
print $seat['11']." ".($cnt)."<br><br>";
?>

<a href=index.php><?php echo lang("Back to main page", "seat", "Link to get back to main page in seat.php"); ?></a><br>
<map name=roommap>
<?php
include "seatmap.php";
?>
</map>
<form action=seat.php method=get>
<input type=checkbox <?php if(isset($_GET["zoom"]) && $_GET["zoom"] == "on") { echo "checked"; }; ?> name=zoom> <?php echo $seat['12']; ?><br><br>
<input type=submit value="<?php echo $form['60']; ?>">
</form>

<?php
$currentuserid = getcurrentuserid();
$hasSeatQ = query("SELECT * FROM users WHERE ID = '".escape_string($currentuserid)."'");
$hasSeat = fetch($hasSeatQ);
if($hasSeat->seatX != -1)
{
    echo "<a href=seat.php?action=cancel>".$seat['13']."</a><br>";
}
if(isset($_GET["x"]))
{
    $coords = "?x=".$_GET["x"]."&y=".$_GET["y"];
    $q = query("SELECT * FROM users WHERE seatX = '".escape_string($getX)."' AND seatY = '".escape_string($getY)."'");
    $r = fetch($q);
    if(num($q) != 0)
    {
        echo "<a href=index.php?inc=profile&uid=$r->ID>".$r->nick."</a> ".$seat['14']."<br>";
    }
    elseif(($canSit) && (num($q) == 0))
    {
        echo "<a href=seat.php$coords&action=seat>".$seat['15']."</a><br>";
    }
}
else
{
    $coords = "?nocoords=true";
}
?>
<img border=0 src="seatsel.php<?php echo $coords; if(isset($_GET["zoom"]) && $_GET["zoom"] == "on") { echo "&zoom=on"; }; ?>" usemap="#roommap">
<br><br>
<?php


echo "<br><font color=red>".$colour['1']."</font>: ".$seat['0']."
<br><font color=blue>".$colour['2']."</font>: ".$seat['2']."
<br><font color=darkblue>".$colour['3']."</font>: ".$seat['3']."
<br><font color=black>".$colour['4']."</font>: ".$seat['4']."
<br><font color=#00FFAA>".$colour['5']."</font>: ".$seat['5']."
<br><font color=orange>".$colour['6']."</font>: ".$seat['6']."
";
}
elseif(($action == "seat") && ($canSit))
{
    $testQ = query("SELECT * FROM users WHERE seatX = '".escape_string($getX)."' AND seatY = '".escape_string($getY)."'");
    if(num($testQ) != 0) die(lang("You may _NOT_ seat here, somebody is already sitting here!", "root_seat", "Text to display if someone sits on a spot that is already taken"));
    $currentuserid = getcurrentuserid();
    query("UPDATE users SET seatX = '".escape_string($getX)."', seatY = '".escape_string($getY)."' WHERE ID = '".escape_string($currentuserid)."'");
    header("Location: seat.php?x=$getX&y=$getY");
    dblog(9, "x".$getX."y".$getY);
}
elseif($action == "cancel")
{
    $currentuserid = getcurrentuserid();
    query("UPDATE users SET seatX = -1, seatY = -1 WHERE ID = '".escape_string($currentuserid)."'");
    header("Location: seat.php");
    dblog(9, "x-1y-1");
}
else
{
    nicedie();
}

?>