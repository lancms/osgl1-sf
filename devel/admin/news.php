<?php

require 'config/config.php';

if(!acl_access("news"))
	nicedie($admin[noaccess]);

if(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "list";
}
$editID = mysql_escape_string ($_GET['editID']);

if($action == "add") {

	$header = mysql_escape_string ($_POST['header']);

	$text = mysql_escape_string ($_POST['text']);

	$me = mysql_escape_string (getcurrentuserid());

	$query = query("INSERT INTO news SET header = '$header', text = '$text', poster = $me");

	refresh("admin.php?adminmode=news", "0");
}



elseif($action == "list") {

	$q = query("SELECT * FROM news ORDER BY ID DESC");

	echo "<table>";

	while($r = fetch($q)) {

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

	query("DELETE FROM news WHERE ID = $editID");

	refresh("admin.php?adminmode=news", 0);

}

?>
