<?php

db_connect();

// this MUST run each time the page shall be displayed.
$URL = NULL;

$userIP = $HTTP_SERVER_VARS['REMOTE_ADDR'];
$URL = $_SERVER['REQUEST_URI'];

if(!isset($_COOKIE[$cookiename]))
{
	srand((double)microtime()*1000000); // create new seed

	$new_session = md5(rand(0,9999999)); // random session ID

	session_id($new_session); // set session ID

	session_start(); // start session

	setcookie($cookiename, $new_session); // remember session

	if($usestats)
	{
		require_once 'stats_sessionstart.php';
	}

	$createUID = 1;

	query("INSERT INTO session (userID, sID, logUNIX, IP) VALUES('".escape_string($createUID)."', '".escape_string($new_session)."', '".escape_string(time())."', '".escape_string($userIP)."')");
	dblog(2, $new_session.":::".$_SERVER['HTTP_REFERER']);
}
else
{
	$sID = $_COOKIE[$cookiename];

	$check_session = query("SELECT * FROM session WHERE sID = '".escape_string($sID)."'");

	if(num($check_session) != 0)
	{
 	session_id($_COOKIE[$cookiename]); // set session, this cookie must expire after session end.
	}
	else
	{
		setcookie($cookiename, "", time()-$session_alive_time);
		dblog(3, $sID.":::".$_SERVER['HTTP_REFERER']);
	}
}


// update current session so it will not be deleted during the clean-up.
if(getcurrentuserid())
{
    query("UPDATE session SET logUNIX = '".escape_string(time())."', userURL = '".escape_string($URL)."' WHERE userID = '".escape_string(getcurrentuserid())."' AND IP = '".escape_string($userIP)."'");
}


// clean database for abandoned session
$remove_time = time()-$session_alive_time;


query("DELETE FROM session WHERE logUNIX < '".escape_string($remove_time)."'");


// getuserid(sID) returns the user ID from a session
function getuserid($sid)
{
	$dbs = query("SELECT userID FROM session WHERE sid = '".escape_string($sid)."'"); // search for session ID table "session" in the DB.

	if (($dbs == null) || (!num($dbs))) // if the user is not logged in, or found in the DB, for various reasons,
	{
		return 0;   // return 0.
	}
	$row = fetch_array($dbs); // get first row (should be the only row returned)

	if (!empty($row[0]))
	{
		return $row[0]; // return userID
	}
	else
	{
		return 1;
	}
}


function getuseridx($nick, $password)
{
	$password = crypt_pwd($password);

	$dbs = query("SELECT ID, password FROM users WHERE nick LIKE '".escape_string($nick)."'");

	$row = fetch_array($dbs);

	if($row[1] != $password)
	{
		return -2;
	}

	return $row[0];
}


// getcurrentuserid() returns the user ID of the current processing user.
function getcurrentuserid()
{
	$uid = getuserid(session_id()); // call getuserid and pass the current session ID.
	if (($uid == NULL) || ($uid == FALSE))
	{
		$uid = 1;
	}
	return $uid;
}

/* No longer used
function getuserrank()
// TODO: ACL!
{
	$user = getcurrentuserid();

	$query = query("SELECT isCrew FROM users WHERE ID = '".escape_string($user)."'");

	$row = fetch_array($query);

	return $row[0];
}
*/

// log_in(nick, password) retrieves the user ID from nick and logs the user in the database.

function log_in($nick, $password)

{

	// Returns 0  if the user is already logged in.

	// Returns -1 if the password does not match.

	// Returns -2 if the user has not verified yet

	// Returns positive value if the login was successful

	if(getcurrentuserid() != 1)  // this user is already logged in.
	{
		return 0;
	}

	$password = crypt_pwd($password); // hash the password

	$dbs = query("SELECT ID, password, verified FROM users WHERE nick LIKE '".escape_string($nick)."'");

	$row = fetch_array($dbs);

	if ($password != $row[1])
	{
		return -1;
	}

	if($row[2] != 0)
	{
		return -2;
	}

	$uid = $row[0]; // get user id

	$sid = session_id(); // get session ID

	$dbs = query("UPDATE session SET userID = '".escape_string($uid)."' WHERE sID = '".escape_string($sid)."'"); // update database
	query("UPDATE users SET lastLoggedIn = '".escape_string(time())."' WHERE ID = '".escape_string($uid)."'");

	dblog(4, $sid."::".$uid);

	return 1;
}


// log_out() logs out the current user in session.
function log_out()
{
	if(!getcurrentuserid()) // check if the user is actually logged in
	{
		return 0;
	}
	dblog(5, session_id());

	// Update session
	query("UPDATE session SET userID = 1 WHERE sID = '".escape_string(session_id())."'");

	//setcookie("sID", "");
	return 1;
}

?>
