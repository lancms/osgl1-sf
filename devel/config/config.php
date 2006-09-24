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
 * Set to FALSE to disable.
 */
$usestats = TRUE;


/*
 * seatsize
 *
 * How many pixels a seat in seatsystem should be (if not zoomed)
 */
$seatsize = 10;

/*
 * usercheckbox
 *
 * Three webmaster-customizable checkboxes on register and useradmin
 *
 */


#$userCheckbox1 = "Text to display for this checkbox";
#$userCheckbox1_default = "CHECKED"; // At registertime
#$userCheckbox2 = "Text to display for this checkbox";
#$userCheckbox2_default = "CHECKED"; // At registertime
#$userCheckbox3 = "Text to display for this checkbox";
#$userCheckbox3_default = "CHECKED"; // At registertime

/*
 * extra meny-links
 *
 * This option allows you to add more menuitems to the public menu. Ex: link to a picture gallery, or a forum
 *
 */

$menyitem[0]['url'] = "http://forum.globelan.net";
$menuitem[0]['text'] = "Forum";

$menuitem[1]['url'] = "http://bilder.globelan.net";
$menuitem[1]['text'] = "Picture Gallery";

/*
 * min_pass_length
 *
 * Minimum length of passwords.
 * Should be more that five (5).
 */
$min_pass_length = 5;

/*
 * resend_delay
 *
 *
 * 60sek*60min*12hours
 */
$resend_delay = 43200;

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
 * mail-stuff
 *
 * 0 = Subject of mail
 * 1 = From ?
 * 2 = From ?
 */
$mail[0] = "You have been registered as a user of OSGlobeLAN!";
$mail[1] = "$admin[contact][mail]";
$mail[2] = "OSGlobeLAN";


function mail_body($random) {
    return "Welcome as a user of OSGlobeLAN!\n\r
    You have either changed your email, or created a new user, so please login with your username and password, and enter: ".$random." as your verification-number!\r\n\r\n
    Thanks you\r\n
    The Crew";
}

/*
 * Do not edit below this!
 */
global $base_path;
$lang_file = "$base_path"."lang/".$language.".php";

$lang_inc = require_once $lang_file;
if (!$lang_inc)
{
	die("Could not find language file");
}

require_once ("shared_functions.php");
require_once ("shared_session.php");

$styles = NULL;
$style_folders = $base_path."style/";
$dir = opendir($style_folders);
while ($read = readdir($dir))
{
	// FIXME: I believe there are nicer ways to do this. :-)
   if (($read == ".") || ($read == "..") || (!is_dir($style_folders.$read)));
   else
	{
      $styles[] = $read;
   }

}

if ($usestats)
{
	require_once ('stats_every.php');
}
?>
