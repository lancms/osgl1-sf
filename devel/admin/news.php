<?php

require 'config/config.php';

if(!acl_access("news")) die($admin[noaccess]);

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "list";
}
$editID = $_GET['editID'];

if($action == "add") {

	$header = $_POST['header'];

	$text = $_POST['text'];

	$me = getcurrentuserid();

	$query = mysql_query("INSERT INTO news SET header = '$header', text = '$text', poster = $me") or die(mysql_error());



	refresh("admin.php?adminmode=news", "0");



}



elseif($action == "list") {

	$q = mysql_query("SELECT * FROM news ORDER BY ID DESC") or die(mysql_error());

	echo "<table>";

	while($r = mysql_fetch_object($q)) {

		echo "<tr><td>";

		echo $r->header;

		echo "</td><td>";

		echo "<a href=admin.php?adminmode=news&action=delete&editID=$r->ID>$form[16]</a>";

		echo "</td></tr>";

	}

	echo "</table>";

	?>

	<form method=post action=admin.php?adminmode=news&action=add>

	<input type=text name=header size=60>

	<br><textarea name=text rows=7 cols=60></textarea>

	<br><input type=submit value='<?php echo $form[7]; ?>'>

	</form>

	<?php

}

elseif($action == "delete" && isset($editID)) {

	mysql_query("DELETE FROM news WHERE ID = $editID");

	refresh("admin.php?adminmode=news", 0);

}

?>