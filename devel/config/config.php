<?php

/* This one will define where the root-path of all your files are.... */
$base_path = "/var/www/devel/";

/* Site-title will show up as the <title></title> text on all the pages.... */
$sitetitle = "GlobeLAN 4,5 DEVEL";
$devel_version = "0.3 Alpha";

/* config for the MySQL server! */
/* As default, I have commented this out, and instead include it from an other file, since this release is automated! */
#$sql_server = "localhost";
#$sql_user = "root";
#$sql_pass = "";
#$sql_db = "devel";

/* Setting this to upgrade will automatically upgrade the database (hopefully) when an admin is logged in.... */
/* Should probably be disabled when the upgrade is completed */
#$sql_mode = "upgrade";

/* This file contains the $sql_* variables shown above */
include_once '/home/lak/inc_devel.php';

/* config for database handling */
$session_alive_time = 3600;      // How long should a session stay alive? 3600 (one hour) is default.
$cookiename = "GlObeLAN-DeVeL";
/* The language-files to use.... If your language is not in the lang-folder, make it, translate it, and send it to the creators... */
$language = "norwegian";

/* Which systems to use... */


$usenews = 3;			// Number of news-items to show on first-page *FALSE to disable*
$userand = TRUE;		// Enable random-system, TRUE to give random from the table random on every page-view... random_quote() to put it in on the page.... (default used in bottom.php)

$usestats = TRUE;

$rand_text = "Tilfeldig: ";

$usemap = $base_path."config/defaultmap.txt";


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


######################################################
##
## NO EDIT!!!
##
######################################################
global $base_path;
$lang_file = "$base_path"."lang/".$language.".php";


$lang_inc = require_once "$lang_file";
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
