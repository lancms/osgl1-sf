<?php

require_once "config.php";

$is_db_connected = 0;


function db_connect() {

    if($is_db_connected) // Just in case we are already connected.
        return;

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

// not currently used, but we will create a log of everything that happens....
function log_user($dowhat) {
    db_connect();
    $IP = $REMOTE_ADDR;
    $dowhat = stripslashes($dowhat);
    mysql_query("INSERT INTO log SET IP = '$IP', didWhat = '$dowhat'");
    return 1;
}

function verify($nick, $email, $password, $name)

{
    if($nick == "") // check nick.
        return 8;
    elseif($email == "") // check there is an e-mail
        return 9;
    elseif(strlen($password) < $min_pass_length) // check the length of the password.
        return 10;

    elseif(!(strchr($email, "@") && strchr($email, "."))) // check if the email contains at least one @ and at least one dot.
        return 11;
    elseif(!strchr($name, " "))
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

function mail_body($random) {
    return "Velkommen som bruker p� GlobeLAN DEVEL!\n\r
    Du har enten endret e-post, eller laget en ny bruker, s� venligst logg inn med ditt brukernavn og passord, og fyll inn: ".$random." som ditt verifiseringsnummer!\r\n\r\n
    Tusen takk\r\n
    Crewet";
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
$q = mysql_query($query) or die("Error with query: $query, error returned: ".mysql_error());
return $q;
}

function user_style() {
	$q = mysql_query("SELECT * FROM users WHERE ID = ".getcurrentuserid());
	$r = mysql_fetch_object($q);

	$design = $r->userDesign;

	if(!isset($design)) $design = "default";

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
?>
