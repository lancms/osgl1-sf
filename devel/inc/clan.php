<?php
require_once 'config/config.php';
if(!config("usepage_compo"))
	nicedie("Vi bruker IKKE compooppsettet, nei!");

$action = $_GET['action'];

if(!isset($action)) {
	$q = query("SELECT * FROM Clan WHERE moderator = ".getcurrentuserid());
	if(num($q) == 0) echo "Du er ikke moderator for noen klaner :)";
	else while($r = fetch($q)) {
		echo "<br><a href=?inc=clan&action=edit&edit=$r->ID>$r->name</a>";
	}
	if(num($q) < 3) {
	?>
	<br><br><hr><br><form method=POST action=index.php?inc=clan&action=addclan>
	<input type=text name=name> Klannavn
	<br><input type=text name=password> Passord
	<br><textarea name=about rows=5 cols=35>dette er en beskrivelse av klanen min</textarea>
	<input type=submit value='Legg til klanen'>
	</form>
	<?php
	} // end form hvis man har mindre enn fire klaner
	
}

elseif($action == "addclan") {
	$name = $_POST['name'];
	$password = $_POST['password'];
	$cpass = crypt_pwd($password);
	$about = addslashes($_POST['about']);
	
	$test = query("SELECT * FROM Clan WHERE name LIKE '$name'");
	if(num($test) != 0) die("Klanen eksisterer alt");
	query("INSERT INTO Clan SET name = '$name',
			password = '$password',
			about = '$about',
			moderator = ".getcurrentuserid());
	echo "Klanen $name er lagt inn med $password som passord. Du er satt som moderator!";
	echo "<br>Vent litt, så flytter jeg deg tilbake til siden";
	refresh("index.php?inc=clan", 5);
}
elseif($action == "edit" && isset($_GET['edit'])) {
	$edit = $_GET['edit'];
	if(!mayEditClan($edit)) die("Du har ikke tilgang til dette av en eller annen merkelig grunn...");
	$q = query("SELECT * FROM Clan WHERE ID = ".$edit);
	$r = fetch($q);
	
	echo "<table><form method=POST action=index.php?inc=clan&action=doedit&edit=$r->ID>";
	echo "<tr><td>";
	echo "<input type=text name=name value='$r->name'>";
	echo "</td><td>Klannavn</td></tr><tr><td>";
	echo "<input type=text name=password value='$r->password'>";
	echo "</td><td>Klanpassord</td></tr><tr><td>";
	echo "<textarea name=about rows=5 cols=35>$r->about</textarea>";
	echo "</td></tr><tr><td>";
	echo "<input type=submit value='Lagre klanen'>";
	echo "</form></table>";
}

elseif($action == "doedit" && isset($_GET['edit'])) {
	$edit = $_GET['edit'];
	if(!mayEditClan($edit))
		nicedie("Du har ikke tilgang til dette av en eller annen merkelig grunn...");

	$name = $_POST['name'];
	$password = $_POST['password'];
	$about = $_POST['about'];
	$test = query("SELECT * FROM Clan WHERE name LIKE '$name' AND ID != $edit");
	if(num($test) != 0)
		nicedie("Beklager, det klannavnet er allerede i bruk :/ ");
	
	query("UPDATE Clan SET name = '$name',
			password = '$password',
			about = '$about'
			WHERE ID = $edit");
	echo "klanen er oppdatert";
	refresh("index.php?inc=clan", 2);
}

else echo "hmmm, nope; ingen slike ting der";
