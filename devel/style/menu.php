<?php
require_once 'config/config.php';

$style = user_style();
if($style == "default") {
	$q = mysql_query("SELECT * FROM config WHERE config = 'default_style'");
	$r = mysql_fetch_object($q);
	$style = $r->value;
}
echo config("default_style");
include $style."/menu.php";

/* The main page ;) */
echo "<font class=menu>";
write_menu("index.php",$title[page][0]);

/* Insert the static files; they usually contains info, so they should be the first the user comes to */
if(config("usepage_static"))  {
    $q = mysql_query("SELECT * FROM static WHERE header != 'index'") or die(mysql_error());
    while($r = mysql_fetch_object($q))
		write_menu("index.php?page=$r->header", $r->header);
}

/* write out the menu for pages you configure in config.php */
if(config("usepage_news"))
    write_menu("index.php?inc=news&many=ALL", $title[page][9]);

if(config("usepage_faq")) write_menu("index.php?inc=faq",$title[page][1]);
if(config("usepage_register")) write_menu("index.php?inc=register", $title[page][2]);
if(config("usepage_poll")) write_menu("index.php?inc=poll", $title[page][5]);
if(config("usepage_seat")) write_menu("seat.php", $title[page][6]);
if(config("usepage_compo")) write_menu("index.php?inc=compo", $title[page][8]);
if(config("usepage_forum")) write_menu("forum.php", $title[page][12]);
if(config("usepage_partyweb")) write_menu("partyweb/", $title[page][16]);
if(getcurrentuserid() == 1) {

}
else
{
    // In this design, we put this one on top :)
    //write_menu ("do.php?action=logout", $title[page][3]);
    write_menu ("index.php?inc=useradmin", $title[page][7]);
    write_menu ("index.php?inc=kiosk", $title[page][15]);
    if(config("usepage_compo")) write_menu("index.php?inc=clan&action=newclan", $title[page][10]);
    // This has not been written yet!


    if(getuserrank() >= 1) {
        // This user has crew access! write meny-stuff for crew here!
		write_menu("index.php?inc=userlogin", $title[page][13]);
		write_menu("index.php?inc=adressbook", $title[page][14]);
		write_menu("http://crew.globelan.net", "Crewforum");
    } if(getuserrank() == 2) {
        // *wheeeee* admin-access!
        write_menu("admin.php", $title[page][4]);
    }

}

