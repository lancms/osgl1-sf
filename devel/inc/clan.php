<?php

require_once ('config/config.php');

if (!config("usepage_compo"))
{
	nicedie($msg['1']);
}

$action = $_GET['action'];

if (getcurrentuserid() == 1)
{
	nicedie(lang("You have to be logged in to view this page!", "inc_clan", "Error-msg to display in inc/clan if you are not logged in"));
}


if (!isset($action))
{
	$q = query("SELECT * FROM Clan WHERE moderator = '".escape_string(getcurrentuserid())."'");
	if (num($q) == 0)
	{
		echo $clan[3];
	}
	else
	{
		while($r = fetch($q))
		{
			echo "<br><a href=?inc=clan&action=edit&edit=$r->ID>$r->name</a>";
		}
	}
	if (num($q) < 3)
	{
	?>
	<br><br><hr><br><form method=POST action=index.php?inc=clan&action=addclan>
	<?php echo $clan[2]; ?><input type=text name=name>
	<br><?php echo $form[25]; ?><input type=text name=password>
	<br><textarea name=about rows=5 cols=35><?php echo $clan[4]; ?></textarea>
	<input type=submit value='<?php echo $clan[5]; ?>'>
	</form>
	<?php
	} // end if(num($q) < 3)
}
elseif($action == "addclan")
{
	$name = $_POST['name'];
	$password = $_POST['password'];
	$cpass = crypt_pwd($password);
	$about = addslashes($_POST['about']);

	$test = query("SELECT * FROM Clan WHERE name LIKE '".escape_string($name)."'");
	if (num($test) != 0)
	{
		nicedie($clan[7]);
	}
	query("INSERT INTO Clan SET name = '".escape_string($name)."',
			password = '".escape_string($password)."',
			about = '".escape_string($about)."',
			moderator = '".escape_string(getcurrentuserid())."'");
	echo $form[40];
	echo $clan[6];
	refresh("index.php?inc=clan", 5);
}
elseif (($action == "edit") && (isset($_GET['edit'])))
{
	$edit = $_GET['edit'];
	if (!mayEditClan($edit))
	{
		nicedie($msg[25]);
	}
	$q = query("SELECT * FROM Clan WHERE ID = '".escape_string($edit)."'");
	$r = fetch($q);

	echo "<table><form method=POST action=index.php?inc=clan&action=doedit&edit=$r->ID>";
	echo "<tr><td>";
	echo "$clan[2]";
	echo "<input type=text name=name value='$r->name'>";
	echo "$form[25]";
	echo "<input type=text name=password value='$r->password'>";
	echo "<textarea name=about rows=5 cols=35>$r->about</textarea>";
	echo "</td></tr><tr><td>";
	echo "<input type=submit value='".$clan[8]."'>";
	echo "</form></table>";
}

elseif (($action == "doedit") && (isset($_GET['edit'])))
{
	$edit = $_GET['edit'];
	if (!mayEditClan($edit))
	{
		nicedie($msg['25']);
	}

	$name = $_POST['name'];
	$password = $_POST['password'];
	$about = $_POST['about'];
	$test = query("SELECT * FROM Clan WHERE name LIKE '".escape_string($name)."' AND ID != '".escape_string($edit)."'");
	if (num($test) != 0)
	{
		nicedie($clan7);
	}

	query("UPDATE Clan SET name = '".escape_string($name)."',
			password = '".escape_string($password)."',
			about = '".escape_string($about)."'
			WHERE ID = '".escape_string($edit)."'");
	echo "$clan[9]";
	refresh("index.php?inc=clan", 2);
}
else
{
nicedie();
}

?>
