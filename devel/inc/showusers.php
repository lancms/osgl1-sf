<?php

$query = mysql_query("SELECT userID FROM session WHERE session.userID = 1")
    or die(mysql_error());

$nr = mysql_num_rows($query);

if($nr == 1)
    echo "1 guest";
elseif ($nr == 0)
    echo $msg[16];
else
    echo "$nr guests";

$query = mysql_query("SELECT DISTINCT users.Nick, users.ID FROM session INNER JOIN users ON users.ID = session.userID WHERE session.userID > 1 ORDER BY users.nick ASC")
    or die(mysql_error());

$nr = mysql_num_rows($query);

for($i=0;$i<$nr;$i++)
{
    $d = mysql_fetch_row($query);
    echo ",<a href='index.php?inc=profile&uid=$d[1]'>$d[0]</a>";
}


?>