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
	
	
	$q2 = query("SELECT * FROM tasks_log WHERE taskID = $edit");
	
	while($r2 = fetch($q2)) {
		echo "<br><br><hr><br>";
		echo IDtonick($r2->userID).": ".$r2->logText;
	}
	echo "<form method=POST action=admin.php?adminmode=tasks&action=addcomment&edit=$edit>";
	echo "<textarea cols=65 rows=10 name=comment>";
	echo "<br><input type=submit value='".lang("Add comment", "admin_tasks", "Submit-button to add comment on a task")."'>";
	echo "</form>";
	
}

elseif($action == "addcomment" && isset($edit)) {
	$comment = $_POST['comment'];
	query("INSERT INTO tasks_log SET userID = ".getcurrentuserid().", taskID = $edit, logUNIX = ".time().", logText = '$comment'");
	refresh("admin.php?adminmode=tasks&action=edit&edit=$edit", 2);
	echo lang("Comment added", "admin_tasks", "Text to display after a comment has been added.");
}