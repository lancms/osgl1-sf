<?php

if(!config("usepage_compo")) die($msg[1]);



if(!isset($_GET["action"]))

    $action = "displaycompos";

else

    $action = $_GET["action"];



if($action == "displaycompos")

{



    $query = mysql_query("SELECT * FROM compo")

        or die(mysql_error());



    echo "<table border=1 bordercolor=black cellspacing=0 width=100%><tr bgcolor=black><td>$compo[0]</td><td>$compo[1]</td><td>$compo[2]</td><td>$compo[3]</td></tr>\n";



    for($i=0;$i<mysql_num_rows($query);$i++)

    {

        $row = mysql_fetch_object($query);

        echo "<tr bgcolor=darkgray><td><a href='index.php?inc=compo&action=viewcompo&compoID=$row->ID'>$row->name</a></td><td>$row->caption</td><td>$row->gameType</td><td><center>$row->players</center></td></tr>\n";

    }



    echo "</table><br><br>\n";

    echo "<h1>$compo[4]</h1>";



    showclans();

}

elseif($action == "viewcompo")

{

    if(!isset($_GET["compoID"]))

    {

        echo "Hacking?";

        return;

    }

    $compoID = $_GET["compoID"];



    $query = mysql_query("SELECT DISTINCT compoReg.clanID, Clan.name, Clan.about FROM compoReg INNER JOIN Clan ON Clan.ID = compoReg.clanID WHERE compoReg.compoID = $compoID")

        or die(mysql_error());



    $nq = mysql_num_rows($query);



    echo "<a href='index.php?inc=compo&action=displaycompos'>&laquo; $msg[15]</a><br><br>\n";



    echo "<center><table width=80% cellspacing=0 bordercolor=black border=1><tr bgcolor=black><td>$compo[11]</td><td>$compo[12]</td><td>$compo[13]</td></tr>\n";



    for($i=0;$i<$nq;$i++)

    {



        $row = mysql_fetch_object($query);



        $qv = mysql_query("SELECT users.nick, users.ID FROM users INNER JOIN compoReg ON compoReg.userID = users.ID WHERE compoReg.compoID = $compoID AND compoReg.clanID = $row->clanID")

            or die(mysql_error());



        echo "<tr bgcolor=darkgray><td><a href=index.php?inc=clan&action=viewclan&compoID=$compoID&clanID=$row->clanID>$row->name</a></td><td valign=top>$row->about</td><td>";



        $r = mysql_fetch_object($qv);

        echo "<a href=index.php?inc=profile&uid=$r->ID>$r->nick</a>";



        for($j=1;$j<mysql_num_rows($qv);$j++)

        {

            if($j > 6)

            {

                echo ", ...";

                break;

            }



            $r = mysql_fetch_object($qv);

            echo ", <a href=index.php?inc=profile&uid=$r->ID>$r->nick</a>";

        }

        echo "</td></tr>";

    }



    echo "</table></center><br><br>\n";





    if(getcurrentuserid() != 1)

    {

        $uid = getcurrentuserid();

        $query = mysql_query("SELECT * FROM compoReg WHERE userID = $uid AND compoID = $compoID")

            or die(mysql_error());



        if(isset($_GET["errormsg"]))

        {

            $i = $_GET["errormsg"];

            if(isset($compoerr[$i]))

                echo "<b><font color=red>$compoerr[$i]</font></b><br>";

        }



        if(mysql_num_rows($query) == 0)

        {

            echo "$compo[5]<br><br>";

            echo "<form name=signon action=index.php?inc=compo&action=signon method=post>\n";

            echo "$compo[7] <input type=text name=clan><br>\n";

            echo "$compo[8] <input type=password name=pwd><br>\n";

            echo "<input type=submit value='$compo[6]'><br>\n";

            echo "<input type=hidden value=$compoID name=compoID>\n";

            echo "</form>\n";

        }

        else

        {

            echo "$compo[10]<br>\n";

            echo "<a href='index.php?inc=compo&action=signoff&compoID=$compoID'>$compo[9]</a><br>\n";

        }

    }

}

elseif($action == "signon")

{

    $compoID = $_POST["compoID"];



    if((!isset($_POST["clan"]) || !isset($_POST["pwd"])) || (getcurrentuserid() == 1))

    {

        refresh("index.php?inc=compo&action=viewcompo&compoID=$compoID&errormsg=3", 0);

    }



    $cn = $_POST["clan"];

    $pwd = $_POST["pwd"];

    $pwd = crypt_pwd($pwd);



    $query = mysql_query("SELECT password, ID FROM Clan WHERE name LIKE '$cn'")

        or die(mysql_error());



    if(($query) && mysql_num_rows($query))

    {

        $row = mysql_fetch_object($query);

	$q = mysql_query("SELECT * FROM compo WHERE ID = $compoID");
        $r = mysql_fetch_object($q);

        $num = mysql_query("SELECT * FROM compoReg WHERE compoID = $compoID AND clanID = $row->ID") or die(mysql_error());
        if($r->players <= mysql_num_rows($num)) die($compoerr[4]);

        elseif($row->password == $pwd)

        {

            $uid = getcurrentuserid();

            $query = mysql_query("INSERT INTO compoReg (userID, clanID, compoID) VALUES($uid, $row->ID, $compoID)")

                or die(mysql_error());

            refresh("index.php?inc=compo&action=viewcompo&compoID=$compoID", 0);

        }

        else

        {

            refresh("index.php?inc=compo&action=viewcompo&compoID=$compoID&errormsg=1", 0);

        }

    }

    else

    {

        refresh("index.php?inc=compo&action=viewcompo&compoID=$compoID&errormsg=2", 0);

    }

}

elseif($action == "signoff")

{



    if(!isset($_GET["compoID"]))

    {

        echo "Hacking?";

    }

    else

    {

        $compoID = $_GET["compoID"];



        $uid = getcurrentuserid();



        $query = mysql_query("DELETE FROM compoReg WHERE compoID = $compoID AND userID = $uid")

            or die(mysql_error());

    }

    refresh("index.php?inc=compo&action=viewcompo&compoID=$compoID", 0);

}



?>





<?php

function showclans()

{

    $query = mysql_query("SELECT * FROM Clan")

        or die(mysql_error());



    for($i=0;$i<mysql_num_rows($query);$i++)

    {

        $row = mysql_fetch_object($query);



        echo "<a href='index.php?inc=clan&action=viewclan&clanID=$row->ID'>".stripslashes($row->name)."</a> - ".stripslashes($row->about)."<br>\n";

    }

}



?>
