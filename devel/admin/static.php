<?php
require 'config/config.php';

if(!acl_access("static")) die($admin[noaccess]);


if(isset($_GET['action'])) {
	$action = $_GET['action'];
}



if(!isset($action)) {

	?>
	<form method=GET action=admin.php>
	<input type=hidden name=adminmode value=static>
	<input type=hidden name=action value=edit>
	<select name=edit>
	<?php
	$q = mysql_query("SELECT * FROM static") or die(mysql_error());
	while($r = mysql_fetch_object($q)) {
		echo "<option value='$r->header'>$r->header</option>\n";
	}

	//echo "<option value=index>index</option>\n";
	?>
	</select>
	<input type=submit value='Rediger siden'></form>
	<form method=post action=admin.php?adminmode=static&action=new>
	<br><br>
	<input type=text name=filename>
	<br><input type=submit value='<?php echo $form[47]; ?>'>
	</form>
	<?php
	echo "<br>$form[48]";
}

if($action == "edit" && isset($_GET['edit'])) {
	$file = $_GET['edit'];
	$q = mysql_query("SELECT * FROM static WHERE header = '$file'");
	$r = mysql_fetch_object($q);
	echo "<form method=post action=admin.php?adminmode=static&action=doedit>";
	echo "<input type=hidden name=edit value='".$_GET['edit']."'>";
	echo "<textarea name=edittext rows=15 cols=75>";
	echo stripslashes($r->text);
	echo "</textarea><input type=submit value='$form[15]'></form>";

}
elseif($action == "doedit" && isset($_POST['edit'])) {
	$edittext = stripslashes($_POST['edittext']);
	$edit = $_POST['edit'];
	if(!isset($edittext)) die("WTF????? No text?");
	if(!isset($edit)) die("WTF??? No file to edit?");
	$lastEdit = time();
	$lastEditBy = getcurrentuserid();
	$text = addslashes($edittext);
	mysql_query("UPDATE static SET text = '$text', lastEdit = '$lastEdit', lastEditBy = '$lastEditBy' WHERE header = '$edit'") or die(mysql_error());

	refresh("admin.php?adminmode=static");
}
elseif($action == "new" & isset($_POST['filename'])) {
	$file = $_POST['filename'];
	mysql_query("INSERT INTO static SET header = '$file'");

	refresh("admin.php?adminmode=static&action=edit&edit=$file");
}
?>
