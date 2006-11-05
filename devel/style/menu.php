<?php
require_once 'config/config.php';

$style = user_style();
#if($style == "default") {
#	$q = mysql_query("SELECT * FROM config WHERE config = 'default_style'");
#	$r = mysql_fetch_object($q);
#	$style = $r->value;
#}
#echo config("default_style");
include $style."/menu.php";

/* The main page ;) */
echo "<font class=menu>";
write_menu("index.php",lang("Main Page", "style_menu", "menuitem in write_menu"));

/* Insert the static files; they usually contains info, so they should be the first the user comes to */
if(config("usepage_static"))  {
	if(acl_access("isCrew")) $staticFiles = '1,0';
	else $staticFiles = '0';
    $q = mysql_query("SELECT * FROM static WHERE header != 'index' AND showPage = 1 AND crewOnly IN ($staticFiles)") or die(mysql_error());
    while($r = mysql_fetch_object($q)) {
	    $header = $r->header;
	    $header = str_replace("_", " ", $header);
		write_menu("index.php?page=$r->header", $header);
	}
}

/* write out the menu for pages you configure in config.php */
if(config("usepage_news"))
    write_menu("index.php?inc=news&many=ALL",lang("News", "style_menu", "menuitem in write_menu"));

if(config("usepage_faq")) write_menu("index.php?inc=faq",lang("FAQ", "style_menu", "menuitem in write_menu"));
if(config("usepage_register") && getcurrentuserid() == 1) write_menu("index.php?inc=register",lang("Register", "style_menu", "menuitem in write_menu"));
if(config("usepage_poll")) write_menu("index.php?inc=poll",lang("Polls", "style_menu", "menuitem in write_menu"));
if(config("usepage_seat")) write_menu("seat.php", lang("Seatmap", "style_menu", "menuitem in write_menu"));
if(config("usepage_compo")) write_menu("index.php?inc=compo", lang("Composystem", "style_menu", "menuitem in write_menu"));
if(config("usepage_forum")) write_menu("forum.php", lang("Forum", "style_menu", "menuitem in write_menu"));
if(config("usepage_partyweb")) write_menu("partyweb/", lang("Partyweb", "style_menu", "menuitem in write_menu"));
if(config("usepage_show_stats")) write_menu("index.php?inc=stats", lang("Statistics", "style_menu", "Menuitem for stats"));
#write_menu("http://forum.globelan.net", "Forum");
for($i=0;$i<=count($menyitem);$i++) {
	write_menu($menyitem[$i]['url'], $menuitem[$i]['text']);
}
if(getcurrentuserid() == 1) {

}
else
{
    write_menu ("index.php?inc=useradmin", lang("Edit profile", "style_menu", "menuitem in write_menu"));
//    if(config("usepage_kiosk")) write_menu ("index.php?inc=kiosk", $title['page'][15]); // Doesn't work
    if(config("usepage_compo")) write_menu("index.php?inc=clan", lang("Clanregistration", "style_menu", "menuitem in write_menu"));
    if(config("usepage_compopoll")) write_menu("index.php?inc=compopoll", lang("Compopoll", "style_menu", "menuitem in write_menu"));
    if(config("usepage_wannabe")) write_menu("index.php?inc=wannabe", lang("WannabeCrew", "style_menu", "menuitem in write_menu"));


//    if(getuserrank() >= 1) {
        // This user has crew access! write meny-stuff for crew here!
if(acl_access("loginUser")) write_menu("index.php?inc=userlogin", lang("Userlogin", "style_menu", "menuitem in write_menu"));
if((acl_access("kioskCrew") || acl_access("kioskAdmin")) && config("usepage_kiosk")) write_menu("index.php?kiosk=kiosk", lang("Kiosk", "style_menu", "menuitem for kiosk in write_menu"));
if(acl_access("isCrew")) write_menu("index.php?inc=adressbook", lang("Crewaddressbook", "style_menu", "menuitem in write_menu"));
if(acl_access("displayAdmin")) write_menu("admin.php", lang("ADMIN", "style_menu", "menuitem in write_menu"));
write_menu("do.php?action=logout", lang("Logout", "style_menu", "menuitem in write_menu"));
#		write_menu("http://crew.globelan.net", "Crewforum");
//    } if(getuserrank() == 2) {
        // *wheeeee* admin-access!
        //write_menu("admin.php", $title['page'][4]);

//  }

}
echo "</font>";
