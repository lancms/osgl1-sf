<?php
require_once 'config/config.php';
if(!acl_access("ACL")) die($admin[noaccess]);
$action = $_GET['action'];
$edit = $_GET['edit'];

if(!isset($action)) {
	$q = query("SELECT * FROM groups");
	echo "<table>";
	while($r = fetch($q)) {
		echo "<tr><td>";
		echo "<a href=admin.php?adminmode=acl&action=edit&edit=$r->ID>$r->groupname</a>";
		echo "</td><td>";
		echo "<a href=admin.php?adminmode=acl&action=rename&edit=$r->ID>Rename</a>";
		echo "</td><td>";
		echo "<a href=admin.php?adminmode=acl&action=delete&edit=$r->ID>Delete</a>";
		echo "</td></tr>";
	}
	echo "</table>";
	
	echo "<br><br><br><hr><br>";
	echo "<form method=POST action=admin.php?adminmode=acl&action=add>";
	echo "<input type=text name=groupname><input type=submit value='Legg til gruppe'>";
	echo "</form>";
}

elseif($action == "add") {
	$groupname = $_POST['groupname'];
	$test = query("SELECT * FROM groups WHERE groupname LIKE '$groupname'");
	if(num($test) != 0) die("Gruppen eksisterer allerede");
	query("INSERT INTO groups SET groupname = '$groupname'");
	refresh("admin.php?adminmode=acl", 0);
}

elseif($action == "edit" && isset($edit)) {
	echo "<a href=admin.php?adminmode=acl>Tilbake til Gruppeadmin</a><br>";
	
	echo "<form method=POST action=admin.php?adminmode=acl&action=updateGroup&edit=$edit>";
	echo "<table>";
	for($i = 0;$i<count($acl);$i++) {
		$this_acl = $acl[$i];
		$q = query("SELECT * FROM acls WHERE groupID = '$edit' AND access = '".$this_acl['access']."'");
		$r = fetch($q);
		if(num($q) == 0) $select = 0;
		else $select = $r->value;
		echo "<tr><td><input type=checkbox name='".$this_acl['access']."'";
		if($select) echo " CHECKED";
		echo " value=1></td><td> ".$this_acl['name'];
		echo "</td></tr>";
	}
	echo "</table>";
	echo "<br><input type=submit value='Lagre gruppen'>";
	echo "</form>";
	
	$q2 = query("SELECT * FROM users WHERE myGroup = $edit");
	echo "Members: (".num($q2).")";
	echo "<table>";
	while($r2 = fetch($q2)) {
		echo "<tr><td>";
		display_nick($r2->ID);
		echo "</td></tr>";
	}
	echo "</table>";
	
}

elseif($action == "updateGroup") {
	$edit = $_GET['edit'];
	for($i=0;$i<count($acl);$i++) {
		$this_acl = $acl[$i];
		$this_access = $this_acl['access'];
		//echo $this_acl['access'];
		$post = $_POST[$this_access];
		
		$test = query("SELECT * FROM acls WHERE groupID = $edit AND access = '$this_access'");
		if(num($test) == 0) {
			query("INSERT INTO acls SET groupID = $edit,
					access = '$this_access',
					value = '$post'");
		} else {
			query("UPDATE acls SET value = '$post' WHERE access = '$this_access' AND groupID = $edit");
		} // End check if acl exists
		
	} // End for-loop
	refresh("admin.php?adminmode=acl&action=edit&edit=$edit", 0);
} 

elseif($action == "delete" && isset($edit)) {
$confirm = $_GET['confirm'];
	if($confirm == "YES") {
		query("DELETE FROM groups WHERE ID = $edit");
		query("DELETE FROM acls WHERE groupID = $edit");
		query("UPDATE users SET myGroup = 1 WHERE myGroup = $edit");
		refresh("admin.php?adminmode=acl", 2);
		echo "Group deleted";
	}
	else {
		$q = query("SELECT * FROM groups WHERE ID = $edit");
		$r = fetch($q);
		echo "Delete group: ".$r->groupname."?";
		echo "<br>";
		echo "<a href=admin.php?adminmode=acl&action=delete&edit=$edit&confirm=YES>Yes</a> - ";
		echo "<a href=admin.php?adminmode=acl>No</a>";
	}
	
}
elseif($action == "rename" && isset($edit)) {
	$q = query("SELECT * FROM groups WHERE ID = $edit");
	$r = fetch($q);
	echo "<form method=POST action=admin.php?adminmode=acl&action=dorename&edit=$edit>\n";
	echo "<input type=text name=name value='$r->groupname'><input type=submit value='Change name'>";
	echo "</form>";
} elseif($action == "dorename" && isset($edit)) {
	$newName = $_POST['name'];
	query("UPDATE groups SET groupname = '$newName' WHERE ID = $edit");
	echo "Groupname changed to $newName";
	refresh("admin.php?adminmode=acl", 2);
}