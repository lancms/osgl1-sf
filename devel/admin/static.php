<?php
	require_once 'config/config.php';

	if(!acl_access("static"))
	{
		nicedie($admin[noaccess]);
	}

	if(isset($_GET['action']))
	{
		$action = $_GET['action'];
	}



	if(!isset($action))
	{
	?>
		<form method=GET action=admin.php>
		<input type=hidden name=adminmode value=static>
		<input type=hidden name=action value=edit>
		<select name=edit>
	<?php
		$q = query("SELECT * FROM static");
		while($r = fetch($q)) {
		echo "<option value='$r->header'>$r->header</option>\n";
	}
	?>
		</select>
		<input type=submit value='<?php echo $form['73'] ?>'></form>
		<form method=post action=admin.php?adminmode=static&action=new>
		<br><br>
		<input type=text name=filename>
		<br><input type=submit value='<?php echo $form[47]; ?>'>
		</form>
	<?php
		echo "<br>$form[48]";
	}

	if(($action == "edit") && (isset($_GET['edit'])))
	{
		$file = mysql_escape_string ($_GET['edit']);
		$q = query("SELECT * FROM static WHERE header = '$file'");
		$r = fetch($q);
		echo "<form method=post action=admin.php?adminmode=static&action=doedit>";
		echo "<input type=hidden name=edit value='".$_GET['edit']."'>";
		echo "<textarea name=edittext rows=15 cols=75>";
		echo stripslashes($r->text);
		echo "</textarea><input type=submit value='$form[15]'></form>";
		echo "<br><br><a href=admin.php?adminmode=static&action=delete&edit=$file>".lang("Delete this page!", "admin_static", "Admin->static->edit->Delete this page")."</a>";
	}
	elseif(($action == "doedit") && (isset($_POST['edit'])))
	{
		$edittext = mysql_escape_string (stripslashes ($_POST['edittext']))
		$edit = mysql_escape_string ($_POST['edit']);
		
		if(!isset($edittext))
		{
			nicedie($form['72']);
		}
		
		if(!isset($edit))
		{
			nicedie();
		}
		
		$lastEdit = time();
		$lastEditBy = getcurrentuserid();
		$text = addslashes($edittext);
		
		query("UPDATE static SET text = '$text', lastEdit = '$lastEdit', lastEditBy = '$lastEditBy' WHERE header = '$edit'");
		echo lang("Updated page. Saving to database, stand by", "admin_static", "Text to display when a static file is saved");
		refresh("admin.php?adminmode=static", 2);
	}
	elseif(($action == "new") && (isset($_POST['filename'])))
	{
		$file = mysql_escape_string ($_POST['filename']);

		$query = query ("SELECT ID FROM static WHERE header = '".$file."'");
		$fetch = fetch ($query);
		$num = num ($query);
	
		if (($file == "") || ($file == " "))
		{
			refresh ("admin.php?adminmode=static", 2);
			$errmsg = lang ("Missing filename.", "admin_static", "Text to display when missing filename for static page");
			nicedie ($errmsg);
		}
		elseif ($num != "0")
		{
			refresh ("admin.php?adminmode=static", 2);
			$errmsg = lang ("A page with that name already exists.", "admin_static", "Text to display when filenames for static pages conflict");
			nicedie ($errmsg);
		}
		else
		{
			query("INSERT INTO static SET header = '$file'");
			refresh("admin.php?adminmode=static&action=edit&edit=$file");
			dblog(7, $file);
		}
	}
	elseif(($action == "delete") && ($_GET['confirmed'] != 1) && (isset($_GET['edit'])))
	{
		$edit = $_GET['edit'];
		echo lang("Are you sure you wish to delete this page?", "admin_static", "String to show if you have selected to delete a page");
		echo " <a href=admin.php?adminmode=static&action=delete&confirmed=1&edit=$edit>".lang("Yes", "admin_static", "Yes, I wish to delete that f**** static page")."</a>&nbsp;&nbsp;&nbsp;";
	}
	elseif(($action == "delete") && ($_GET['confirmed'] == 1) && (isset($_GET['edit'])))
	{
		$edit = mysql_escape_string ($_GET['edit']);
		$q = query("SELECT * FROM static WHERE header = '$edit'");
		
		if(num($q) == 0)
		{
			nicedie("No, there is no such page to be deleted!");
		}

		query("DELETE FROM static WHERE header = '$edit'");
		refresh("admin.php?adminmode=static", 2);
		echo lang("File deleted", "admin_static", "Text to display after that file was deleted");
		dblog(8, $edit);
	}
	
?>
