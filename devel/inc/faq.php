<?php

require_once 'config/config.php';

if(!config("usepage_faq")) die($msg[1]);

db_connect();

$query = mysql_query("SELECT * FROM faq ORDER BY ID");


$rows = mysql_num_rows($query);
if($rows == 0) {
	echo $form[43];
	return;
}
for($i=0;$i<$rows;$i++) {
	$result = mysql_fetch_row($query);
	$ID = $result[0];
	$q = $result[2];
	$a = $result[3];

	echo "<br><li><a href=#$ID>Q: $q</a>";

}
$query = mysql_query("SELECT * FROM faq ORDER BY ID");
echo "<br><hr>";

for($k=0;$k<$rows;$k++) {
	$result = mysql_fetch_row($query);
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
		$select = mysql_query("SELECT nick FROM users WHERE ID = '$posted_by'") or die(mysql_error());
		$selected = mysql_fetch_row($select);
		echo "<font size=-1>".$msg[2].$selected[0]."</font>";
	}
	echo "<br><i>A: </i>$a";
}

?>