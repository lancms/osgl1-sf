<?php
include "seatformats.php";
require_once 'config/config.php';

if(!function_exists('imagecreate')) die("You do not have PHP-GD installed. Contact your server admin and ask him to install it.");

$width -= 2;
$myimg = imagecreate($width * $addwidth, $height * $yscale);	// create an image resource

imageinterlace($myimg, 1);					// Turn on interlacing.

imagesetthickness($myimg, 1);					// set thickness on borders

$color_wall = imagecolorallocate($myimg, 0,0,0);		// allocate some colors (for the image palette, if we're using PNG-8 or GIF87a/89a
$color_seat = imagecolorallocate($myimg, 0,126,255);
$color_crew = imagecolorallocate($myimg, 255,180,0);
$color_blank = imagecolorallocate($myimg, 255, 255, 255);
$color_door = imagecolorallocate($myimg, 0,0,128);
$color_kiosk = imagecolorallocate($myimg, 0,255,120);
$color_vip = imagecolorallocate($myimg, 255,228,0);
$color_text = imagecolorallocate($myimg, 11, 43, 75);
$color_selected = imagecolorallocate($myimg, 64,192,255);
$color_used = imagecolorallocate($myimg, 180, 200, 200); // dark blue
$color_crewused = imagecolorallocate($myimg, 255,220,0);
$color_notopen = imagecolorallocate($myimg, 255,0,0);
$color_seated = imagecolorallocate($myimg, 255, 200, 128);

// Veldig viktig : Ikke lag over 16 farger!
// en av grunnene til at bildet blir så lite er at det er 4-bit (16 farger)
// med en gang det blir over 16 farger, blir det 8-bit og da tar det dobbelt så mye plass


$seat_color[0] = $color_wall;	// make things easier
$seat_color[1] = $color_seat;
$seat_color[2] = $color_crew;
$seat_color[3] = $color_vip;
$seat_color[4] = $color_blank;
$seat_color[5] = $color_door;
$seat_color[6] = $color_kiosk;
$seat_color[7] = $color_notopen;

$selx = -1;
$sely = -1;

$x = 0;
$y = 0;

if(isset($_GET["x"]))
{
	$selx = $_GET["x"];
	$sely = $_GET["y"];
}

imagefilledrectangle($myimg, 0, 0, $width * $addwidth, $height * $yscale, $seat_color[4]);	// fill the whole image with white

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
			case "k":	// kiosk
				$cur = 6;
				break;	
			case "n":
				$cur = 7;
				break;
			default:	// probably ground.
				$cur = 4;
				break;
				
		}
		
		$x = $j * $addwidth;	// we calculate once, so that we save some speed.
		$y = $i * $yscale;
		if($seat_color[$cur] != $color_blank)	// Only draw a rectangle where the color differs from $color_blank
		{

			$userQ = query("SELECT * FROM users WHERE seatX = '".escape_string($j)."' AND seatY = '".escape_string($i)."'");
			$user = fetch($userQ);
			
			if ($i == $sely && $j == $selx)
			{
				$clr = $color_selected;
			}
			elseif (((num($userQ) != 0) && ($seat_avail[$cur] == 1)))
			{
				if($user->tickettype != 0)
				{
					$clr = $color_seated;
				}
				else
				{
					$clr = $color_used;
				}
			}
			elseif ((num($userQ) != 0) && ($seat_avail[$cur] > 1))
			{
				$clr = $color_crewused;
			}
			else
			{
				$clr = $seat_color[$cur];
			}



			imagefilledrectangle($myimg, $x, $y, $x + $addwidth - 1, $y + $yscale - 1, $clr);	// fill a rectangle at seat position
			imagerectangle($myimg, $x, $y, $x + $addwidth - 1, $y + $yscale - 1, $color_wall);      // fill a rectangle at seat position
			if (($seat_avail[$cur]) && ($zoomedin))	// if seat is availble and we're zoomed in
			{
				$in = $user->nick;		// data input
				
				if (strlen($in) >= $name_maxlen + 1)	// check length of input
				{
					$in = substr($in, 0, $name_maxlen + 1);	// size down to $name_maxlen characters
					//$in .= "..";
				}
				//imagettftext($myimg, $font_size, 0, $x, $y + $yscale - 2, $color_wall, "arialalt.ttf", $in);	// TrueType font
				//imagepstext($myimg, $in, 1, $font_size, $color_wall, 0, $x, $y + $yscale - 2); // PostScript font
				imagestring($myimg, 1, $x + 2, $y + 1, $in, $color_text);
			}
		}
	}
}



header("Content-type: ".image_type_to_mime_type($imagetype));

if($imagetype == IMAGETYPE_PNG)
{
	imagepng($myimg);	// Display the image as a PNG image.
}
else if($imagetype == IMAGETYPE_JPEG)
{
	imagejpeg($myimg);	// Display the image as a JPEG image.
}
else if($imagetype == IMAGETYPE_GIF)
{
	imagegif($myimg);	// Display the image as a GIF image (probably not supported)
}

	imagedestroy($myimg);	// free the resource (or we would get a memory leak)
?>
