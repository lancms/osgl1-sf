<?php

require_once ('config/config.php');

$query = query("SELECT DISTINCT userID,IP FROM session WHERE userID != 1");
echo $msg[21];
echo num($query);

$total = query("SELECT DISTINCT userID,IP FROM session WHERE userID = 1");
echo "<br>";
echo $msg[22];
echo num($total);

?>
