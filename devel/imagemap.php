<?php
require_once 'config/config.php';



$q = query("SELECT * FROM config WHERE config = 'seatmap'");
$r = fetch($q);
$map = convert_seatmap($r->large);

echo "<map name=seatmap>\n\n";

for($i=0;$i<count($map);$i++) {
	
	for($l=0;$l<count($map[$i]);$l++) {
		
	$coords = ($l * $seatsize).",".($i * $seatsize)." ".($l * $seatsize + $seatsize).",".($i * $seatsize + $seatsize);
		$sdata = $map[$i][$l];
		$snum = $seatsign_number[$sdata];
		$level = $seatsign[$snum]['level'];
			
		if($level > -2)
			echo "<area shape='rect' href='seat.php?i=$i&l=$l' coords='$coords'>\n";
	}
	
}

echo "</map>\n\n";
