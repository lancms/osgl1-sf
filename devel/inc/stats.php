<?php

require_once ('config/config.php');

if (!config("usepage_show_stats"))
{
	// FIXME: lang()
	nicedie($msg[1]);
}


/* Display OS-related stuff */

$WinQ = query("SELECT SUM(hits) AS Windows FROM stats WHERE value LIKE '%windows%' AND config = 'user_agent'");
$WinR = fetch($WinQ);

$LinQ = query("SELECT SUM(hits) AS Linux FROM stats WHERE value LIKE '%Linux%' AND config = 'user_agent'");
$LinR = fetch($LinQ);

$OthQ = query("SELECT SUM(hits) AS Other FROM stats WHERE value NOT LIKE '%Linux%' AND value NOT LIKE '%Windows%' AND value NOT LIKE '%bot%' AND value NOT LIKE '%yahoo%' AND config = 'user_agent'");
$OthR = fetch($OthQ);


$Windows = $WinR->Windows;
$Linux = $LinR->Linux;
$Other = $OthR->Other;
/* Just teststuff
echo "Windows: $Windows <br>";
echo "Linux: $Linux <br>";
echo "Other: $Other <br>";
 */
$total = $Windows + $Linux + $Other;

// Memo to self: how to calculate percantage: (part * 100)/whole

$WinPercent = ($Windows * 100)/$total;
//echo $WinPercent."<br>";
$LinPercent = ($Linux * 100)/$total;
//echo $LinPercent."<br>";
$OthPercent = ($Other * 100)/$total;
//echo $OthPercent."<br>";

echo lang("OSes that have visited this page:", "inc_stats", "Text to display as a header for OSes that have visited the site");
echo "<table>";
echo "<tr><th>";
echo lang("Operating System: ", "inc_stats", "Table header for OS");
echo "</th><th>";
echo lang("Number of hits", "inc_stats", "Text to display as header for OS hits");
echo "</th><th>";
echo lang("Percentage of hits", "inc_stats", "Text to display as header for OS hitpercentage");
echo "</th></tr>";

echo "<tr><td>";
echo "Windows";
echo "</td><td>";
echo $Windows;
echo "</td><td>";
echo $WinPercent;
echo "</td></tr>";

echo "<tr><td>";
echo "Linux";
echo "</td><td>";
echo $Linux;
echo "</td><td>";
echo $LinPercent;
echo "</td></tr>";

echo "<tr><td>";
echo lang("Other", "inc_stats", "Text to display if it is another OS than one specifically mentioned");
echo "</td><td>";
echo $Other;
echo "</td><td>";
echo $OthPercent;
echo "</td></tr>";

echo "</table>";

?>
