<?php



require_once "config/config.php";



$action = $_GET['action'];

if(getuserrank() != 2) {



	$editID = getcurrentuserid();

} elseif(!isset($_GET['user'])) {



	$editID = getcurrentuserid();

} elseif(getuserrank() == 2 && isset($_GET['user'])) {

	$editID = $_GET['user'];

}





if($action == "view" || !isset($action)) {



	if($_GET['mode'] == "success") echo "<font color=red>$profile[7]</font>";

	if($_GET['mode'] == "pwdsuccess") echo "<font color=red>$profile[7]</font>";



	$query = mysql_query("SELECT * FROM users WHERE ID = $editID") or die(mysql_error());

	$row = mysql_fetch_object($query);



	echo "<form method=post action=index.php?inc=useradmin&action=edit&user=$row->ID>";

	echo '<table>';

	user_table($profile[3],"<input type=text name=name value='$row->name'>");

	// We want a little bit of security, so we have this one on it's own page with verifcation.

	//user_table($profile[6], "<input type=text name=mail value='$row->EMail'>");

	user_table($profile[4], "<textarea name=aboutme rows=10 cols=60>$row->aboutMe</textarea>");

	if($row->isCrew >= 1) {

		user_table($profile[10], "<input type=text name=crewfield value='$row->crewField'>");

	}

	user_table($profile[12], "<input type=text name=cellphone value='$row->cellphone'>");

	user_table($form[25], "<a href=index.php?inc=useradmin&action=changepass&user=$editID>$form[33]</a>");

	user_table($profile[6], "<a href=index.php?inc=useradmin&action=changemail&user=$editID>$form[34]</a>");



	echo "<tr><td class=profileLeft width=30%>$profile[9]</td><td class=profileRight>";



	if(getuserrank() == 2) {

		echo "<select name=rank>";

		for($y=0;$y<count($rank);$y++) {

			echo "<option value=$y";

			if($row->isCrew == $y) echo " SELECTED";

			echo ">$rank[$y]</option>";

		}

		echo "</select>";

	} else {

		$rank1234 = $row->isCrew;

		echo "<input type=hidden name=rank value=$row->isCrew>$rank[$rank1234]";

	}

	echo "</td></tr>";



	echo "<tr><td class=profileLeft width=30%>$profile[13]</td><td class=profileRight>";

	echo "<select name=allowPublic>";

	for($y=0;$y<count($allowPublicFor);$y++) {

		echo "<option value=$y";

		if($row->AllowPublic == $y) echo " SELECTED";

		echo ">$allowPublicFor[$y]</option>";

	}

	echo "</select>";



	echo "<tr><td class=profileLeft width=30%>$profile[14]</td><td class=profileRight>";

	echo "<select name=userDesign>";

	for ($y=0;$y<count($styles);$y++) {

		echo "<option value=$styles[$y]";

		if($row->userDesign == $styles[$y]) echo " SELECTED";

		echo ">$styles[$y]</option>";

	}

	echo "</select>";

	echo "</td></tr>";

	echo "</table>";

	echo "<br><input type=submit value='$form[15]'>";







}



elseif($action == "edit") {



	$name = $_POST['name'];

	$mail = $_POST['mail'];

	$aboutme = htmlspecialchars($_POST['aboutme']);

	$rank = $_POST['rank'];

	$crewField = $_POST['crewfield'];

	$cellphone = $_POST['cellphone'];

	$allowPublic = $_POST['allowPublic'];

	$userDesign = $_POST['userDesign'];

	$query = mysql_query("UPDATE users SET name = '$name',

		EMail = '$mail',

		aboutMe = '$aboutme',

		crewField = '$crewField',

		cellphone = '$cellphone',

		allowPublic = $allowPublic,

		userDesign = '$userDesign',

		isCrew = '$rank' WHERE ID = $editID") or die(mysql_error());

	refresh("index.php?inc=useradmin&user=$editID", "0");



} elseif($action == "changepass") {



	?>

	<table>

	<form method=post action=index.php?inc=useradmin&user=<?php echo $editID; ?>&action=doeditpass>

	<?php

	user_table($form[25], "<input type=password name=pwd1>");

	user_table($form[26], "<input type=password name=pwd2>");

	user_table("", "<input type=submit value='$form[15]'>");



	echo '</table>';

} elseif($action == "doeditpass") {

	$pwd1 = $_POST['pwd1'];

	$pwd2 = $_POST['pwd2'];



	if($pwd1 != $pwd2) {

		die($form[14]);

	} else {

		$cpass = crypt_pwd($pwd1);

		mysql_query("UPDATE users SET password = '$cpass' WHERE ID = $editID") or die(mysql_error());

		refresh("index.php?inc=useradmin&mode=pwdsuccess&user=$editID", "0");

	}

} elseif($action == "changemail") {

	$query = mysql_query("SELECT * FROM users WHERE ID = $editID") or die(mysql_error());

	$row = mysql_fetch_object($query);

	?>

	<table>

	<form method=post action=index.php?inc=useradmin&action=dochangemail&user=<?php echo $editID; echo ">";



	user_table($profile[6], "<input type=text name=newmail value='$row->EMail'>");

	user_table("", "<input type=submit value='$form[15]'>");

	echo '</table></form>';

	echo $form[36];



} elseif($action == "dochangemail") {

	$query = mysql_query("SELECT * FROM users WHERE ID = $editID") or die(mysql_error());

	$check = mysql_fetch_object($query);

	$newmail = $_POST['newmail'];



	if($newmail == $check->EMail) {

		echo $form[35];

		refresh("index.php?inc=useradmin&user=$editID");

	} else {

		$ran = createcifer() or die("Could not create random number!");

		$update = mysql_query("UPDATE users SET EMail = '$newmail', verified = '$ran' WHERE ID = $editID") or die(mysql_error());



		if(!mail("$newmail", $mail[0], mail_body($ran), "From: ".$mail[2]))

		{

			die($msg[5]);

		}

		else {

			refresh("index.php?inc=useradmin&edit=$editID&mode=mailsuccess", 0);

		}

	}

}









function user_table($userLeft, $userRight) {

	echo "<tr><td class=profileLeft width=25%>$userLeft</td><td class=profileRight>";

	echo $userRight;

	echo "</td></tr>\n\n";

}

?>