<?php

require 'config/config.php';

if(getuserrank() != 2) 
	nicedie($admin[noaccess]);

$action = $_GET['action'];


if(!isset($action)) {
	echo '<table cellspacing=1 border=1>';
	
	$query = query("SELECT * FROM compo");
	
	echo "<tr><th>$compo[14]</th><th>$compo[15]</th><th>$compo[16]</th><th>$compo[17]</th></tr>";
	
	while($row = fetch($query)) {
		echo "<tr><td>$row->name</td><td>$row->caption</td><td>$row->gameType</td><td>$row->players</td></tr>";
	}
	
	echo "</table>";
	?>
	<form method=post action=admin.php?adminmode=compo&action=add>
	<br><input type=text name=shortname> <?php echo $compo[14]; ?>
	<br><input type=text name=longname> <?php echo $compo[15]; ?>
	<br><input type=text name=gametype> <?php echo $compo[16]; ?>
	<br><input type=text name=players size=3> <?php echo $compo[17]; ?>
	<br><input type=submit value='<?php echo $form[15]; ?>'>
	</form>
	<?php
} elseif($action == "add") {
	$shortname = $_POST['shortname'];
	$longname = $_POST['longname'];
	$gametype = $_POST['gametype'];
	$players = $_POST['players'];
	
	$insert = query("INSERT INTO compo SET name = '".escape_string($shortname)."', 
		caption = '".escape_string($longname)."',
		gameType = '".escape_string($gametype)."',
		players = '".escape_string($players)."'
	");
		
	if($insert)
	{
		refresh("admin.php?adminmode=compo", 0);
	}
	echo "Compo added";
}
