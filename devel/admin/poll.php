<?php



require 'config/config.php';



if(!acl_access("poll")) die($admin[noaccess]);



if(isset($_GET['action'])) {

	$action = $_GET['action'];

} else {

	$action = "list";

}

$poll = $_GET['poll'];



if($action == "list") {

	echo "<table>";



	$query = mysql_query("SELECT * FROM pollQ") or die(mysql_error());



	$num = mysql_num_rows($query);



	for($o=0;$o<$num;$o++) {



		$row = mysql_fetch_object($query);

		echo "<tr><td>$row->text</td>";

		echo "<td><a href=admin.php?adminmode=poll&action=delete&poll=$row->ID>$form[16]</a></td>";

		echo "<td><a href=admin.php?adminmode=poll&action=edit&poll=$row->ID>$form[17]</a></td>";

		echo "<td><a href=admin.php?adminmode=poll&action=reset&poll=$row->ID>$form[19]</a></td>";



		if($row->isOpen == 1) $toggle = $form[23];

		else $toggle = $form[22];

		echo "<td><a href=admin.php?adminmode=poll&action=toggle&poll=$row->ID>$toggle</a></td>";



		echo "</tr>";



	}



	echo "</table>";

	?>

	<form method=post action=admin.php?adminmode=poll&action=add>

	<input type=text name=pollQ size=25> <?php echo $form[45]; ?>

	<br><input type=text name=maxV value=1 size=2> <?php echo $form[44]; ?>

	<br><input type=submit value='<?php echo $form[7]; ?>'>

	</form>

	<?php

} elseif($action == "delete" && isset($poll)) {

	mysql_query("DELETE FROM pollQ WHERE ID = $poll") or die(mysql_error());

	mysql_query("DELETE FROM pollA WHERE QID = $poll") or die(mysql_error());

	mysql_query("DELETE FROM pollVoted WHERE pollID = $poll") or die(mysql_error());



	refresh("admin.php?adminmode=poll", "0");

}

elseif($action == "add") {

	$pollQ = $_POST['pollQ'];

	$maxVotes = $_POST['maxV'];

	$query = mysql_query("INSERT INTO pollQ SET text = '$pollQ', maxVotes = $maxVotes") or die(mysql_error());

	refresh("admin.php?adminmode=poll", "0");

} elseif($action == "edit" && isset($poll)) {

	$queryQ = mysql_query("SELECT * FROM pollQ WHERE ID = $poll") or die(mysql_error());



	$queryA = mysql_query("SELECT * FROM pollA WHERE QID = $poll") or die(mysql_error());

	$rowQ = mysql_fetch_object($queryQ);

	echo "<center>$rowQ->text</center>";

	if(mysql_num_rows($queryA) == 0) {

		echo "<br><br>".$form[21];

	} else {



		for($A=0;$A<mysql_num_rows($queryA);$A++) {

			$rowA = mysql_fetch_object($queryA);



			echo "<br>$rowA->Atext";

		}

	}

	?>

	<br><br>

	<form method=post action=admin.php?adminmode=poll&action=addanswer&poll=<?php echo $poll; ?>>

	<input type=text name=answer>

	<br>

	<input type=submit value='<?php echo $form[7]; ?>'>

	</form>

	<?php





} elseif($action == "addanswer" && isset($poll)) {



	$answer = $_POST['answer'];

	if(!isset($answer)) die($form[38]);

	$query = mysql_query("INSERT INTO pollA SET Atext = '$answer', QID = $poll") or die(mysql_error());

	refresh("admin.php?adminmode=poll&action=edit&poll=$poll", "0");

} elseif($action == "toggle" && isset($poll)) {



	$query = mysql_query("SELECT isOpen FROM pollQ WHERE ID = $poll");

	$row = mysql_fetch_object($query);



	if($row->isOpen == 1) {

		$isOpen = 0;

	} else {

		$isOpen = 1;

	}



	mysql_query("UPDATE pollQ SET isOpen = $isOpen WHERE ID = $poll") or die(mysql_error());



	refresh("admin.php?adminmode=poll", "0");

} elseif($action == "reset" && isset($poll)) {



	mysql_query("UPDATE pollA SET votes = 0 WHERE QID = $poll") or die(mysql_error());

	mysql_query("DELETE FROM pollVoted WHERE pollID = $poll") or die(mysql_error());

	refresh("admin.php?adminmode=poll", 0);

}



?>