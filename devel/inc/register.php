<?php

require_once 'config/config.php';
if(config("usepage_register") == FALSE) die($msg[1]);

db_connect();

$action = $_GET['action'];

if(!isset($action))
{
    $action = "register";
}


if($action == "regme")
{
    $username = $_REQUEST["username"];
    $realname = $_REQUEST["realname"];
    $email = $_REQUEST["email"];
    $p1 = $_REQUEST["p1"];
    $p2 = $_REQUEST["p2"];
	$checkmail = mysql_query("SELECT * FROM users WHERE EMail LIKE '$email'");

	$verify = verify($username, $email, $p1, $realname);
	if($verify != "allowed") {
		echo $form[$verify];
		include $base_path."style/bottom.php";
		die();
	}
    elseif($p1 != $p2) // compare the two passwords
    {
        echo $form[14];
        include $base_path."style/bottom.php";
	die();
    }

    else
    {
        $pwd = $p1;
        $cpass = crypt_pwd($pwd);

        $r = createcifer();
        if(!mail("$email", $mail[0], mail_body($r), "From: ".$mail[2]))
                 die($msg[5]);


       $dbs = mysql_query("INSERT INTO users SET
       nick = '$username',
       EMail = '$email',
       name = '$realname',
       password = '$cpass',
       verified = $r,
       registered = now()")
           or die("Could not create new user : ".mysql_error());

          echo $msg[6];

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
    <tr><td><input type=submit value=" Register "></td></tr>
    </table>
    </form>

    <?php
}
?>
