<?php

require_once 'config/config.php';
if(config("usepage_register") == FALSE)
	nicedie($msg[1]);

$action = $_GET['action'];

if(!isset($action))
{
    $action = "register";
}


if($action == "regme")
{
    $username = $_POST["username"];
    $realname = $_POST["realname"];
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


	$checkmail = mysql_query("SELECT * FROM users WHERE EMail LIKE '$email'");

	$verify = verify($username, $email, $p1, $realname);
	if($verify != "allowed") {
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
                 nicedie($msg[5]);


       $dbs = query("INSERT INTO users SET
       nick = '$username',
       EMail = '$email',
       name = '$realname',
       password = '$cpass',
       verified = $r,
       registered = now(),
	street = '$street',
	postNr = '$postNr',
	postPlace = '$postPlace',
	cellphone = '$cellphone',
	birthDAY = '$birthDAY',
	birthMONTH = '$birthMONTH',
	birthYEAR = '$birthYEAR'
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
    <tr><td><?php echo $form[29]; ?> </td><td><input type=text name=realname></td></tr>
    <tr><td><?php echo $form[30]; ?> </td><td><input type=text name=email></td></tr>
    <tr><td><?php echo $form[25]; ?> </td><td><input type=password name=p1></td></tr>
    <tr><td><?php echo $form[26]; ?> </td><td><input type=password name=p2></td></tr>
    <tr><td><?php echo $form['74']; ?></td><td><input type=text name=street></td></tr>
    <tr><td><?php echo $form['75']; ?></td><td><input type=text name=postNr size=5><input type=text name=postPlace>
    <tr><td><?php echo $form['76']; ?></td><td><input type=text name=cellphone></td></tr>
	<tr><td><?php echo $form['77']; ?></td><td><select name=birthDAY><option value=0></option>

	<?php
	for($i=1;$i<32;$i++) echo "<option value=$i>$i</option>\n";
    	echo "</select>";
	echo "<select name=birthMONTH><option value=0></option>\n\n";
	for($i=1;$i<13;$i++) echo "<option value=$i>$month[$i]</option>\n";
	echo "</select>";
	echo "<select name=birthYEAR>";
	for($y=1950;$y<2004;$y++) {
		//if($y >= 1980 && $y <= 1980) $selected = "SELECTED";
		echo "<option value=$y $selected>$y</option>\n";
	}

	?>
    <tr><td><input type=submit value=" Register "></td></tr>
    </table>
    </form>

	<br><br><b><?php echo $msg['42']; ?></b>

    <?php
}
?>
