<?php

require_once ('config/config.php');

if (config("usepage_register") == FALSE)
{
	nicedie($msg[1]);
}

$action = $_GET['action'];

if (!isset($action))
{
	$action = "register";
}


if ($action == "regme")
{
	$username = $_POST["username"];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$realname = $firstName." ".$lastName;
	$email = $_POST["email"];
	$p1 = $_POST["p1"];
	$p2 = $_POST["p2"];
	$birthDAY = $_POST['birthDAY'];
	$birthMONTH = $_POST['birthMONTH'];
	$birthYEAR = $_POST['birthYEAR'];
	$cellphone = $_POST['cellphone'];
	$street = $_POST['street'];
	$postNr = $_POST['postNr'];
	$postPlace = $_POST['postPlace'];
	$userCheckbox1 = $_POST['userCheckbox1'];
	$userCheckbox2 = $_POST['userCheckbox2'];
	$userCheckbox3 = $_POST['userCheckbox3'];
	$gender = $_POST['gender'];



	$checkmail = query("SELECT * FROM users WHERE EMail LIKE '".escape_string($email)."'");

	$verify = verify("register", "1", $username, $firstName, $lastName, $email, $p1);
	if($verify != "allowed")
	{
		nicedie($form[$verify]);
	}
	elseif($p1 != $p2) // compare the two passwords
	{
		nicedie($form[14]);
	}
	elseif(!$birthDAY || !$birthMONTH || !$birthYEAR) {
		nicedie("Du må nok stille inn når du er født. All info er nødvendig!");
	}
	elseif(!isset($street) || !isset($postNr) || !isset($postPlace)) {
		nicedie("Gateadresse, postnummer, poststed er alle nødvendige å sette opp!");
	}
	else
	{
		$pwd = $p1;
		$cpass = crypt_pwd($pwd);

		$r = createcifer();
		if(!mail("$email", $mail[0], mail_body($r), "From: ".$mail[2]))
		{
		nicedie($msg[5]);
		}

		$dbs = query("INSERT INTO users SET
			nick = '".escape_string($username)."',
			EMail = '".escape_string($email)."',
			firstName = '".escape_string($firstName)."',
			lastName = '".escape_string($lastName)."',
			password = '".escape_string($cpass)."',
			verified = '".escape_string($r)."',
			registered = '".escape_string(time())."',
			name = '".escape_string($realname)."',
			street = '".escape_string($street)."',
			postNr = '".escape_string($postNr)."',
			postPlace = '".escape_string($postPlace)."',
			cellphone = '".escape_string($cellphone)."',
			birthDAY = '".escape_string($birthDAY)."',
			birthMONTH = '".escape_string($birthMONTH)."',
			birthYEAR = '".escape_string($birthYEAR)."',
			userCheckbox1 = '".escape_string($userCheckbox1)."',
			userCheckbox2 = '".escape_string($userCheckbox2)."',
			userCheckbox3 = '".escape_string($userCheckbox3)."',
			gender = '".escape_string($gender)."'
		");

		echo $msg[6];
		dblog(6, $_COOKIE[$cookiename].":::".$username.":::".$email.":::".$name.":::".$r.":::".$street.":::".$postNr.":::".$postPlace.":::".$cellphone.":::".$birthDAY.":::".$birthMONTH.":::".$birthYEAR);

		}
	}
	elseif($action == "verify")
	{
	}
	else
	{
?>
    <form method=post action=index.php?inc=register&action=regme>
    <table border=0>

    <tr><td><?php echo $form[24]; ?> </td><td><input type=text name=username></td></tr>
    <tr><td><?php echo lang("Firstname", "inc_register", "Register: Firstname"); ?> </td><td><input type=text name=firstName></td></tr>
    <tr><td><?php echo lang("Lastname", "inc_register", "Register: Lastname"); ?> </td><td><input type=text name=lastName></td></tr>
    <tr><td><?php echo $form[30]; ?> </td><td><input type=text name=email></td></tr>
    <tr><td><?php echo $form[25]; ?> </td><td><input type=password name=p1></td></tr>
    <tr><td><?php echo $form[26]; ?> </td><td><input type=password name=p2></td></tr>
    <tr><td><?php echo $form['74']; ?></td><td><input type=text name=street></td></tr>
    <tr><td><?php echo $form['75']; ?></td><td><input type=text name=postNr size=5><input type=text name=postPlace>
    <tr><td><?php echo $form['76']; ?></td><td><input type=text name=cellphone></td></tr>
    <tr><td><?php echo lang("Gender", "inc_register"); ?></td><td><select name=gender>
    <?php
    echo "<option value=0>".lang("Doesn't consern you", "inc_register")."</option>";
    echo "<option value=1>". lang("Female", "inc_register")."</option>";
    echo "<option value=2>".lang("Male", "inc_register")."</option>";
    ?></select></td></tr>
	<tr><td><?php echo $form['77']; ?></td><td><select name=birthDAY><option value=0></option>

	<?php
	for($i=1;$i<32;$i++)
	{
		echo "<option value=$i>$i</option>\n";
	}
	echo "</select>";
	echo "<select name=birthMONTH><option value=0></option>\n\n";
	for($i=1;$i<13;$i++)
	{
		echo "<option value=$i>$month[$i]</option>\n";
	}
	echo "</select>";
	echo "<select name=birthYEAR>";
	for($y=1950;$y<2004;$y++)
	{
		echo "<option value=$y $selected>$y</option>\n";
	}

	if($userCheckbox1) echo "<tr><td>$userCheckbox1</td><td><input type=checkbox name=userCheckbox1 value=1 $userCheckbox1_default></td></tr>";
	else echo "<input type=hidden name=userCheckbox1 value=0>";

	if($userCheckbox2) echo "<tr><td>$userCheckbox2</td><td><input type=checkbox name=userCheckbox2 value=1 $userCheckbox2_default></td></tr>";
	else echo "<input type=hidden name=userCheckbox2 value=0>";

	if($userCheckbox3) echo "<tr><td>$userCheckbox3</td><td><input type=checkbox name=userCheckbox3 value=1 $userCheckbox3_default></td></tr>";
	else echo "<input type=hidden name=userCheckbox3 value=0>";
	?>
	<tr><td><input type=submit value=" Register "></td></tr>
	</table>
	</form>

	<br><br><b><?php echo $msg['42']; ?></b>

	<?php
}
?>
