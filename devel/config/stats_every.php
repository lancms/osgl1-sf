<?php

$browser = get_browser( $HTTP_SERVER_VARS['HTTP_USER_AGENT']);

$q = query("SELECT * FROM stats WHERE config = 'hits' AND value = 'pageviews'");

if(mysql_num_rows($q) == 0) query("INSERT INTO stats SET config = 
'hits',
value = 'pageviews',
hits = 0");

query("UPDATE stats SET hits = hits + 1 WHERE
config = 'hits' AND value = 'pageviews'");

