<?php
require_once 'config/config.php';

$query = mysql_query("SELECT DISTINCT userID,IP FROM session WHERE userID != 1");
echo $msg[21];
echo mysql_num_rows($query);

$total = mysql_query("SELECT DISTINCT userID,IP FROM session WHERE userID = 1");
echo "<br>";
echo $msg[22];
echo mysql_num_rows($total);
