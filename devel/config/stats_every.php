<?php

query("UPDATE stats SET hits = hits + 1 WHERE
config = 'hits' AND value = 'pageviews'");
?>