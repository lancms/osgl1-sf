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
write_menu("index.php",$title['page'][0]);

/* Insert the static files; they usually contains info, so they should be the first the user comes to */
if(config("usepage_static"))  {

    $q = mysql_query("SELECT * FROM static WHERE header != 'index' AND showPage = 1") or die(mysql_error());
    while($r = mysql_fetch_object($q)) {
	    $header = $r->header;
	    $header = str_replace("_", " ", $header);
		write_menu("index.php?page=$r->header", $header);
	}
}

/* write out the menu for pages you configure in config.php */
if(config("usepage_news"))
    write_menu("index.php?inc=news&many=ALL", $title['page'][9]);

if(config("usepage_faq")) write_menu("index.php?inc=faq",$title['page'][1]);
if(config("usepage_register")) write_menu("index.php?inc=register", $title['page'][2]);
if(config("usepage_poll")) write_menu("index.php?inc=poll", $title['page'][5]);
if(config("usepage_seat")) write_menu("seat.php", $title['page'][6]);
if(config("usepage_compo")) write_menu("index.php?inc=compo", $title['page'][8]);
if(config("usepage_forum")) write_menu("forum.php", $title['page'][12]);
if(config("usepage_partyweb")) write_menu("partyweb/", $title['page'][16]);
if(config("usepage_show_stats")) write_menu("index.php?inc=stats", lang("Statistics", "style_menu", "Menuitem for stats"));
if(getcurrentuserid() == 1) {

}
else
{
    // In this design, we put this one on top :)
    //write_menu ("do.php?action=logout", $title['page'][3]);
    write_menu ("index.php?inc=useradmin", $title['page'][7]);
//    if(config("usepage_kiosk")) write_menu ("index.php?inc=kiosk", $title['page'][15]); // Doesn't work
    if(config("usepage_compo")) write_menu("index.php?inc=clan", $title['page'][10]);
    if(config("usepage_compopoll")) write_menu("index.php?inc=compopoll", $title['page'][15]);
    if(config("usepage_wannabe")) write_menu("index.php?inc=wannabe", $title['page'][17]);


//    if(getuserrank() >= 1) {
        // This user has crew access! write meny-stuff for crew here!
if(acl_access("loginUser")) write_menu("index.php?inc=userlogin", $title['page'][13]);
if(acl_access("isCrew")) write_menu("index.php?inc=adressbook", $title['page'][14]);
if(acl_access("displayAdmin")) write_menu("admin.php", "ADMIN");

#		write_menu("http://crew.globelan.net", "Crewforum");
//    } if(getuserrank() == 2) {
        // *wheeeee* admin-access!
        //write_menu("admin.php", $title['page'][4]);

//  }

}

