<?php

require_once 'config/config.php';
if(!acl_access("isCrew"))
	die($admin[noaccess]);

$query = query("SELECT users.ID AS 'ID', users.nick AS 'Nick', groups.groupname AS 'Group', users.EMail AS 'Email', users.cellphone AS 'Phonenumber' FROM users, groups, acls WHERE users.myGroup=groups.ID AND acls.groupID=groups.ID AND (acls.access='listaddress' OR acls.access='root') AND acls.value=1 GROUP BY users.ID ORDER BY users.ID");

$num = mysql_num_rows($query);

echo "<table border=1 cellspacing=1>";
/* Create headers */
$column_count = mysql_num_fields($query);

echo "<tr>";
for($column_num = 0;$column_num < $column_count;$column_num++) {
	$field_name = mysql_field_name($query, $column_num);
	echo "<th>$field_name</th>\n";
}
echo "</tr>\n\n";
$num_rows = mysql_num_rows($query);
/* Add data from the database */
for($i=0;$i<mysql_num_rows($query);$i++) {
	echo "<tr>";
	$field_number = mysql_num_fields($query);

	for($y=0;$y<$field_number;$y++) {

		$k = mysql_result($query,$i,$y);

		if($y==0) {
			echo "<td><a href=index.php?inc=profile&uid=$k>$k</a></td>\n";
		} else {
			echo "<td>$k</td>\n";
		}

	}
	echo "</tr>";
}



echo "</table>";
echo "<br><br>";
?>
