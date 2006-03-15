<?PHp

require_once ("config.php");

function db_connect()
{
    global $sql_server;
    global $sql_user;
    global $sql_pass;
    global $sql_db;
    global $is_db_connected;

    $connect = mysql_connect($sql_host, $sql_user, $sql_pass) or nicedie("Connect: ".mysql_error());
    $db = mysql_select_db($sql_db) or nicedie("DB_SELECT: ".mysql_error());

    $is_db_connected = 1;
    return;
}

function make_seed()
{
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

function crypt_pwd($password)
{
    return md5($password);
}

function dblog($type = 1,$logNew = "NOTHING LOGGED", $logOld = NULL)
{
    $IP = $_SERVER['REMOTE_ADDR'];
    $userID = getcurrentuserid();
    $dowhat = stripslashes($logNew);
    $server = $_SERVER['server_name'].$_SERVER['REQUEST_URI'];
    query("INSERT INTO logs SET userIP = '".escape_string($IP)."', userID = '".escape_string($userID)."', logType = '".escape_string($type)."', logWhat = '".escape_string($dowhat)."', oldLog = '".escape_string($logOld)."', URL = '$server', logUNIX = ".escape_string(time()));
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
			$query = query ("SELECT ID FROM users WHERE nick = '".escape_string($nick)."'");
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


function refresh($url="index.php",$time="2")
{
	//if(!isset($url)) $url = "index.php";
	//if(!isset($time)) $time = "2";
	echo "<meta http-equiv=refresh content=\"$time; url=$url\">";
	return 1;
}

function forumText($text)
{
	$text = stripslashes($text);
	// We probably want to specialchar the text before we create <br>...
	$text = htmlspecialchars($text);
	$text = nl2br($text);
	return $text;
}

function IDtonick($ID)
{
	$query = query("SELECT nick FROM users WHERE ID = '".escape_string($ID)."'");
	$row = fetch($query);

	return $row->nick;
}

function random_quote()
{
	global $userand;
	global $rand_text;
	$max = query("SELECT * FROM random ORDER BY ID DESC LIMIT 0,1");
	$maxran = fetch($max);
	if (!$userand)
	{
		return FALSE;
		break;
	}
	elseif (num($max) == 0)
	{
		return FALSE;
		break;
	}
	else
	{
		while(!$random_text)
		{
			$random_number = rand(1,$maxran->ID);
			$query = query("SELECT * FROM random WHERE ID = '".escape_string($random_number)."'");
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

function fetch($q)
{
	$r = mysql_fetch_object($q);
	return $r;
}

function fetch_array($q)
{
	$r = mysql_fetch_row($q);
	return $r;
}

function escape_string($var)
{
	$var = mysql_real_escape_string($var);
	return $var;
}

function num ($q)
{
	return mysql_num_rows ($q);
}

function num_fields ($q)
{
	return mysql_num_fields ($q);
}

function user_style()
{
	$query = query("SELECT * FROM users WHERE ID = '".escape_string(getcurrentuserid())."'");
	$row = fetch($query);

	$design = $row->userDesign;

	if(empty($design))
	{
		$design = "default";
	}
	return $design;
}

function config($config, $value = "NOTSET")
{
	$query = query("SELECT * FROM config WHERE config = '".escape_string($config)."'");
	$num = num($query);
	if ($value == "NOTSET")
	{
		$object = fetch($query);

		if ($num == 0)
		{
			return FALSE;
		}

		elseif ($object->value == 0)
		{
			return FALSE;
		}
		else
		{
			return $object->value;
		}
	}
	else
	{
		if ($num == 0)
		{
			query("INSERT INTO config SET config = '".escape_string($config)."', value = '".escape_string($value)."'");
		}
		else
		{
			query("UPDATE config SET value = '".escape_string($value)."' WHERE config = '".escape_string($config)."'");
		}
	}

}

function display_text($text)
{
	$text = stripslashes($text);
	$text = nl2br($text);
	return $text;
}

function convert_seatmap($map)
{
	$len = strlen($map);
	$s = NULL;
	$l = 0;
	for ($i=0;$i<$len;$i++)
	{
		if ($map[$i] == "\n") $l++;
		else
		{
			$s[$l][] = $map[$i];
		}
	}
	return $s;
}

function display_nick($ID)
{
	$q = query("SELECT * FROM users WHERE ID = '".escape_string($ID)."'");
	$r = fetch($q);
	if ($r->allowPublic == 0)
	{
		echo "<a href=index.php?inc=profile&uid=$ID>$r->nick</a>";
	}
	else
	{
		echo $r->nick;
	}
}

function profile_table($profileLeft, $profileRight)
{
	echo "<tr><td class=profileLeft width=25%>$profileLeft</td><td class=profileRight>";

	echo $profileRight;

	echo "</td></tr>\n\n";

}

function osgl_table($left, $right) {

	echo "<tr><td class=tbl_left>$left</td><td class=tbl_right>$right</td></tr>\n\n";



}

function convert_timestamp($timestamp)
{
	return date("d/m/y H:i:s", $timestamp);
}

function can_register_clan()
// FIXME: What the heck does this do?
{
	return TRUE;
}

function mayEditClan($clanID)
{
	$userID = getcurrentuserid();
#	$rank = getuserrank(); // No longer used, just quick and dirty hack to avoid errors
	$q = query("SELECT * FROM Clan WHERE ID = '".escape_string($clanID)."'");
	$r = fetch($q);
#	if ($rank > 0)
#	{
#		return 1;
#	}
#	else
	if ($r->moderator == $userID)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function acl_access($acl, $userID = NULL)
{
	if ($userID == NULL)
	{
		$userID = getcurrentuserid();
	}
	$q = query("SELECT * FROM users WHERE ID = '".escape_string($userID)."'");
	$r = fetch($q);
	$myGroup = $r->myGroup;
	$root = query("SELECT * FROM acls WHERE groupID = '".escape_string($myGroup)."' AND access LIKE 'root' AND value = 1");
	$sel = query("SELECT * FROM acls WHERE groupID = '".escape_string($myGroup)."' AND access LIKE '".escape_string($acl)."' AND value = 1");
	if (num($root) == 1)
	{
		return 1;
	}
	elseif (num($sel) == 1)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function reverse_acl($acl)
{
	$q = query("SELECT * FROM acls WHERE (access = '".escape_string($acl)."' AND value = 1) OR (access = 'root' AND value = 1)");
	while ($r = fetch($q))
	{
		if (empty($query2))
		{
			$query2 = "WHERE myGroup = '".escape_string($r->groupID)."'";
		}
		else
		{
			$query2 .= " OR myGroup = '".escape_string($r->groupID)."'";
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

	$q = query("SELECT groups.groupname AS 'groupname' from users, groups WHERE users.ID='".escape_string($uid)."' AND users.myGroup=groups.ID");
	$r = fetch($q);
   return $r->groupname;
}

function nicedie ($reason = "Something bad happened. Please contact the administrators.", $logreason=false)
{
	require_once ($base_path."style/top.php");
	echo $reason;

	if (!$logreason)
	{
		$logreason = $reason;
	}
	dblog(15,$logreason);
	
	require_once ($base_path."style/bottom.php");
	die();
}

function lang($string = "I must remember to put something here", $module = "default", $extra = "No extra info")
{
	global $language;

	$q = query("SELECT * FROM lang WHERE string = '".escape_string($string)."' AND language = '".escape_string($language)."' AND module = '".escape_string($module)."'");
	$num = num($q);
	if ($num == 0)
	{
		/* The string does not exist in the database, add it */
		query("INSERT INTO lang SET string = '".escape_string($string)."', language = '".escape_string($language)."', module = '".escape_string($module)."', extra = '".escape_string($extra)."'");
		return $string;
	} // End not exists

	elseif ($num >= 2)
	{
		nicedie("There is an error in the lang()-function, more than one existance of string: '".$string."' in module: '".$module."' for language: '".$language."'. FIX IT!");
	}
	else
	{
		$r = fetch($q);
		if ((empty($r->translated)) || (!isset($r->translated)))
		{
			return $string;
		}
		else
		{
			return $r->translated;
		}
	}
}

function nicedielang ($string, $module, $desc="")
{
	$reason = lang ($string, $module, $desc);
	nicedie ($reason);
}

function showlog ($num, $userid=false)
{

	global $logtype;

	if ($num == 'all')
	{
		nicedie("Heh, not implemented yet!");
	}
	elseif ((is_numeric($num)) && (!$userid))
	{
		$query = sprintf ("SELECT * FROM logs ORDER BY ID DESC LIMIT %s", $num);
		$result = query ($query);
		while ($log = fetch ($result))
		{
			$time = date ('d.m.y H:i:s', $log->logUNIX);
			$nick = IDtonick ($log->userID);
			if (isset($logtype[$log->logType]))
			{
				$action = $logtype[$log->logType];
			}
			else
			{
				$action = $log->logType;
			}
			echo "<tr><td>$nick</td><td>$time</td><td>$action</td><td>$log->logWhat</td><td>$log->userIP</td></tr>\n";
		}
	}
	elseif ((is_numeric($num)) && (is_numeric($userid)))
	{
		$query = sprintf ("SELECT * FROM logs WHERE userID=%s ORDER BY ID DESC LIMIT %s", $userid, 1);
		$result = query ($query);
		while ($log = fetch ($result))
		{
			$time = date ('d.m.y H:i:s', $log->logUNIX);
			$nick = IDtonick ($log->userID);
			if (isset($logtype[$log->logType]))
			{
				$action = $logtype[$log->logType];
			}
			else
			{
				$action = $log->logType;
			}
			echo "<tr><td>$nick</td><td>$time</td><td>$action</td><td>$log->logWhat</td><td>$log->userIP</td></tr>\n";
		}
	}
	
}

function seatInfo($id) {
	
	$query = "SELECT * FROM users WHERE id LIKE '" . $id . "'";
	$result = mysql_query($query) or
	          nicedie(mysql_error());
	
	$num = mysql_num_rows($result);
	
	if($num >= 1) {
		
		$i = mysql_fetch_array($result);
		
		$seatX = $i['seatX'];
		$seatY = $i['seatY'];
		
		$row     	= 0;
		$seatNum 	= 0;
		$oldSeatNum = 1;
		
		if($seatX == "-1" || $seatY == "-1") {
			
			return "Ingen Plass";
			
		} else {
	
			require_once $base_path . "seatformats.php";
			
			for( $i = 0; $i < $height; $i++ ) {
				
				$k = strlen($myfile[$i]);
				
				for( $j = 0; $j < $k; $j++ ) {
					//$j = x
					//$i = y
	
					$c = $myfile[$i][$j];	// find out what the fuck this character is
	
					switch($c) {
						// user
						case "d":
						$cur = 1;
						break;
						
						// crew
						case "c":
						$cur = 2;
						break;
					}
					
					/*
					$x = $j * $addwidth;
					$y = $i * $yscale;
					*/
					
					if($cur == 1) {
					
						$seatNum++;
						$cur = 0;
					
					}
					
					if($j == $seatX && $i == $seatY) {
						
						return "Rad: " . $row . "\n Sete: " . $seatNum;
						
					}

				}
				
				if($seatNum != $oldSeatNum) {
				
					$row++;
					
					$oldSeatNum = $seatNum;
					
				}
										
			}
			
		}
	
	}

}
		


?>
