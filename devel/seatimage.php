<?php
require_once 'config/config.php';



/*
$img_number = imagecreate(100,50);
$white = imagecolorallocate($img_number,255,255,255);
$black = imagecolorallocate($img_number,0,0,0);
$grey_shade = imagecolorallocate($img_number,204,204,204);
imagefill($img_number,0,0,$white);
ImageRectangle($img_number,5,5,94,44,$black);
ImageRectangle($img_number,0,0,99,49,$black);

*/
$q = query("SELECT * FROM config WHERE config = 'seatmap'");
$r = fetch($q);
$map = convert_seatmap($r->large);

$xsize = count($map) * $seatsize;
$ysize = count($map[0]) * $seatsize;

$image = imagecreate($ysize, $xsize);
$defaultcolor = "black";
$color['black'] = imagecolorallocate($image, 0, 0, 0);
$color['white'] = imagecolorallocate($image, 255, 255, 255);
$color['red'] = imagecolorallocate($image, 255, 0, 0);
$color['green'] = imagecolorallocate($image, 0, 255, 0);
$color['blue'] = imagecolorallocate($image, 0, 0, 255);
$color['orange'] = imagecolorallocate($image, 238, 137, 26);
$color['grey'] = imagecolorallocate($image, 127, 127, 127);
$color['brown'] = imagecolorallocate($image, 85, 49, 40);
$color['yellow'] = imagecolorallocate($image, 200, 250, 0);
$color['silver'] = imagecolorallocate($image, 150, 150, 150);




imagefill($image, 0, 0, $black);

for($i=0;$i<count($map);$i++) {

	for($l=0;$l<count($map[$i]);$l++) {

		$seatcolor = seat_color($map[$i][$l], $i, $l);
		
		//echo $map[$i][$l];
		ImageFilledRectangle($image, ($l * $seatsize),
			($i * $seatsize), (($l * $seatsize) + $seatsize),
			(($i * $seatsize) + $seatsize), $color[$seatcolor]);
		//echo $seatcolor;
		$mapsign = $map[$i][$l];
		$number = $seatsign_number[$mapsign];
		if($seatsign[$number]['level'] >= 0)
		ImageRectangle($image, ($l * $seatsize),
				($i * $seatsize), (($l * $seatsize) + $seatsize),
				(($i * $seatsize) + $seatsize), $color['black']);
	}
	//echo "<br>";

}



//echo $xsize;
//echo " ";
//echo $ysize;


header("Content-type: image/png");
imagepng($image);






function seat_color($sign, $i=NULL, $l=NULL) {
	global $defaultcolor;
	global $seatsign;
	global $seatsign_number;
	global $party;
	
	$get_i = $_GET['i'];
	$get_l = $_GET['l'];
	
	
	$q = query("SELECT * FROM users WHERE seatI = '$i' AND seatL = '$l'");
	if(num($q) != 0) return 'silver';
	elseif($i == $get_i && $l == $get_l) return 'yellow';
	else {
		$sign_num = $seatsign_number[$sign];
		$ssign = $seatsign[$sign_num]['color'];
		//echo $ssign[$sign_num]['color'];
		
		if(isset($ssign)) $seatcolor = $ssign;
		else $seatcolor = $defaultcolor;


		return $seatcolor;
	}



}

