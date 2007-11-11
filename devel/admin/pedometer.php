<?php
require_once ('config/config.php');
$action = $_GET['action'];

if (!acl_access("pedometer_write"))
{
	nicedie($admin[noaccess]);
}


if(empty($action)) {
	$q = query("SELECT * FROM pedometers WHERE userID = '".getcurrentuserid()."'");

	if(num($q) != 0) {
		echo "<table>";
		echo "<tr><th>".lang("Time", "admin_pedometer")."</th>";
		echo "<th>".lang("Steps", "admin_pedometer")."</th>";
		echo "</tr>";

		while($r = fetch($q)) {
			echo "<tr><td>".date("j", $r->unixTIME)." ".$month[date("m", $r->unixTIME)];
			echo " ".date("H:i:s", $r->unixTIME);
			echo "</td><td><i>";
			echo $r->steps;
			echo "</i></td></tr>";
		}

		echo "<tr><td></td><td><i><b>";
		$qSum = query("SELECT SUM(steps) AS sum FROM pedometers WHERE userID = '".getcurrentuserid()."'");
		$rSum = fetch($qSum);
		echo $rSum->sum;
		echo "</b></i></td></tr>";
		echo "</table>";
	} // End if num_rows() != 0

	echo "<br><br><form method=POST action=admin.php?adminmode=pedometer&action=addsteps>\n";
	echo "<input type=text name=steps> ".lang("Steps", "admin_pedometer");
	echo "<br><input type=submit value='".lang("Add steps", "admin_pedometer")."'>";
	echo "</form>";
} // End empty($action)


elseif($action == "addsteps") {
	$steps = $_POST['steps'];

	if(is_numeric($steps)) {
		query("INSERT INTO pedometers SET
			userID = '".getcurrentuserid()."',
			steps = '".$steps."',
			unixTIME = '".time()."'");
	} // end if(is_numeric)

	refresh("admin.php?adminmode=pedometer", 0);
} // end elseif(action==addsteps)