<?php

// XXX: Typo in filename... :-P

require_once ('config/config.php');

if (!acl_access("isCrew"))
{
   nicedie(lang("DIIIIIIIIIIIIIE!! No access!", "inc_adressbook", "No access-text in addressbook"));
}

$query = query ("SELECT users.ID AS '".lang("ID", "addressbook", "UserID-column in SELECT in addressbook")."',
	users.nick AS '".lang("nick", "addressbook", "nick-column in SELECT in addressbook")."',
	groups.groupname AS '".lang("Groupname", "addressbook", "Groupname-column in SELECT in addressbook")."',
	users.EMail AS '".lang("EMail", "addressbook", "EMail-column in SELECT in addressbook")."',
	users.cellphone AS '".lang("Phonenumber", "addressbook", "Phonenumber-column in SELECT in addressbook")."' FROM users, groups, acls WHERE users.myGroup=groups.ID AND acls.groupID=groups.ID AND (acls.access='listaddress' OR acls.access='root') AND acls.value=1 GROUP BY users.ID ORDER BY groups.groupname");

$num = num ($query);

echo "<table border=1 cellspacing=1>";
/* Create headers */
$column_count = num_fields ($query);

echo "<tr>";
for ($column_num = 1;$column_num < $column_count;$column_num++)
{
	/* XXX: Userfunction for this! */
	$field_name = mysql_field_name($query, $column_num);
	echo "<th>$field_name</th>\n";
}
echo "</tr>\n\n";
$num_rows = num ($query);
/* Add data from the database */
for ($i=0; $i < $num_rows; $i++)
{
	echo "<tr>";
	$field_number = num_fields($query);

	for ($y=0; $y < $field_number; $y++)
	{
		/*
		 * Uh, what does this do?
		 * XXX: Userfunction.
		 */
		 // I still wonder what this do. :-)
		$k = mysql_result ($query, $i, $y);

		if ($y==0)
		{
			$crewID = $k;
		/*	echo "<td><a href=index.php?inc=profile&uid=$k>$k</a></td>\n"; */
		}
		elseif($y == 1) {
			echo "<td><a href=index.php?inc=profile&uid=$crewID>$k</a></td>\n";
		}
		else
		{
			echo "<td>$k</td>\n";
		}
	}
	echo "</tr>";
}

echo "</table>";
echo "<br><br>";
?>
