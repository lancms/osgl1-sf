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
$base_bath = $_SERVER['DOCUMENT_ROOT']."/";


/*
 * sitetitle
 *
 * Title on all pages.
 */
$sitetitle = "OSGlobeLAN";


/*
 * devel_version
 *
 * Sets current version of OSGlobeLAN.
 */
$devel_version = "CVS";


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
 * usemap
 *
 * Seatmap to use.
 */
$usemap = $base_path."config/defaultmap.txt";


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
 * webshop_mail_to
 *
 * Who should recieve webshop-orders.
 * Default is "osglobelan@<server>".
 */
$webshop_mail_to = "osglobelan@".$_SERVER['SERVER_NAME'];


/*
 * webshop_display_infoline
 *
 * Information to print before sending the webshop-order.
 */
$webshop_display_infoline = "
									Vennligst vær oppmerksom på:
										<br>- Å ha penger tilgjengelig når kioskpersonalet kommer.
										<br>- At steking av pizza o.l. kan ta tid.
										<br>- Kioskpersonalet tar kontakt via epost dersom de har spørsmål. Sjekk derfor eposten din ofte.
									";



/*
 * Seatsystem
 *
 * Do not edit unless you know what you're doing.
 */
$seatsign[0]['name'] = "Wall";
$seatsign[0]['color'] = "black";
$seatsign[0]['level'] = -2;
$seatsign[0]['sign'] = "*";

$seatsign[1]['sign'] = "d";
$seatsign[1]['name'] = "User";
$seatsign[1]['level'] = 0;
$seatsign[1]['color'] = "red";

$seatsign[2]['sign'] = "c";
$seatsign[2]['name'] = "Crew";
$seatsign[2]['level'] = 1;
$seatsign[2]['color'] = "green";

$seatsign[3]['sign'] = "v";
$seatsign[3]['name'] = "VIP";
$seatsign[3]['level'] = -2;
$seatsign[3]['color'] = "grey";

$seatsign[4]['sign'] = "r";
$seatsign[4]['name'] = "Reservert";
$seatsign[4]['level'] = -2;
$seatsign[4]['color'] = "orange";

$seatsign[5]['sign'] = "-";
$seatsign[5]['name'] = "Open";
$seatsign[5]['color'] = "white";
$seatsign[5]['level'] = -2;

$seatsign[6]['sign'] = "D";
$seatsign[6]['name'] = "Door";
$seatsign[6]['color'] = "brown";
$seatsign[6]['level'] = -2;

$seatsign[7]['sign'] = "K";
$seatsign[7]['name'] = "Kiosk";
$seatsign[7]['color'] = "yellow";
$seatsign[7]['level'] = -2;

$seatsign[8]['sign'] = "a";
$seatsign[8]['name'] = "Admin";
$seatsign[8]['color'] = "orange";
$seatsign[8]['level'] = 2;

$seatsign[9]['sign'] = "+";
$seatsign[9]['name'] = "Extra";
$seatsign[9]['color'] = "red";
$seatsign[9]['level'] = -2;


/*
 * Do not touch this.
 */
for($i=0;$i<count($seatsign);$i++) {
        $sign = $seatsign[$i]['sign'];

        $seatsign_number[$sign] = $i;
}



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
