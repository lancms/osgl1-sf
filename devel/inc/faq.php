<?php

require_once 'config/config.php';

if(!config("usepage_faq"))
{
	nicedie($msg[1]);
}

$query = query("SELECT * FROM faq ORDER BY ID");


$rows = num($query);
if($rows == 0) {
	echo $form[43];
	return;
}
for($i=0;$i<$rows;$i++) {
	$result = fetch_array($query);
	$ID = $result[0];
	$q = $result[2];
	$a = $result[3];

	echo "<br><li><a href=#$ID>Q: $q</a>";

}
$query = query("SELECT * FROM faq ORDER BY ID");
echo "<br><hr>";

for($k=0;$k<$rows;$k++) {
	$result = fetch_array($query);
	$ID = $result[0];
	$posted_by = $result[1];
	$q = $result[2];
	$a = nl2br($result[3]);

	echo "<br><br>";
	if($k != 0) {
		echo "<hr>";
	}

	echo "<br><a name=#$ID><b>Q: $q</a></b><br>";
	if($_COOKIE['userrank'] == 2) {
		$select = query("SELECT nick FROM users WHERE ID = '".mysql_escape_string($posted_by)."'");
		$selected = fetch_array($select);
		echo "<font size=-1>".$msg[2].$selected[0]."</font>";
	}
	echo "<br><i>A: </i>$a";
}

?>
