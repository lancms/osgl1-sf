<?php

require_once "config/config.php";

// Seat registration


$action = $_GET["action"];

$seatid = $_GET["seatID"];

$userseats = NULL;


if($action == "move")

{

    $uid = getcurrentuserid();



    if($uid == 1)

        return;




    $check = mysql_query("SELECT * FROM users WHERE seatID = $seatid");

    $u = mysql_fetch_object($check);
    $oldseatid = $u->seatID;

    if(mysql_num_rows($check) != 0 && $seatid != 0)
        die("Beklager, men plassen er allerede i bruk!");

    $query = mysql_query("UPDATE users SET seatID = $seatid WHERE ID = $uid")
        or die("Could not move : ".mysql_error());

    query("DELETE FROM waitinglist WHERE userID = ".getcurrentuserid());

    $query = mysql_query("SELECT userID FROM waitinglist ORDER BY ID ASC LIMIT 1");

    if(mysql_num_rows($query) > 0)
    {
        $q = mysql_fetch_row($query);
        $q = $q[0];

        $query = mysql_query("UPDATE users SET seatID = $oldseatid WHERE ID = $q")
            or die(mysql_error());

        $query = mysql_query("DELETE FROM waitinglist WHERE userID = $q")
            or die(mysql_error());
    }
    header("Location: seat.php");

    return;
}
if($action == "addwaiting") {
if(getcurrentuserid() == 1) {
header("Location: seat.php");
} else {

query("INSERT INTO waitinglist SET userID = ".getcurrentuserid());
query("UPDATE users SET seatID = 0 WHERE ID = ".getcurrentuserid());
header("Location: seat.php");
}
}

include 'config/seat-top.php';



echo "<a href=index.php>".$title[page][0]."</a>";

echo "<br><a href=seat.php?action=move&seatID=0>$seat[8]</a><br>";





require_once "config/config.php";



$myfile = fopen($usemap, "r"); // open map file for reading



$userID = getcurrentuserid(); // get user ID



$as = 0;

$row[0] = 0;



if($userID != 1)

{

    $query = mysql_query("SELECT isCrew FROM users WHERE ID = $userID")

        or die(mysql_error());



    $row = mysql_fetch_row($query);



    $cs_isCrew = $row[0];

}

else

    $cs_isCrew = 0;







$query = mysql_query("SELECT seatID, nick, ID FROM users WHERE seatID >= 1 ORDER BY seatID ASC")

    or die(mysql_error());





echo "<table cellspacing=0>";



$row = mysql_fetch_row($query);



while(!feof($myfile))

{



    $f = fgets($myfile, 128); // read one line into memory





    echo "<tr>";



    for($i=0;$i<strlen($f);$i++)

    {





        $ft = $f[$i]; // retrieve the next letter



        if($ft == "\r") // if $ft equals carriage return (end of line) break for loop

            break;



        $cs++; // field count ++





        $isSeat = FALSE; // reset values to FALSE

        $isCrew = FALSE;



        if($ft == "s") // regular seat

        {

            $rt = "tdUser";

            $isSeat = TRUE;

            $as++;

        $userseats++;
            if($as > $row[0])

                $row = mysql_fetch_row($query);

            if($as == $row[0])

                $rt = "tdUserTaken";

        }

        else if($ft == "c") // crew seat

        {

            $rt = "tdCrew";

            $isSeat = TRUE;

            $isCrew = TRUE;

            $as++;

            if($as > $row[0])

                $row = mysql_fetch_row($query);

            if($as == $row[0])

                $rt = "tdCrewTaken";

        }

        else if($ft == "#") // wall

            $rt = "tdWall";

        else if($ft == "-") // hall / nothing

            $rt = "tdVoid";

        else if($ft == "k") // Canteene

            $rt = "tdCanteene";

        else if($ft == "*") // Entrance/Door

            $rt = "tdDoor";

        else if($ft == "+") // Nothing

            $rt = "tdUser";

        else

            $rt = "tdVoid";



        //echo $ft;



        $ml = "<td class=$rt>"; // set table class



        if($row[0] == $as) // Check if the current dataset seatID matches current $as (seat position)

            $u = $row[2]; // $u = nick from dataset

        else

            $u = 0;



        if($isSeat)

        {



            if($u) // if there is a person on this seat

            {

                $ml .= "<a href='index.php?inc=profile&uid=$row[2]'>$row[1]</a>";

            }

            else // if not...

            {

                if($isCrew) // is this a crew-seat?

                {

                    if($cs_isCrew) // is the current user in Crew?

                        $ml .= "<a href='seat.php?action=move&seatID=$as'>$seat[0]</a>"; // make the seat availble

                    else

                        $ml .= "$seat[1]"; // make the seat unavailble

                }

                else // if this is not a crew seat...

                {

                    if($userID != 1 && !$cs_isCrew && config("seatreg_open")) // Guests and Crew cannot use regular seats.

                    {

                        $ml .= "<a href='seat.php?action=move&seatID=$as'>$seat[0]</a>";

                    }

                    else

                        $ml .= $seat[0];

                }

            }

        }

        $ml .= "</td>\n"; // finalize string



        echo $ml; // output string



    }

    echo "</tr>\n"; // end <tr> and make a new line



}



echo "</table>";



fclose($myfile); // close the map file.

$waiting = query("SELECT * FROM waitinglist");
echo "Starter listen over folk med ventelisteplass";

//$count_waiting = 0;
echo "<table>";
while($r = mysql_fetch_object($waiting)) {
//if($count_waiting == 10) {
//$count_waiting = 0;
//echo "</tr><tr>";
//}
echo "<tr>";
echo "<td>";
echo IDtonick($r->userID);
echo "($r->userID)";
echo "</td>";
echo "</tr>";
//$count_waiting++;
}
$checkinsert = query("SELECT * FROM waitinglist WHERE userID = ".getcurrentuserid());
if(mysql_num_rows($checkinsert) == 0 || getcurrentuserid() != 1)
//echo "<tr><td><a href=seat.php?action=addwaiting>Legg meg til i ventelisten!</a></td>";
echo "</tr></table>";
?>

<br><br>

<?php

echo "<table bordercolor=black border=1 cellspacing=0><tr><td class=tdUser>$seat[3]</td><td class=tdCrew>$seat[1]</td><td class=tdDoor>$seat[4]</td><td class=tdWall>$seat[5]</td><td class=tdCanteene>$seat[6]</td><td class=tdVoid>$seat[7]</td></tr></table>";

?>

<br><br>

<?php

echo "Antall plasser: ".$userseats;
echo "<br>Antall plasser tatt: ";
$select_taken = mysql_query("SELECT * FROM users WHERE seatID != 0 AND isCrew = 0");
echo mysql_num_rows($select_taken)." (av deltagere)";
echo "<br>Antall ledige plasser: ";
$antall_taken = mysql_num_rows($select_taken);
echo $userseats - $antall_taken;
?>
