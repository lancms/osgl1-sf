<?php

$query = query("SELECT userID FROM session WHERE session.userID = 1");

$nr = num($query);

if($nr == 1)
{
	echo "1 guest";
}
elseif ($nr == 0)
{
	echo $msg[16];
}
else
{
	echo "$nr guests";
}

$query = query("SELECT DISTINCT users.Nick, users.ID FROM session INNER JOIN users ON users.ID = session.userID WHERE session.userID > 1 ORDER BY users.nick ASC");

$nr = num($query);

for($i=0;$i<$nr;$i++)
{
    $d = fetch_array($query);
    echo ",<a href='index.php?inc=profile&uid=$d[1]'>$d[0]</a>";
}


?>
