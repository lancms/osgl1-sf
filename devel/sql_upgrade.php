<?php
include_once 'config/config.php';

$upgrade_file = "docs/mysql_tables.sql";
if($sql_mode != "upgrade") {
	die("Something is wrong here.... includeing the upgrade-file without setting $sql_mode = upgrade!");
}
$i = 0;
$y = 0;
$file = fopen($upgrade_file, "r");

while($line = fgets($file, 128)) {
	if($line == "\n");
	elseif($line == "\r");
	/* Line is a comment from mysqldump */
	elseif(stristr($line, "--"));
	/* We dont want the inserts, just the structure */
	elseif(stristr($line, "INSERT"));
	elseif(stristr($line, ")"));
	else {
		if(stristr($line, "CREATE TABLE ")) {
			$table_name = explode(" ", $line);
			$table[$i]['TABLE_NAME'] = $table_name[2];
			echo $table[$i]['TABLE_NAME']."\n\r\n\r";
		} else {
			$exploded = explode(" ", $line);
			$table[$i][$y] = $exploded[0];
			echo $exploded[1]."\n\r";
		}

	}

}
