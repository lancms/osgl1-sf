<?php

require 'config/config.php';
if(!acl_access("tasks")) die($admin[noaccess]);

$action = $_GET['action'];
$edit = $_GET['edit'];

if(!isset($action)) {
	//echo lang("My tasks", "admin_tasks", "My tasks heading");
	$q = query("SELECT * FROM tasks ORDER BY userID = ".getcurrentuserid()." DESC, userID = 1");
	if(num($q) != 0) {
		echo "<table>";
		echo "<tr><th>".lang("Task", "admin_tasks", "Table header, Task name");
		echo "</th><th>".lang("Assigned to", "admin_tasks", "Table header, Task Assigned to");
		echo "</th><th>".lang("Completed %", "admin_tasks", "Table header, Task Completed %");
		echo "</th></tr>";
	}

	while($r = fetch($q)) {
	echo "<tr><td><a href=admin.php?adminmode=tasks&action=edit&edit=$r->ID>";
	echo $r->name;
	echo "</a></td><td>";
	echo IDtonick($r->userID);
	echo "</td><td>";
	echo $r->complete." %";
	echo "</td></tr>";

	}

	echo "</table><br><br>";


	echo "<form method=POST action=admin.php?adminmode=tasks&action=add>";
	echo "<input type=text name=name> ".lang("Task name", "admin_tasks", "Form-field Task Name");
	echo "<br><input type=submit value='".lang("Add task", "admin_tasks", "Form submit: add task")."'>";
	echo "</form>";

}

elseif($action == "add") {
	$name = $_POST['name'];
	$exists = query("SELECT * FROM tasks WHERE name = '$name'");
	if(num($exists) != 0) nicedie(lang("Sorry, but the task has already been added.", "admin_tasks", "Task-error: task already added").refresh("admin.php?adminmode=tasks", 2));

	query("INSERT INTO tasks SET name = '$name'");
	echo lang("Task added, returning to task index", "admin_tasks", "Task added, returning to index of tasks");
	refresh("admin.php?adminmode=tasks", 2);
}

elseif($action == "edit" && isset($edit)) {
	$q = query("SELECT * FROM tasks WHERE ID = $edit");
	$r = fetch($q);
	echo lang("Task name: ", "admin_tasks", "Task name in edit").$r->name;
	echo "<br>";
	echo lang("Assigned to: ", "admin_tasks", "Assigned to on edit").IDtonick($r->userID);
	//echo "<br>";
	echo "<form method=GET action=admin.php>
			<input type=hidden name=adminmode value=tasks>
			<input type=hidden name=action value=changeuser>
			<input type=hidden name=edit value='$edit'>
		";
	$users = reverse_acl("tasks"); // Should return a query of all users that has access to tasks...
	echo "<select name=changeuser>";
	while($chuser = fetch($users)) {
		if($chuser->ID == getcurrentuserid()) $selected = "SELECTED";
		echo "<option value=$chuser->ID $selected>$chuser->nick</option>";
	}
	echo "</select>";
	echo "<input type=submit value='".lang("Change assigned user", "admin_tasks", "form-submit to change user in tasks")."'>";
	echo "</form>";

	echo "<form method=POST action=admin.php?adminmode=tasks&action=changeComplete&edit=$edit>";
	echo "<select name=complete>";
	for($i=0;$i<11;$i++) {
		$display_as = $i."0";
		if($r->complete == $display_as) $celected = " SELECTED";
		echo "<option value=$display_as".$celected.">$display_as%</option>";
	}
	echo "</select>";
	echo "<input type=submit value='".lang("Change completeness", "admin_tasks", "form-submit to change completeness")."'>";
	echo "</form>";



	$q2 = query("SELECT * FROM tasks_log WHERE taskID = $edit");

	while($r2 = fetch($q2)) {
		echo "<br><br><hr><br>";
		echo IDtonick($r2->userID).": ".$r2->logText;
	}
	echo "<br><br><form method=POST action=admin.php?adminmode=tasks&action=addcomment&edit=$edit>";
	echo "<textarea cols=65 rows=10 name=comment></textarea>";
	echo "<br><input type=submit value='".lang("Add comment", "admin_tasks", "Submit-button to add comment on a task")."'>";
	echo "</form>";

}

elseif($action == "addcomment" && isset($edit)) {
	$comment = $_POST['comment'];
	query("INSERT INTO tasks_log SET userID = ".getcurrentuserid().", taskID = $edit, logUNIX = ".time().", logText = '$comment'");
	refresh("admin.php?adminmode=tasks&action=edit&edit=$edit", 2);
	echo lang("Comment added", "admin_tasks", "Text to display after a comment has been added.");
}
// admin.php?adminmode=tasks&action=changeuser&edit=<taskID>&changeuser=<userID>
elseif($action == "changeuser" && isset($edit) && isset($_GET['changeuser'])) {
	$chuser = $_GET['changeuser'];

	query("UPDATE tasks SET userID = $chuser WHERE ID = $edit");
	query("INSERT INTO tasks_log SET userID = ".getcurrentuserid().", taskID = $edit, logUNIX = ".time().", logText = '".lang("Changed assigned to user to: ", "admin_tasks", "What to put into the SQL-table when a user changes who a task is assigned to").IDtonick($chuser)."'");

	echo lang("Changed assigned user successfully", "admin_tasks", "What to display after we have changed the user a task is assigned to");
	refresh("admin.php?adminmode=tasks&action=edit&edit=$edit", 2);
}

elseif($action == "changeComplete" && isset($edit)) {
	$complete = $_POST['complete'];

	query("UPDATE tasks SET complete = $complete WHERE ID = $edit");
	query("INSERT INTO tasks_log SET userID = ".getcurrentuserid().", taskID = $edit, logUNIX = ".time().", logText = '".
		lang("Changed completed percentage to: $complete", "admin_tasks", "Text to insert into the tasks_log-table after the %-completed is changed")."'");
	echo lang("Changed completeness successfully", "admin_tasks", "Text to display after we have changed the completed-percentage");
	refresh("admin.php?adminmode=tasks&action=edit&edit=$edit", 2);
}