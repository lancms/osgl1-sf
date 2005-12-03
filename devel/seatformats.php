<?php
/* some initializers */
$width = 0;
$height = 0;

$i=0;
$j=0;
$k=0;
$c="";

$zoomedin = false;
if(isset($_GET["zoom"]))
	if($_GET["zoom"] == "on")
		$zoomedin = true;

if($zoomedin)			// $zoomedin; are we going to show names?
{
	$xscale = 8;		// if true, we must size up the scale
	$yscale = 8;
}
else
{
	$xscale = 8;		// false, we must keep them as small as possible
	$yscale = 8;
}

$name_maxlen = 6;		// maximum length of names displayed.

$font_size = 6;

$yscale = (int)($yscale * ($font_size / 5));

$myfile = file("room.ini");	// load room

$height = count($myfile);	// array length = height

$imagetype = IMAGETYPE_PNG;	// image type constant

$addwidth = $yscale;		// get the yscale

if($zoomedin)
	$addwidth += $name_maxlen * ($font_size - 1); // if zoomedin then cell width must be a little larger


for($i=0;$i<$height;$i++)
{
	if(strlen($myfile[$i]) > $width)	// find out which column is largest to get the width.
		$width = strlen($myfile[$i]);
}

$seat_char[0] = "-";		// character codes for cells
$seat_char[1] = "d";
$seat_char[2] = "c";
$seat_char[3] = "v";
$seat_char[4] = "";
$seat_char[5] = "/";
$seat_char[6] = "k";
$seat_char[7] = "n";

$seat_avail[0] = 0;		// this is to see if we must print and create area maps or not
$seat_avail[1] = 1;
$seat_avail[2] = 2;
$seat_avail[3] = 3;
$seat_avail[4] = 0;
$seat_avail[5] = 0;
$seat_avail[6] = 0;
$seat_avail[7] = -1;

?>
