<?php
require_once $base_path.'config/config.php';

if(!acl_access("compopoll")) die($admin[noaccess]);

$action = $_GET['action'];

if(!isset($action)) $action = "listCompos"; /* {
echo "<br><li><a href=admin.php?adminmode=compopolladmin&action=listCompos>Compoliste</a>";

}
*/

if($action == "listCompos") {
$q = query("SELECT SUM(answer),pollID FROM compoPollA GROUP BY pollID ORDER BY 'SUM(answer)' DESC;");

echo "<table>";
echo "<tr><th>Componavn</th>";
for($i=0;$i<count($compopoll);$i++) echo "<th>$compopoll[$i]</th>\n";
echo "</tr>";
while($rordered = fetch($q)) {
	$q2 = query("SELECT * FROM compoPoll WHERE ID = ".$rordered->pollID);
	$r = fetch($q2);
	$data = NULL;
	$possible = 0;
	$total = 0;
	echo "<tr><td>";
	echo $r->question;
	echo "</td>";
	for($i=0;$i<count($compopoll);$i++) {
		$q2 = query("SELECT * FROM compoPollA WHERE pollID = $r->ID AND answer = $i");
		echo "<td>".num($q2)."</td>";
		if($i != 0) $minus = 1;
		else $minus = 0;
		
		$total = $total + (num($q2) * ($i - $minus));
		$possible = num($q2);
		
		
	} // End for
	echo "<td>".$total;
	//$procent = ($possible * 4) / $total * 100;
	//echo "</td><td>$procent %";
	echo "</td></tr>";
	} // end while
echo "</table>";

?>
<form method=POST action=admin.php?adminmode=compopolladmin&action=addcompo>
<br><input type=text name=componame size=25>
<br><input type=submit value='Legg til avstemningsspørsmål'>
</form>
<?php


} // end action listcompos

elseif($action == "addcompo") {
$question = stripslashes($_POST['componame']);

query("INSERT INTO compoPoll SET question = '$question'");
refresh("admin.php?adminmode=compopolladmin&action=listCompos", 0);

} // end action addcompo
