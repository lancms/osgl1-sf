<?php

require 'config/config.php';

if(!acl_access("wannabe"))  
	nicedie($admin[noaccess]);

$action = $_GET['action'];

if(!isset($action)) {
	echo "<a href=admin.php?adminmode=wannabemin&action=edittext>Rediger wannabeinfo</a>";
	echo "<br><a href=admin.php?adminmode=wannabemin&action=listWannabes>Se hvem som søker</a>";
	
}

elseif($action == "edittext") {
	echo "<form method=POST action=admin.php?adminmode=wannabemin&action=doedittext>";
	echo "<textarea name=tekst cols=75 rows=25>";
	$qT = query("SELECT * FROM config WHERE config = 'wannabetext'");
	$rT = fetch($qT);
	echo $rT->large;
	echo "</textarea><input type=submit value='Lagre'></form>";
}

elseif($action == "doedittext") {
	$tekst = $_POST['tekst'];
	config("wannabetext", 1);
	query("UPDATE config SET large = '$tekst' WHERE config = 'wannabetext'");
	refresh("admin.php?adminmode=wannabemin", 0);
}

elseif($action == "listWannabes") {
	$q = query("SELECT * FROM users WHERE wannabe = 1 AND isCrew = 0 AND wannabeDenied != 1");
	echo "<table>";
	while($r = fetch($q)) {
		
		$test = query("SELECT * FROM wannabe WHERE ID = $r->ID");
		if(num($test) == 1) {
			$haveIQ = query("SELECT * FROM wannabeAdmin WHERE userID = $r->ID AND adminID = ".getcurrentuserid());
			$haveI = fetch($haveIQ);
			if($haveI->shoudBeCrew == 1) $image = "ja";
			else $image = "nei";
			echo "<tr><td>";
			if(num($haveIQ) != 0) echo "<img src=images/".$image.".gif>";
			echo "</td><td>";
			echo "<a href=?adminmode=wannabemin&action=viewUserApplication&user=$r->ID>$r->nick</a>";
			echo "</td><td>";
		
			$comments = query("SELECT * FROM wannabeAdmin WHERE userID =
					'$r->ID'");
			echo "(".num($comments).")";
			echo "</td><td>";
			echo $r->name;
			echo "</td><td>";
			echo $r->cellphone;
			echo "</td><td>";
			echo $r->EMail;
			echo "</td></tr>";
			
		}
		else;
			//echo "<br>".$r->nick;
	}
	echo "</table>";

}

elseif($action == "viewUserApplication") {
	$user = mysql_escape_string ($_GET['user']);
	$q = query("SELECT * FROM wannabe WHERE ID = $user");
	$r = mysql_fetch_row($q);
	
	$column_count = mysql_num_fields($q);
	
	echo "<table><tr><td>";
	echo "<a href=admin.php?adminmode=wannabemin&action=listWannabes>Tilbake til listen</a></td><td>";
	echo "Info om: ";
	display_nick($user);
	echo "</td></tr>";
	


for($column_num = 1;$column_num < $column_count;$column_num++) {
	$field_name = mysql_field_name($q, $column_num);
	$Left = $wannabe[$field_name];
	$data = $r[$column_num];
	if($data == "1") $data = "<img src=images/ja.gif>";
	elseif($data == "0") $data = "<img src=images/nei.gif>";
	if($field_name == "lastUpdated") $data = convert_timestamp($data);
	else $data = nl2br($data);
	$Right = $data;
	profile_table($Left, $Right);
}
echo "</table>\n\n";

$qu = query("SELECT * FROM wannabeAdmin WHERE userID = $user");
echo "<table>";
while($ru = fetch($qu)) {
	if($ru->adminID == getcurrentuserid()) {
		echo "<form method=POST action=admin.php?adminmode=wannabemin&action=editAdminInfo&user=$user>";
		echo "<tr><td></td><td>";
		if($ru->shoudBeCrew) $selected = "CHECKED";
		echo "<input type=checkbox name=shoudBeCrew value=1 $selected> Anbefales?";
		echo "</td><td>";
		echo "<textarea name=moreinfo cols=50 rows=7>$ru->moreinfo</textarea>";
		echo "</td><td><input type=submit value='Lagre oppdatering'></form>";
	} else {
		echo "<tr><td>";
		echo display_nick($ru->adminID);
		echo "</td><td>";
		$data = $ru->shoudBeCrew;
		if($data == "1") $data = "<img src=images/ja.gif>";
		elseif($data == "0") $data = "<img src=images/nei.gif>";
		echo $data;
		echo "</td><td>$ru->moreinfo</td></tr>";
	}
	
	
	
}
	$test = query("SELECT * FROM wannabeAdmin WHERE adminID = ".getcurrentuserid()." AND userID = $user");
	if(num($test) == 0) echo "<tr><td><a href=?adminmode=wannabemin&action=addComment&user=$user>Legg til kommentar</a></td></tr>";
	//else echo "<tr><td>Du har vist lagt inn fra før på denne brukeren....</td></tr>";
	echo "</table>";
	
} elseif($action == "addComment") {
	$user = mysql_escape_string ($_GET['user']);
	query("INSERT INTO wannabeAdmin SET adminID = '".getcurrentuserid()."', userID = '$user'");
	refresh("admin.php?adminmode=wannabemin&action=viewUserApplication&user=$user", 0);
} elseif($action == "editAdminInfo") {
	$user = mysql_escape_string ($_GET['user']);
	$shoudBeCrew = mysql_escape_string ($_POST['shoudBeCrew']);
	$moreinfo = mysql_escape_string  ($_POST['moreinfo']);
	$adminID = mysql_escape_string (getcurrentuserid());
	query("UPDATE wannabeAdmin SET
			moreinfo = '$moreinfo',
			shoudBeCrew = '$shoudBeCrew',
			lastUpdated = ".time()."
			WHERE userID = '$user' AND adminID = '$adminID'");
	refresh("?adminmode=wannabemin&action=viewUserApplication&user=$user", 0);
}


elseif($action == "viewAllApplication") {
	
	$q = query("SELECT * FROM wannabe");
	while($r = mysql_fetch_row($q)) {
	$user = $r[0];
	
	$column_count = mysql_num_fields($q);
	
	echo "<table><tr><td>";
	echo "<a href=admin.php?adminmode=wannabemin&action=listWannabes>Tilbake til listen</a></td><td>";
	echo "Info om: ";
	display_nick($user);
	echo "</td></tr>";
	


for($column_num = 1;$column_num < $column_count;$column_num++) {
	$field_name = mysql_field_name($q, $column_num);
	$Left = $wannabe[$field_name];
	$data = $r[$column_num];
	if($data == "1") $data = "<img src=images/ja.gif>";
	elseif($data == "0") $data = "<img src=images/nei.gif>";
	if($field_name == "lastUpdated") $data = convert_timestamp($data);
	else $data = nl2br($data);
	$Right = $data;
	profile_table($Left, $Right);
}
echo "</table>\n\n";

$qu = query("SELECT * FROM wannabeAdmin WHERE userID = $user");
echo "<table>";
while($ru = fetch($qu)) {
	
		echo "<tr><td>";
		echo display_nick($ru->adminID);
		echo "</td><td>";
		$data = $ru->shoudBeCrew;
		if($data == "1") $data = "<img src=images/ja.gif>";
		elseif($data == "0") $data = "<img src=images/nei.gif>";
		echo $data;
		echo "</td><td>$ru->moreinfo</td></tr>";
	
	
	
	
}
	$test = query("SELECT * FROM wannabeAdmin WHERE adminID = ".getcurrentuserid()." AND userID = $user");
	if(num($test) == 0) echo "<tr><td><a href=?adminmode=wannabemin&action=addComment&user=$user>Legg til kommentar</a></td></tr>";
	//else echo "<tr><td>Du har vist lagt inn fra før på denne brukeren....</td></tr>";
	echo "</table>";
}
	
}
