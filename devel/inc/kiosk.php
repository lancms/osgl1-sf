<?php
require_once 'config/config.php';

if(!config("usepage_kiosk")) nicedie($msg[1]);
$writable = FALSE;
if(getuserrank() >= 1) $writable = TRUE;


$action = $_GET['action'];

if(!isset($action)) {
	echo "<table>";
	echo "<tr><th>$form[53]</th><th>$form[54]</th><th>$form[55]</th>";
	if($writable) echo "<th>$form[56]</th><th>$form[57]</th>";
	echo "</tr>";
	$q = mysql_query("SELECT * FROM kiosk_warez");

	while($r = mysql_fetch_object($q)) {
		echo "<tr><td>$r->name</td>";
		echo "<td>$r->price</td>";
		echo "<td>$r->stock</td>";
		if($writable) {
			echo "<form method=POST action=index.php?inc=kiosk&action=buy>";
			echo "<input type=hidden name=wareID value=$r->ID>";
			echo "<td><input type=text name=number size=3>";
			echo "</td><td>";
			echo "<input type=text name=nick size=20>";
			echo "</td><td>";
			echo "<input type=submit value='$form[15]'>";
			echo "</td>";
			echo "</form>";
		}
		echo "</tr>";

		}

	echo "</table>";
}

elseif($action == "buy") {
	$ware = $_POST['wareID'];
	$number = $_POST['number'];
	$nick = $_POST['nick'];

	mysql_query("INSERT INTO kiosk_temp SET ware = $ware, number = $number, nick = '$nick'") or nicedie(mysql_error());
	refresh("index.php?inc=kiosk&action=show&show=$ware", 0);


} elseif($action == "show") {
	$show = $_GET['show'];

	$q = mysql_query("SELECT * FROM kiosk_warez WHERE ID = $show") or nicedie(mysql_error());
	$r = mysql_fetch_object($q);

	echo "<table align=center>";
	echo "<tr><td>";

	echo $form[53];
	echo "</td><td>";
	echo $r->name;
	echo "</td></tr>";
	echo "<tr><td>";
	echo $form[54];
	echo "</td><td>";
	echo $r->price;
	echo "</td></tr>";
	echo "<tr><td>";
	echo $form[55];
	echo "</td><td>";
	echo $r->stock;
	echo "</td></tr>";
	echo "</table>";
	echo "<br><br>";
	echo "<table>";
	$q2 = mysql_query("SELECT * FROM kiosk_temp WHERE ware = $show") or nicedie(mysql_error());
	while($r2 = mysql_fetch_object($q2)) {
		echo "<tr><td>";
		echo $r2->nick;
		echo "&nbsp&nbsp; ($r2->number)";
		echo "</td>";
		if($writable) echo "<td><a href=index.php?inc=kiosk&action=thanksForTheFood&food=$r2->ID&show=$show>$form[58]</a></td>";
		echo "</tr>";
	}
	echo "</table>";

} elseif($action == "thanksForTheFood") {
	$food = $_GET['food'];
	mysql_query("DELETE FROM kiosk_temp WHERE ID = $food") or nicedie(mysql_error());
	refresh("index.php?inc=kiosk&action=show&show=".$_GET['show'], 0);

}
