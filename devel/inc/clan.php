<?php



if(!config("usepage_compo")) die($msg[1]);

if(!isset($_GET["action"]))

    $action = "listclans";

else

    $action = $_GET["action"];





if($action == "viewclan")

{

    if(!isset($_GET["clanID"]))

    {

        echo "Hacking?";

    }

    else

    {

        $clanid = $_GET["clanID"];



        if(isset($_GET["compoID"]))

            $compoID = $_GET["compoID"];

        else

            $compoID = 0;





        $query = mysql_query("SELECT * FROM Clan WHERE ID = $clanid")

            or die(mysql_error());



        $row = mysql_fetch_object($query);



        echo "<h1>".stripslashes($row->name)."</h1><br><br>\n";



        echo stripslashes(nl2br($row->about))."<br><br>\n";



        $query = mysql_query("SELECT nick, ID FROM users WHERE ID = $row->moderator")

            or die(mysql_error());



        $row = mysql_fetch_object($query);



        $modnick = $row->nick;

        $modid = $row->ID;



        echo "Moderator : <a href=index.php?inc=profile&uid=$modid>$modnick</a><br><br>";



        if($compoID != 0)

        {

            $query = mysql_query("SELECT DISTINCT compoReg.userID, users.nick, users.ID FROM compoReg INNER JOIN users ON compoReg.userID = users.ID WHERE compoReg.clanID = $clanid AND compoReg.compoID = $compoID")

                or die(mysql_error());



            if(mysql_num_rows($query) > 0)

            {

                echo "Disse spillerene er med i denne compoen :<br>";



                for($i=0;$i<mysql_num_rows($query);$i++)

                {

                    $row = mysql_fetch_object($query);

                    echo "<a href=index.php?inc=profile&uid=$row->ID>".$row->nick."</a><br>\n";

                }



                echo "<br><br>";

            }

        }



        $query = mysql_query("SELECT DISTINCT compoReg.clanID, compo.name, compo.ID FROM compoReg INNER JOIN compo ON compoReg.compoID = compo.ID WHERE compoReg.clanID = $clanid")

            or die(mysql_error());



        if(mysql_num_rows($query) > 0)

        {

            echo "Denne klanene er med i følgende compoer :<br>";



            for($i=0;$i<mysql_num_rows($query);$i++)

            {

                $row = mysql_fetch_object($query);

                echo "<a href=index.php?inc=compo&action=viewcompo&compoID=$row->ID>".$row->name."</a><br>\n";

            }

        }





    }
	$leader = mysql_query("SELECT * FROM Clan WHERE ID = $clanid") or die(mysql_error());
        $lead = mysql_fetch_object($leader);
        if(getuserrank() == 2 || getcurrentuserid() == $lead->moderator)
        	echo "<a href=index.php?inc=clan&action=editclan&clanID=$clanid>$msg[20]</a>";

}

elseif($action == "newclan")

{

    if(getcurrentuserid() != 1)

    {

    ?>

<form name="newclan" action="index.php?inc=clan&action=addclan" method=post>

<?php echo $form[28] ?> <input type=text name=name><br>

<?php echo $form[27] ?><br>

<textarea name=caption>

</textarea><br>

<?php echo $form[25] ?> <input type=password name=pwd1><br>

<?php echo $form[26] ?> <input type=password name=pwd2><br>

<input type=submit value="<?php echo $form[15] ?>">

</form>



    <?php

    }

    else

    {

        echo $form[31];

    }

}

elseif($action == "addclan")

{

    if(getcurrentuserid() == 1)

    {

        echo $form[31];

        return;

    }



    $cl_name = addslashes($_POST["name"]);

    $cl_caption = addslashes($_POST["caption"]);

    $cl_pwd1 = $_POST["pwd1"];

    $cl_pwd2 = $_POST["pwd2"];



    if($cl_pwd1 != $cl_pwd2)

    {

        echo $form[14];

        return;

    }



    if($cl_name == "")

    {

        echo $form[32];

        return;

    }



    if(empty($cl_pwd1)) {

		echo $form[39];

		return;

	}



    $cl_pwd = crypt_pwd($cl_pwd1);



    $uid = getcurrentuserid();



    $query = mysql_query("INSERT INTO Clan (name, about, password, moderator) VALUES('$cl_name', '$cl_caption', '$cl_pwd', $uid)")

        or die(mysql_error());

    echo "$form[40]";
    refresh();

} elseif($action == "editclan") {
$clan = $_GET['clanID'];
$q = mysql_query("SELECT * FROM Clan WHERE ID = $clan") or die(mysql_error());
$r = mysql_fetch_object($q);

if(getuserrank() == 2 || $r->moderator == getcurrentuserid()) {

echo "<form method=POST action=index.php?inc=clan&action=doedit&clanID=$clan>";
echo "<input type=text name=name value='$r->name'>";
echo "<br> $msg[19]";
echo "<br><textarea name=about cols=25 rows=3>$r->about</textarea>";
echo "<br><input type=submit value='$form[15]'>";
echo "</form>";
}

}

elseif($action == "doedit") {
$clan = $_GET['clanID'];
$q = mysql_query("SELECT * FROM Clan WHERE ID = $clan") or die(mysql_error());
$r = mysql_fetch_object($q);

if(getuserrank() == 2 || $r->moderator == getcurrentuserid()) {

$about = addslashes($_POST['about']);
$name = addslashes($_POST['name']);

mysql_query("UPDATE Clan SET about = '$about', name = '$name' WHERE ID = $clan") or die(mysql_error());
refresh("index.php?inc=clan&action=editclan&clanID=$clan", 1);
echo $form[52];
}
} else {
echo "WTF?!?!?!?!?!?";
}
?>