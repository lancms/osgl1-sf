<?php
require_once 'config/config.php';
if(!acl_access("compomaster")) die($admin[noaccess]);

$action = $_GET['action'];

if(!isset($action)) {
	$q = query("SELECT * FROM compo");

	echo "<table>";

	while($r = fetch($q)) {
	echo "<tr><td><a href=admin.php?adminmode=compomaster&action=edit&edit=$r->ID>$r->name</a></td><td>";
	echo $compotype[$r->gameType];
	echo "</td><td>";
	echo "<a href=?adminmode=compomaster&action=toggleopen&edit=$r->ID>";
	if($r->isOpen == 1) echo $form['23'];
	else echo $form['22'];
	echo "</a>";
	echo "</td><td>";
	echo "<a href=?adminmode=compomaster&action=seed&edit=$r->ID>".$compo['18']."</a>";
	echo "</td><td>";
	echo $compo['19']." ";
	$qU = query("SELECT * FROM compoReg WHERE compoID = $r->ID");
	$qC = query("SELECT DISTINCT clanID FROM compoReg WHERE compoID = $r->ID");
	echo num($qU)." ".$compo['20'];
	if($r->gameType > 1) echo " ".$compo['21']." ".num($qC)." ".$compo['22'];
	echo "</td></tr>";

	} // End while fetch()
	echo "</table>";

	echo "<br><br><hr><br>";
	echo "<form method=POST action=admin.php?adminmode=compomaster&action=addnew>
		<input type=text name=componame> ".$form['68']."
		<br><input type=submit value='".$form['7']."'>
		</form>";

} // End action not set

elseif($action == "addnew") {
	$componame = $_POST['componame'];
	if(empty($componame))
		nicedie($form['69']);
	query("INSERT INTO compo SET name = '$componame'");
	refresh("admin.php?adminmode=compomaster",5, 0);

}

elseif($action == "edit" && isset($_GET['edit'])) {
	if(isset($_GET['text'])) echo "<font color=red>".$_GET['text']."</font><br>";
	echo "<div align=left><a href=admin.php?adminmode=compomaster>".$msg['32']."</a></div><br>";
	$edit = $_GET['edit'];

	$q = query("SELECT * FROM compo WHERE ID = $edit");
	$r = fetch($q);

	echo "<form method=POST action=admin.php?adminmode=compomaster&action=doedit&edit=$edit>";
	echo "<input type=text name=componame value='$r->name'> ".$form['68']."
	<br><input type=text name=players value='$r->players'> ".$form['70']."
	<br><input type=text name=roundPlayers value='$r->roundPlayers'> ".$form['71']."
	<br>";
	echo "<select name=gameType>";
	for($i=0;$i<count($compotype);$i++) {
	echo "<option value=$i";
	if($r->gameType == $i) echo " SELECTED";
	echo ">$compotype[$i]</option>\n";
	} // End for
	echo "</select>";
	echo "<br><textarea name=rules rows=30 cols=80>$r->rules</textarea>";
	echo "<br><input type=submit value='".$form['15']."'>";
	echo "</form>";

} // end action == edit

elseif($action == "doedit") {
	$edit = $_GET['edit'];

	$componame = $_POST['componame'];
	$gameType = $_POST['gameType'];
	$players = $_POST['players'];
	$rules = $_POST['rules'];
	$roundPlayers = $_POST['roundPlayers'];


	query("UPDATE compo SET name = '$componame',
			gameType = $gameType,
			players = $players,
			rules = '$rules',
			roundPlayers = $roundPlayers

			WHERE ID = $edit");
	refresh("admin.php?adminmode=compomaster&action=edit&edit=$edit&text=Redigert", 0);
} elseif($action == "toggleopen") {
	$edit = $_GET['edit'];

	$q = query("SELECT * FROM compo WHERE ID = $edit");
	$r = fetch($q);

	if($r->isOpen == 1) $isOpen = 0;
	else $isOpen = 1;

	query("UPDATE compo SET isOpen = $isOpen WHERE ID = $edit");
	refresh("admin.php?adminmode=compomaster", 0);
}
elseif($action == "seed") {
	$edit = $_GET['edit'];
	$compo = query("SELECT * FROM compo WHERE ID = $edit");
	$compR = fetch($compo);
	if($compR->gameType <= 1) {
		echo "<table>";
		$q = query("SELECT * FROM compoReg WHERE compoID = $edit");
		while($r = fetch($q)) {
			echo "<tr><td>";
			display_nick($r->userID);
			echo "</td><td>";
			echo $r->seed;
			echo "</td><td>";
			echo "<a href=?adminmode=compomaster&action=seededit&seed=up&edit=$edit&user=$r->userID>".$compo['23']."</a>";
			echo "</td><td>";
			echo "<a href=?adminmode=compomaster&action=seededit&seed=down&edit=$edit&user=$r->userID>".$compo['24']."</a>";
			echo "</td></tr>";
		} // end while fetch
		echo "</table>";
	} // end if compotype <= 1


} // End if action = seed

elseif($action == "seededit") {
	echo $msg['33'];
	$seed = $_GET['seed'];
	$compo = $_GET['edit'];
	$user = $_GET['user'];
	$clan = $_GET['clan'];
	if(isset($user) && $user > 1) {
		// Dette er en oneplayer-compo
		if($seed == "up") query("UPDATE compoReg SET seed = seed + 10 WHERE compoID = $compo AND userID = $user");
		else query("UPDATE compoReg SET seed = seed - 10 WHERE compoID = $compo AND userID = $user");
	} // end if user-compo
	else {
		// compo is clan-compo
		if($seed = "up") query("UPDATE compoReg SET seed = seed + 10 WHERE compoID = $compo AND clanID = $clan");
		else query("UPDATE compoReg SET seed = seed - 10 WHERE compoID = $compo AND clanID = $clan");
	} // End if clancompo
	refresh ("admin.php?adminmode=compomaster&action=seed&edit=$compo", 0);
}
else nicedie();
