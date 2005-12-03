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
		nicedie("Wrong username or password <br> <a href='index.php?inc=login&action=resendPwd'>Forgotten your password?</a>");
	}

	$res = log_in($username, $pwd);

	if ($res == -1) // the password is incorrect
	{
		nicedielang ("Wrong username or password.<br> <a href='index.php?inc=login&action=resendPwd'>Forgotten your password?</a>", "root_do", "Wrong username or password-warning");
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
        nicedielang ("You are not logged in.", "root_do", "Logged out-message");
	}
	else
	{
		echo lang ("You are now logged out.", "root_do", "Logout-message");
	}
}
elseif ($action == "verify" && isset ($_GET['uid']))
{
	require_once ($base_path."style/top.php");
	$uid = $_GET['uid'];

	echo lang ("Please enter the verificationcode that was sent to your emailaddress.", "root_do", "");
	echo "<br>";
	// XXX: Perhaps we should provide admin-email here?
	echo lang ("If you have not recieved your verificationcode within a reasonable time, please contact the administrators.", "root_do", "Explains what to do if youve not recieved your verificationcode");
	?>
	<form method=post action=do.php?action=doverify>
	<input type=text name=verifycode>
	<input type=submit value='<?php echo lang ("Verify", "root_do", "Verify-button-text"); ?>'>
	<input type=hidden value='<?php echo $_GET["uid"]; ?>' name="uid">
	</form>
	<?php
	echo "<br><br>";
	echo "<a href=do.php?action=resendValidationMail&uid=$uid>".lang("Resend validation EMail", "root_do", "Linktext to resend validation EMail")."</a>";
}
elseif($action == "doverify")
{
	$uid = $_POST['uid'];
	$my_userID = $uid;
	$query = query("SELECT users.verified FROM users WHERE ID='".escape_string($my_userID)."'");
	$result = fetch($query);

	if (($result->verified == "0") || ($result->verified == NULL))
	{
		$errmsg = lang ("User already verified.", "root_do", "Text to display to already verified users");
		nicedie ($errmsg);
	}
	elseif ($result->verified == $_POST['verifycode'])
	{
		require_once ($base_path."style/top.php");
		echo lang ("You have been verified.", "root_do", "Text to show when verified");
		$query = query("UPDATE users SET users.verified=0 WHERE ID='".escape_string($my_userID)."'");
		$sID = $_COOKIE[$cookiename];
		$login = query("UPDATE session SET userID=".$my_userID." WHERE sID='".escape_string ($sID)."'");
	}
	else
	{
		echo lang ("The code you entered don't match. Please try again or contact the administrators!", "root_do", "Text to show when verificationcode don't match");
	}
}
elseif($action == "resendValidationMail")
{
	$uid = $_GET['uid'];
	$q = query("SELECT * FROM users WHERE ID = '".escape_string($uid)."'");
	$r = fetch($q);
	mail($r->EMail, $mail[0], mail_body($r->verified), "From: ".$mail[2])
                or nicedielang("Could not send EMail, check the server config!", "root_do", "Text to display when mail could not be sent from do.php?action=resendValidationEMail");
}
else
{
	nicedie("No such function here");
}

require_once ($base_path."style/bottom.php");
?>
