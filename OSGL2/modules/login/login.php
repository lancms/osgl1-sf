<?php


if($action == "finduser")
{
	$user = db_escape($_GET['username']);

	if(is_numeric($_GET['username'])) $finduser = db_query("SELECT * FROM ".$sql_prefix."_users WHERE ID = '$user'");
	else $finduser = db_query("SELECT * FROM ".$sql_prefix."_users 
		WHERE (nick LIKE '%".$user."%'
		OR EMail LIKE '%".$user."%'
		OR firstName LIKE '%".$user."%'
		OR lastName LIKE '%".$user."%'
		OR ID = '$user')
		AND ID!=1
	");

	if(db_num($finduser) >= 20)
	{
		$content .= lang("Sorry, too many users, try to narrow down the search", "login");
	} // End if db_num > 20

	elseif(db_num($finduser) == 0)
	{
		$content .= lang("Sorry, no such user found", "login");

	}
	elseif(db_num($finduser) == 1)
	{
		$row = db_fetch($finduser);
		header("Location: index.php?module=login&action=password&userID=$row->ID");
	}
	else
	{
		// The search found more than 0 and less then 20 users
		$content .= "<table>";

		while($row = db_fetch($finduser)) {
			$content .= "<tr><td><a href=\"?module=login&amp;action=password&amp;userID=$row->ID\">$row->nick</a></td></tr>";
		} // End while row = db_fetch;

		$content .= "</table>";

	} // End else


} // End if action = finduser



elseif($action == "password" && !empty($_GET['userID']))
{

	$userID = $_GET['userID'];

	$get_user = db_query("SELECT * FROM ".$sql_prefix."_users WHERE ID = ".db_escape($userID));

	$userinfo = db_fetch($get_user);

	$content .= "<p>".lang("Log in as:", "login")."&nbsp;&nbsp;&nbsp;".$userinfo->nick."</p>\n";
	$content .= "<form name='password' method=\"post\" action=\"?module=login&amp;action=login&amp;userID=$userID\">\n";
	$content .= "<p>".lang("Password:", "login")." <input class=\"login\" type=\"password\" name=\"password\" /></p>\n";
	$content .= "<p><input class=\"login\" type=\"submit\" value=\"Login\" /></p>\n";
	$content .= "</form>\n";
	$content .= "\n\n";
	$content .= "<script type='text/javascript' language='javascript'>document.forms['password'].elements['password'].focus()</script>\n";
	$content .= "\n\n";
}


elseif($action == "login" && isset($_GET['userID']) && isset($_POST['password']))
{
	/* User has spesified user ID and password, attempt to login */
	$password = $_POST['password'];
	$userID = $_GET['userID'];

	$get_user = db_query("SELECT * FROM ".$sql_prefix."_users WHERE ID = ".db_escape($userID));
	$userinfo = db_fetch($get_user);

	if(md5($password) == $userinfo->password)
	{
		// Passwords match. Login the user
		db_query("UPDATE ".$sql_prefix."_session SET userID = '".db_escape($userID)."'
			WHERE sID = '".db_escape($_COOKIE[$osgl_session_cookie])."'");

		// logtype, 1 (login).
		$log_new['user_agent'] = $_SERVER['HTTP_USER_AGENT']; 
		log_add ("login", "success", serialize($log_new), NULL, $userID);

		header("Location: index.php"); // Move to index.php, should give a new userinfo-box
	} // End if passwords match

	else
	{
		// Passwords does not match. Fuck the user
		$content .= lang("sorry, wrong password!", "login");

		// but log it:
		// logtype, 3 (failed login)
		$log_new['session_ID'] = $sessioninfo->sID;
		$log_new['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		log_add ("login", "failed_password", serialize($log_new), NULL, $userID);

	} // End else (password does not match)

} // End elseif action = login


elseif($action == "logout")
{
	// logtype, 2 (logout).
	log_add ("login", "logout");

	db_query("UPDATE ".$sql_prefix."_session 
		SET userID = 1 
		WHERE sID = '".db_escape($_COOKIE[$osgl_session_cookie])."'");

	// FIXME: Should probably return to referrer.
	header("Location: index.php");
}
