<?php

require_once 'config/config.php';

$action = $_GET['action'];

if (!isset ($action))
{
	nicedie ($msg['29']);
}

if ($action == "login")
{
	if ((isset ($_POST['username'])) && (isset ($_POST['password'])))
	{
		$username = $_POST['username'];
		$pwd = $_POST['password'];
	}
	else
	{
		nicedie();
	}

	$res = log_in($username, $pwd);

	if ($res == -1) // the password is incorrect
	{
		nicedie ($msg['30']);
	}
	elseif ($res == -2) // User not verified
	{
		$uid = getuseridx($username, $pwd);
		header ("Location: do.php?action=verify&uid=$uid");
	}
	elseif ($res == 1)
	{
		header ("Location: index.php");
	}
	else
	{
		nicedie ();
	}
}
elseif ($action == "logout")
{
	$res = log_out ();
	require_once ($base_path."style/top.php");
	if($res == 0)
	{
        echo $msg['26'];
	}
	else
	{
		echo $msg['27'];
	}
}
elseif (($action == "verify") && (isset ($_GET['uid'])))
{
	require_once ($base_path."style/top.php");
	$uid = $_GET['uid']
	
	echo $msg[23];
	echo "<br>";
	echo $msg[24];
	?>
	<form method=post action=do.php?action=doverify>
	<input type=text name=verifycode>
	<input type=submit value='<?php echo $form[59]; ?>'>
	<input type=hidden value='<?php echo $_GET["uid"]; ?>' name="uid">
	</form>
	<?php
	echo "<br><br>";
	echo "<a href=do.php?action=resendValidationMail&uid=$uid>".lang("Resend validation EMail", "root_do", "Linktext to resend validation EMail")."</a>";
}
elseif($action == "doverify")
{
	$uid = $_POST['uid'];
	$my_userID = mysql_escape_string ($uid);
	$query = query("SELECT users.verified FROM users WHERE ID=".$my_userID."");
	$result = fetch($query);

	if (($result->verified == "0") || ($result->verified == NULL))
	{
		$errmsg = lang ("User already verified.", "root_do", "Text to display to already verified users");
		nicedie ($errmsg);
	}
	elseif ($result->verified == $_POST['verifycode'])
	{
		require_once ($base_path."style/top.php");
		echo $msg[3];
		$query = query("UPDATE users SET users.verified=0 WHERE ID=".$my_userID."");
		$sID = $_COOKIE[$cookiename];
		$login = query("UPDATE session SET userID=".$my_userID." WHERE sID='".mysql_escape_string ($sID)."'");
	}
	else
	{
		echo $msg[4];
	}
}
elseif($action == "resendValidationMail")
{
	$uid = $_GET['uid'];
	$q = query("SELECT * FROM users WHERE ID = '".mysql_escape_string($uid)."'");
	$r = fetch($q);
	mail($r->EMail, $mail[0], mail_body($r->verified), "From: ".$mail[2])
                or nicedie(lang("Could not send EMail, check the server config!", "root_do", "Text to display when mail could not be sent from do.php?action=resendValidationEMail"));
}
else
{
	nicedie("No such function here");
}

require_once ($base_path."style/bottom.php");
?>
