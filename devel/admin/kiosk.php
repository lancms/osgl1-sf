<?php
require 'config/config.php';

if(getuserrank() != 2) {
	die($admin[noaccess]);
}
$action = $_GET['action'];
if(!isset($action)) {
	echo "<table>";
	echo "<tr><th>$form[53]</th><th>$form[54]</th><th>$form[55]</th></tr>";
	$q = mysql_query("SELECT * FROM kiosk_warez");

	while($r = mysql_fetch_object($q)) {
		echo "<tr><td>$r->name</td>";
		echo "<td>$r->price</td>";
		echo "<td>$r->stock</td>";
		echo "</tr>";

	}

	echo "</table>";

	echo "<br><hr><br>";

	echo "<form method=POST action=admin.php?adminmode=kiosk&action=addware>";
	echo "<input type=text name=name size=25> $form[53]";
	echo "<br><input type=text name=price size=4> $form[54]";
	echo "<br><input type=submit value='$form[15]'>";
	echo "</form>";
} elseif($action == "addware") {
	$name = $_POST['name'];
	$price = $_POST['price'];

	mysql_query("INSERT INTO kiosk_warez SET name = '$name', price = $price") or die(mysql_error());
	refresh("admin.php?adminmode=kiosk", 0);
}