<?php
require_once 'config/config.php';




function write_menu($alink,$atext) {
    echo "<li><a href=\"$alink\">$atext</a></li>\n";
}
