<?php

require_once "config.php";


function db_connect() {

    global $sql_host;
    global $sql_user;
    global $sql_pass;
    global $sql_db;
    global $is_db_connected;

    $connect = mysql_connect($sql_host, $sql_user, $sql_pass) or nicedie("Connect: ".mysql_error());
    $db = mysql_select_db($sql_db) or nicedie("DB_SELECT: ".mysql_error());

    $is_db_connected = 1;
    return;
}





function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}

function createcifer()
{
    $tmpc = "000000";
    for($i=0;$i<6;$i++)
    {
        $c = rand() * 9;
        $tmpc[$i] = "$c";
    }
    return (int)$tmpc;
}

function crypt_pwd($password) {
    return md5($password);
}

function dblog($type = 1,$logNew = "NOTHING LOGGED", $logOld = NULL) {
    $IP = $_SERVER['REMOTE_ADDR'];
    $userID = getcurrentuserid();
    $dowhat = stripslashes($logNew);
    query("INSERT INTO logs SET userIP = '".mysql_escape_string($IP)."', userID = '".mysql_escape_string($userID)."', logType = '".mysql_escape_string($type)."', logWhat = '".mysql_escape_string($dowhat)."', oldLog = '".mysql_escape_string($logOld)."', logUNIX = ".mysql_escape_string(time()));
    return 1;
}

function verify($mode="register", $userid, $nick, $firstname, $lastname, $email=NULL, $password=NULL)
{
    if($nick == "") // check nick.
        return 8;

    elseif (($mode == "register") && ($email == "")) // check there is an e-mail
        return 9;
    
	 elseif(($mode == "register") && (strlen($password) < $min_pass_length)) // check the length of the password.
        return 10;

    elseif(($mode = "register") && (!(strchr($email, "@")) && (strchr($email, ".")))) // check if the email contains at least one @ and at least one dot.
        return 11;

	elseif ((!isset($lastname)) || (!isset($firstname)))
		return 12;

	elseif (($firstname == "") || ($lastname == ""))
		return 12;
		
	elseif ((preg_match('/[[:digit:]]/', $firstname)) || (preg_match('/[[:digit:]]/', $lastname)))
	 	return 12;

	else		// if we find no of the above errors, compare user name with the database.
	 {
			$query = query ("SELECT ID FROM users WHERE nick = '".mysql_escape_string($nick)."'");
			$fetch = fetch ($query);
			$num = num ($query);
			
			if ($num == 0)
			{
				return "allowed";
			}
			elseif ($fetch->ID == $userid)
			{
				return "allowed";
			}
			else
			{
            return 13;
			}
    }

}


function refresh($url="index.php",$time="2") {
	//if(!isset($url)) $url = "index.php";
	//if(!isset($time)) $time = "2";
	echo "<meta http-equiv=refresh content=\"$time; url=$url\">";
	return 1;
}

function forumText($text) {
	$text = stripslashes($text);
	// We probably want to specialchar the text before we create <br>...
	$text = htmlspecialchars($text);
	$text = nl2br($text);
	return $text;
}

function IDtonick($ID) {
	$query = query("SELECT * FROM users WHERE ID = $ID");
	$row = fetch($query);

	return $row->nick;
}

function random_quote() {
	global $userand;
	global $rand_text;
	$max = query("SELECT * FROM random ORDER BY ID DESC LIMIT 0,1");
	$maxran = fetch($max);
	if(!$userand) {
		return FALSE;
		break;
	} elseif(num($max) == 0) {
		return FALSE;
		break;
	} else {
		while(!$random_text) {
			$random_number = rand(1,$maxran->ID);
			$query = query("SELECT * FROM random WHERE ID = '".mysql_escape_string($random_number)."'");
			$row = fetch($query);
			$random_text = $row->text;
		}
	echo $rand_text.stripslashes($random_text)."<br>";
	}

}

function query($query)
{
	$q = mysql_query($query) or nicedie("Error with query: $query, error returned: ".mysql_error());
	return $q;
}

function fetch($q) {
	$r = mysql_fetch_object($q);
	return $r;
}

function fetch_array($q) {
	$r = mysql_fetch_row($q);
	return $r;
}

function num($q) {
	return mysql_num_rows($q);
}

function user_style() {
	$query = query("SELECT * FROM users WHERE ID = '".mysql_escape_string(getcurrentuserid())."'");
	$row = fetch($query);

	$design = $row->userDesign;

	if(!isset($design))
	{
		$design = config("default_style");
	}
	return $design;
}

function config($config, $value = "NOTSET") {

	$query = query("SELECT * FROM config WHERE config = '$config'");
	$num = num($query);
	if($value == "NOTSET") {
		$object = fetch($query);

		if($num == 0) return FALSE;
		elseif($object->value == 0) return FALSE;
		else {
			return $object->value;
		}

	} else {
		if($num == 0) {
			query("INSERT INTO config SET config = '".mysql_escape_string($config)."', value = '".mysql_escape_string($value)."'");
		} else {
			query("UPDATE config SET value = '".mysql_escape_string($value)."' WHERE config = '".mysql_escape_string($config)."'");
		}

	}

}

function display_text($text) {
	$text = stripslashes($text);
	$text = nl2br($text);
	return $text;

}

function convert_seatmap($map) {
        $len = strlen($map);
        $s = NULL;
        $l = 0;
        for($i=0;$i<$len;$i++) {
                if($map[$i] == "\n") $l++;
                else $s[$l][] = $map[$i];
        }
        return $s;
}

function display_nick($ID) {
	$q = query("SELECT * FROM users WHERE ID = '".mysql_escape_string($ID)."'");
	$r = fetch($q);
	if($r->allowPublic == 0)
	{
		echo "<a href=index.php?inc=profile&uid=$ID>$r->nick</a>";
	}
	else echo $r->nick;
}

function profile_table($profileLeft, $profileRight) {

	echo "<tr><td class=profileLeft width=25%>$profileLeft</td><td class=profileRight>";

	echo $profileRight;

	echo "</td></tr>\n\n";

}

function convert_timestamp($timestamp) {
	return date("d/m/y H:i:s", $timestamp);
}

function can_register_clan() {
	return TRUE;
}

function mayEditClan($clanID) {
	$userID = getcurrentuserid();
	$rank = getuserrank();
	$q = query("SELECT * FROM Clan WHERE ID = '".mysql_escape_string($clanID)."'");
	$r = fetch($q);
	if($rank > 0)
	{
		return 1;
	}
	elseif($r->moderator == $userID)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function acl_access($acl, $userID = NULL) {
	if($userID == NULL) $userID = getcurrentuserid();
	$q = query("SELECT * FROM users WHERE ID = '".mysql_escape_string($userID)."'");
	$r = fetch($q);
	$myGroup = $r->myGroup;
	$root = query("SELECT * FROM acls WHERE groupID = '".mysql_escape_string($myGroup)."' AND access LIKE 'root' AND value = 1");
	$sel = query("SELECT * FROM acls WHERE groupID = '".mysql_escape_string($myGroup)."' AND access LIKE '".mysql_escape_string($acl)."' AND value = 1");
	if(num($root) == 1)
	{
		return 1;
	}
	elseif(num($sel) == 1)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function reverse_acl($acl) {
	$q = query("SELECT * FROM acls WHERE (access = '".mysql_escape_string($acl)."' AND value = 1) OR (access = 'root' AND value = 1)");
	while($r = fetch($q))
	{
		if(empty($query2))
		{
			$query2 = "WHERE myGroup = $r->groupID";
		}
		else
		{
			$query2 .= " OR myGroup = $r->groupID";
		}
	}
	$q2 = query("SELECT * FROM users $query2");
	return $q2;
}

function resolve_groupname ($uid)
{
	if (!isset($uid))
	{
		$uid = getcurrentuserid();
	}

	$q = query("SELECT groups.groupname AS 'groupname' from users, groups WHERE users.ID='".mysql_escape_string($uid)."' AND users.myGroup=groups.ID");
	$r = fetch($q);
   return $r->groupname;
}

function nicedie ($reason = "Something bad happened. Please contact the administrators.")
{
	require_once ($base_path."style/top.php");
	echo $reason;
   require_once ($base_path."style/bottom.php");
	die();
}

function lang($string = "I must remember to put something here", $module = "default", $extra = "No extra info") {
	global $language;

	$q = query("SELECT * FROM lang WHERE string = '".mysql_escape_string($string)."' AND language = '".mysql_escape_string($language)."' AND module = '".mysql_escape_string($module)."'");
	$num = num($q);
	if($num == 0)
	{
		/* The string does not exist in the database, add it */
		query("INSERT INTO lang SET string = '".mysql_escape_string($string)."', language = '".mysql_escape_string($language)."', module = '".mysql_escape_string($module)."', extra = '".mysql_escape_string($extra)."'");
		return $string;
	} // End not exists

	elseif($num >= 2)
	{
		nicedie("There is an error in the lang()-function, more than one existance of string: '".$string."' in module: '".$module."' for language: '".$language."'. FIX IT!");
	}
	else
	{
		$r = fetch($q);
		if(empty($r->translated) || !isset($r->translated)) return $string;
		else return $r->translated;
	}


}

?>
