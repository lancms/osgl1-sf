<?php
require_once 'config.php';

$browser = get_browser($HTTP_USER_AGENT);


$q = query("SELECT * FROM stats WHERE config = 'platform' AND value = '$browser->platform'");

if(mysql_num_rows($q) == 0) query("INSERT INTO stats SET 
config = 'platform',
value = '$browser->platform',
hits = 1");

else query("UPDATE stats SET hits = hits + 1
WHERE config = 'platform' AND value = '$browser->platform'");

$qbrows = query("SELECT * FROM stats WHERE 
config = 'browser' AND
value = '$browser->browser'");

if(mysql_num_rows($qbrows) == 0) query("INSERT INTO stats SET
config = 'browser',
value = '$browser->browser',
hits = 1");

else query("UPDATE stats SET hits = hits + 1 WHERE
config = 'browser' AND value = '$browser->browser'");

$quniq = query("SELECT * FROM stats WHERE
config = 'hits' AND
value = 'uniq'");

if(mysql_num_rows($quniq) == 0) query("INSERT INTO stats SET
config = 'hits',
value = 'uniq',
hits = 0");

else query("UPDATE stats SET hits = hits + 1 WHERE
config = 'hits' AND value = 'uniq'");
