<?php

require 'config/config.php';

if(getuserrank() != 2) 
	die($admin[noaccess]);

$action = $_GET['action'];

if(!isset($action)) {
	?>
	<form method=post action=admin.php?adminmode=random&action=add>
	<textarea name=text cols=60 rows=10></textarea>
	<input type=submit value='<?php echo $form[15]; ?>'>
	</form>
	<?php
} elseif($action == "add") {
	$text = $_POST['text'];
	
	if(empty($text) || !isset($text)) die("You should probably put *something* inside your quote....");
	
	mysql_query("INSERT INTO random SET text = '$text'") or die(mysql_error());
	echo "Added";
	refresh("admin.php?adminmode=random", 0);
}