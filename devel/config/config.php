<?php

/* This one will define where the root-path of all your files are.... */
$base_path = "/var/www/devel/";

/* Site-title will show up as the <title></title> text on all the pages.... */
$sitetitle = "GlobeLAN 4,5 DEVEL";
$devel_version = "0.3 Alpha";

/* config for the MySQL server! */
$sql_server = "localhost";
$sql_user = "devel";
$sql_pass = "devel";
$sql_db = "devel";

/* Setting this to upgrade will automatically upgrade the database (hopefully) when an admin is logged in.... */
/* Should probably be disabled when the upgrade is completed */
#$sql_mode = "upgrade";

/* This file contains the $sql_* variables shown above */
#include_once '/home/lak/inc_devel.php';

/* config for database handling */
$session_alive_time = 3600;      // How long should a session stay alive? 3600 (one hour) is default.
$cookiename = "GL-D3V3L";
/* The language-files to use.... If your language is not in the lang-folder, make it, translate it, and send it to the creators... */
$language = "norwegian";

/* Which systems to use... */


$usenews = 3;			// Number of news-items to show on first-page *FALSE to disable*
$userand = TRUE;		// Enable random-system, TRUE to give random from the table random on every page-view... random_quote() to put it in on the page.... (default used in bottom.php)

$usestats = TRUE;

$rand_text = "Tilfeldig: ";

$usemap = $base_path."config/defaultmap.txt";

$seatsize = 10;

/* User information and verification */

$min_pass_length = 5;           // (RECOMMENDED > 5)


$admin[info][mail] = "laaknor@globelan.net";
$admin[info][nick] = "Laaknor";
$admin[info][name] = "Lars Åge Kamfjord";


/* What person should recieve webshop-requests */
$webshop_mail_to = "laaknor@globelan.net";
/* What do you want to have displayed before the request is sent to the canteen-person? */
$webshop_display_infoline = "Vennligst vær oppmerksom på:
<br>- Å ha penger tilgjengelig når en fra kiosk-personalet kommer
<br>- At steking av pizza ol. kan ta tid.
<br>- Kioskpersonalet vil ta kontakt med deg via epost dersom de lurer på noe. Ha derfor e-post klienten din tilgjengelig.";

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


for($i=0;$i<count($seatsign);$i++) {
        $sign = $seatsign[$i]['sign'];

        $seatsign_number[$sign] = $i;
}



######################################################
##
## NO EDIT!!!
##
######################################################
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
if($sql_mode == "upgrade") include_once $base_path.'sql_upgrade.php';
?>
