<?php
require_once "./config/config.php";

/* first: print out some info about the user.... */
// No longer used, top.php instead
/*
if(getcurrentuserid() != 1) {


    $userID = getcurrentuserid();
    if($userID != 1) {
        echo "<br><font size=-2>".$msg[0];
        $query = mysql_query("SELECT users.nick, users.isCrew FROM session INNER JOIN users ON users.ID = session.userID WHERE session.sID = '".session_id()."'");
        $result = mysql_fetch_object($query);
        $nick = $result->nick;

        echo "<br>".$nick." | ";
        $crew = $result->isCrew;

        echo $rank[$crew];

        echo " | <a href='do.php?action=logout'>Logout</a>";
        echo "</font>";
    }
}
*/




function write_menu($alink,$atext) {
    echo "<tr><td width='97%' height='1'><font face='Verdana' size='2'><a href=$alink>$atext</a></font></td></tr>\n";
}