<?php

require_once "config.php";


function db_connect() {

    global $sql_host;
    global $sql_user;
    global $sql_pass;
    global $sql_db;
    global $is_db_connected;

    $connect = mysql_connect($sql_host, $sql_user, $sql_pass) or die("Connect: ".mysql_error());
    $db = mysql_select_db($sql_db) or die("DB_SELECT: ".mysql_error());

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
    query("INSERT INTO logs SET userIP = '$IP', userID = $userID, logType = $type, logWhat = '$dowhat', oldLog = '$logOld', logUNIX = ".time());
    return 1;
}

function verify($nick, $email, $password, $firstname, $lastname)

{
    if($nick == "") // check nick.
        return 8;
    elseif($email == "") // check there is an e-mail
        return 9;
    elseif(strlen($password) < $min_pass_length) // check the length of the password.
        return 10;

    elseif(!(strchr($email, "@") && strchr($email, "."))) // check if the email contains at least one @ and at least one dot.
        return 11;
    elseif((!strchr($firstname, " ")) || (!strchr($lastname, " ")))
	 	return 12;

    else    // if we find no of the above errors, compare user name with the database.
    {
        $dbs = mysql_query("SELECT nick FROM users WHERE nick LIKE '$nick'")
            or die("Could not complete task : ".mysql_error());

        if((!$dbs) || (mysql_num_rows($dbs) == 0))
            return "allowed"; // let the script pass
        else
            return 13;
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
	$query = mysql_query("SELECT * FROM users WHERE ID = $ID") or die(mysql_error());
	$row = mysql_fetch_object($query);

	return $row->nick;
}
function random_quote() {
	global $userand;
	global $rand_text;
	$max = mysql_query("SELECT * FROM random ORDER BY ID DESC LIMIT 0,1");
	$maxran = mysql_fetch_object($max);
	if(!$userand) {
		return FALSE;
		break;
	} elseif(mysql_num_rows($max) == 0) {
		return FALSE;
		break;
	} else {
		while(!$random_text) {
			$random_number = rand(1,$maxran->ID);
			$query = mysql_query("SELECT * FROM random WHERE ID = $random_number") or die(mysql_error());
			$row = mysql_fetch_object($query);
			$random_text = $row->text;
		}
	echo $rand_text.stripslashes($random_text)."<br>";
	}

}

function query($query) {
$q = mysql_query($query) or nicedie("Error with query: $query, error returned: ".mysql_error());
return $q;
}

function fetch($q) {
	$r = mysql_fetch_object($q);
	return $r;
}

function num($q) {
	return mysql_num_rows($q);
}

function user_style() {
	$q = mysql_query("SELECT * FROM users WHERE ID = ".getcurrentuserid());
	$r = mysql_fetch_object($q);

	$design = $r->userDesign;

	if(!isset($design)) $design = config("default_style");
	return $design;
}

function config($config, $value = "NOTSET") {

	$query = mysql_query("SELECT * FROM config WHERE config = '$config'") or die(mysql_error());
	$num = mysql_num_rows($query);
	if($value == "NOTSET") {
		$object = mysql_fetch_object($query);

		if($num == 0) return FALSE;
		elseif($object->value == 0) return FALSE;
		else {
			return $object->value;
		}

	} else {
		if($num == 0) {
			mysql_query("INSERT INTO config SET config = '$config', value = '$value'") or die(mysql_error());
		//	echo "INSERTET";
		} else {
			mysql_query("UPDATE config SET value = '$value' WHERE config = '$config'") or die(mysql_error());
		//	echo "Oppdatert";
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
	$q = query("SELECT * FROM users WHERE ID = $ID");
	$r = fetch($q);
	if($r->allowPublic == 0) echo "<a href=index.php?inc=profile&uid=$ID>$r->nick</a>";
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
	$q = query("SELECT * FROM Clan WHERE ID = $clanID");
	$r = fetch($q);
	if($rank > 0) return 1;
	elseif($r->moderator == $userID) return 1;
	else return 0;
}

function acl_access($acl, $userID = NULL) {
	if($userID == NULL) $userID = getcurrentuserid();
	$q = query("SELECT * FROM users WHERE ID = $userID");
	$r = fetch($q);
	$myGroup = $r->myGroup;
	$root = query("SELECT * FROM acls WHERE groupID = $myGroup AND access LIKE 'root' AND value = 1");
	$sel = query("SELECT * FROM acls WHERE groupID = $myGroup AND access LIKE '$acl' AND value = 1");
	if(num($root) == 1) return 1;
	elseif(num($sel) == 1) return 1;
	else return 0;
}

function reverse_acl($acl) {
	$q = query("SELECT * FROM acls WHERE (access = '$acl' AND value = 1) OR (access = 'root' AND value = 1)");
	while($r = fetch($q)) {
		if(empty($query2)) $query2 = "WHERE myGroup = $r->groupID";
		else $query2 .= " OR myGroup = $r->groupID";
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

	$q = query("SELECT groups.groupname AS 'groupname' from users, groups WHERE users.ID='".$uid."' AND users.myGroup=groups.ID");
	$r = fetch($q);
   return $r->groupname;
}

function nicedie ($reason = "Something bad happened. Please contact the administrators.")
{
	echo $reason;
   include $base_path."style/bottom.php";
	die();
}

function lang($string = "I must remember to put something here", $module = "default", $extra = "No extra info") {
	global $language;

	$q = query("SELECT * FROM lang WHERE string = '$string' AND language = '$language' AND module = '$module'");
	$num = num($q);
	if($num == 0) {
		/* The string does not exist in the database, add it */
		query("INSERT INTO lang SET string = '$string', language = '$language', module = '$module', extra = '$extra'");
		return $string;
	} // End not exists

	elseif($num >= 2) nicedie("There is an error in the lang()-function, more than one existance of string: '".$string."' in module: '".$module."' for language: '".$language."'. FIX IT!");

	else {
		$r = fetch($q);
		if(empty($r->translated) || !isset($r->translated)) return $string;
		else return $r->translated;
	}


}

?>
