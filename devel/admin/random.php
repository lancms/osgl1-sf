<?php
/* This module is not maintained any more! */
require 'config/config.php';

if(getuserrank() != 2) 
	nicedie($admin[noaccess]);

$action = $_GET['action'];

if(!isset($action)) {
	?>
	<form method=post action=admin.php?adminmode=random&action=add>
	<textarea name=text cols=60 rows=10></textarea>
	<input type=submit value='<?php echo $form[15]; ?>'>
	</form>
	<?php
} elseif($action == "add") {
	$text = mysql_escape_string ($_POST['text']);
	
	if(empty($text) || !isset($text)) 
		nicedie($form['72']);
	
	query("INSERT INTO random SET text = '$text'");
	echo $msg['36'];
	refresh("admin.php?adminmode=random", 0);
}
