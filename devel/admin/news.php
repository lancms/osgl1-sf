<?php

require_once ('config/config.php');

if (!acl_access("news"))
{
	nicedie($admin[noaccess]);
}

if (isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	$action = "list";
}

$editID = $_GET['editID'];

if ($action == "add")
{

	$header = $_POST['header'];

	$text = $_POST['text'];

	$me = getcurrentuserid();

	$query = query("INSERT INTO news SET header = '".escape_string($header)."', text = '".escape_string($text)."', poster = '".escape_string($me)."', logUNIX = ".time());

	refresh("admin.php?adminmode=news", "0");
}
elseif ($action == "list")
{
	$q = query("SELECT * FROM news ORDER BY ID DESC");

	echo "<table>";

	while($r = fetch($q))
	{
		echo "<tr><td>";

		echo $r->header;

		echo "</td><td>";

		echo "<a href=admin.php?adminmode=news&action=delete&editID=$r->ID>$form[16]</a>";
		echo " <a href=admin.php?adminmode=news&action=edit&editID=$r->ID>$form[17]</a>";

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
elseif (($action == "delete") && (isset($editID)))
{
	query("DELETE FROM news WHERE ID = '".escape_string($editID)."'");
	refresh("admin.php?adminmode=news", 0);
}
elseif (($action == "edit") && (isset($editID)))
{
	$query= sprintf ("SELECT * FROM news WHERE ID=%s", escape_string($editID));
	$result = query ($query);
	$row = fetch ($result);

	echo '
	<form method=post action=admin.php?adminmode=news&action=editsave&editID='.$editID.'>

	<input type=text name=header size=60 value='.$row->header.'>

	<br><textarea name=text rows=7 cols=60>'.$row->text.'</textarea>

	<br><input type=submit value='.$form[15].'>

	</form>
	';
}
elseif (($action == "editsave") && (isset($editID)))
{
	/* errorchecking is for whimps. */
	$header = $_POST['header'];

	$text = $_POST['text'];

	$me = getcurrentuserid();
	
	$query = sprintf ('UPDATE news SET text="%s", header="%s", poster=%s, logUNIX=%s WHERE ID=%s', escape_string($text), escape_string($header), $me, time(), escape_string($editID));

	query ($query);
	refresh("admin.php?adminmode=news", "0");
}


?>
