<?php
require 'config/config.php';

if(!acl_access("faq"))
	nicedie($admin[noaccess]);




if(isset($_GET['action'])) {
	$action = $_GET['action'];
}

db_connect();

if(!isset($action)) {



	$query = mysql_query("SELECT * FROM faq ORDER BY ID ASC");

	for($i=0;$i<mysql_num_rows($query);$i++) {
		$result = mysql_fetch_object($query);

		echo "<br>$result->question <a href=admin.php?adminmode=faq&action=delete&ID=".
		$result->ID.
		">$form[16]</a> <a href=admin.php?adminmode=faq&action=edit&ID=".$result->ID.">$form[17]</a>\n";

	}

	?>

	<form method=post action=admin.php?adminmode=faq&action=insert>
	<br><input type=text size=25 name=question> ?
	<br><textarea rows=10 cols=75 name=answer></textarea> !
	<br><input type=submit value='<?php echo $form[7]; ?>'>
	</form>
	<?php

} elseif($action == "delete") {
	if(!isset($_GET['ID']))
		nicedie($form[6]);

	$delID = $_GET['ID'];

	$query = query("DELETE FROM faq WHERE ID = '$delID'");

	echo $msg['34']." ".$delID." ".$msg['35'];

} elseif($action == "insert") {
	if(empty($_POST['question'])) nicedie($form[6]);
	if(empty($_POST['answer'])) nicedie($form[6]);

	$q = $_POST['question'];
	$a = $_POST['answer'];
	$poster = $_COOKIE['userID'];

	$query = query("INSERT INTO faq SET
	posted_by = '$poster',
	question = '$q',
	answer = '$a'
	");

	echo $msg['7'];
	refresh("admin.php?adminmode=faq");
} elseif($action == "edit") {
	$editID = $_GET['ID'];
	if(!isset($editID)) nicedie();

	$select = query("SELECT * FROM faq WHERE ID = $editID");
	$row = fetch($select);
	echo $row->question;
	echo "<form method=post action=admin.php?adminmode=faq&action=doedit&edit=$editID>";
	echo "<textarea name=edittext cols=75 rows=10>";
	echo $row->answer;
	echo "</textarea><input type=submit value='$form[15]'>";
	echo "</form>";
} elseif($action == "doedit") {
	$editID = $_GET['edit'];
	$text = addslashes($_POST['edittext']);
	$update = query("UPDATE faq SET answer = '$text' WHERE ID = '$editID'");

	if($update) refresh("admin.php");
	echo $msg[7];
}

?>
