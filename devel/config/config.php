<?php

/*
 * OSGlobeLAN configuration file
 *
 * http://www.sourceforge.net/projects/osglobelan
 *
 * Read docs/README first.
 */


/*
 * base_path
 * 
 * The path to the installation of OSGlobeLAN.
 * Default is the document root of the webserver config or virtualhost.
 *
 */
//$base_path = "/var/www/devel/";
$base_path = $_SERVER['DOCUMENT_ROOT']."/";


/*
 * sitetitle
 *
 * Title on all pages.
 */
$sitetitle = "OSGlobeLAN";


/*
 * sql_server
 *
 * Hostname or IP-address to the MySQL-server.
 */
$sql_server = "localhost";


/*
 * sql_user
 *
 * Username for the MySQL-server.
 */
$sql_user = "devel";


/*
 * sql_password
 *
 * Password for the MySQL-server.
 */
$sql_pass = "devel";


/*
 * sql_db
 *
 * Name of the database to use.
 */
$sql_db = "devel";


/*
 * session_alive_time
 *
 * How long does a session last?
 */
$session_alive_time = "3600";


/*
 * cookiename
 *
 * Name of the cookies.
 */
//$cookiename = "Maryland_Cookies";
$cookiename = "OSGlobeLAN";

/*
 * language
 *
 * Systemwide language to use.
 * Current choices is "english" and "norwegian".
 */
 $language = "english";


 /*
  * usenews
  *
  * How many newsitems to show on front page.
  * Set to FALSE to disable news on the front page.
  */
$usenews = 3;


/*
 * userand
 *
 * Enable the random-quote-system.
 * Use random_quote() in your design to put it in your design.
 * Set to TRUE to enable.
 */
$userand = FALSE;


/*
 * rand_text
 *
 * Text to put before the quote in random_quote().
 */
$rand_text = "Tilfeldig: ";


/*
 * usestats
 *
 * Enable use of the statistics.
 * Set to TRUE to enable.
 */
$usestats = FALSE;


/*
 * seatsize
 *
 * [FIXME]
 */
$seatsize = 10;


/*
 * min_pass_length
 *
 * Minimum length of passwords.
 * Should be more that five (5).
 */
$min_pass_length = 5;


/*
 * admin['info']['mail']
 *
 * Emailaddress to OSGlobeLAN administrator.
 * Default is "osglobelan@<server>".
 */
$admin['info']['admin'] = "osglobelan@".$_SERVER['SERVER_NAME'];


/*
 * admin['info]['nick']
 * 
 * Nickname of OSGlobeLAN administrator.
 */
$admin['info']['nick'] = "OSGlobeLAN";


/*
 * admin['info']['name']
 *
 * Name of OSGlobeLAN administrator.
 */
$admin['info']['name'] = "OSGlobeLAN Administrator";



/*
 * Do not edit below this!
 */
global $base_path;
$lang_file = "$base_path"."lang/".$language.".php";

$lang_inc = require_once $lang_file;
if(!$lang_inc) die("Could not find language file");

require_once "functions.php";
require_once "session.php";
$styles = NULL;
$style_folders = $base_path."style/";
$dir = opendir($style_folders);
while($read = readdir($dir)) {
   if($read == "." || $read == ".." || !is_dir($style_folders.$read));
   else {
      $styles[] = $read;
   }

}

if($usestats) require_once 'stats_every.php';
#if($sql_mode == "upgrade") include_once $base_path.'sql_upgrade.php';
?>
