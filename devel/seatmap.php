<?php
include "seatformats.php";

$zoom = "";
if(isset($_GET["zoom"]))
	if($_GET["zoom"] == "on")
		$zoom = "&zoom=on";

$rn = getuserrank();

for($i=0;$i<$height;$i++)
{
	$k = strlen($myfile[$i]);
	for($j=0;$j<$k;$j++)
	{
		//$j = x
		//$i = y
		$c = $myfile[$i][$j];	// find out what the fuck this character is
		
		switch($c)
		{
			case "-":	// wall
				$cur = 0;
				break;
			case "d":	// user
				$cur = 1;
				break;
			case "c":	// crew
				$cur = 2;
				break;
			case "/":	// door
				$cur = 5;
				break;
			case "k":	// canteen / shop
				$cur = 6;
				break;
			case "n":	// not opened
				$cur = 7;
				break;
			default:	// probably ground.
				$cur = 4;
				break;
				
		}
		$x = $j * $addwidth;	// we calculate once, so that we save some speed.
		$y = $i * $yscale;
		$xx = $x + $addwidth;
		$yy = $y + $yscale;
		
		
		if(($seat_avail[$cur] > 0) && ($rn + 1  >= $seat_avail[$cur]))	// if seat is availble
		{
			echo "<area href='seat.php?x=$j&y=$i$zoom' shape=rect coords='$x,$y,$xx,$yy'>\n";
		}
	}
}
?>
