<?php

require 'config/config.php';

if(!acl_access("poll"))
	nicedie($admin[noaccess]);


if(isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	$action = "list";
}

$poll = mysql_escape_string ($_GET['poll']);



if($action == "list")
{
	echo "<table>";

	$query = query("SELECT * FROM pollQ");

	$num = num($query);

	for($o=0;$o<$num;$o++)
	{
		$row = fetch($query);

		echo "<tr><td>$row->text</td>";

		echo "<td><a href=admin.php?adminmode=poll&action=delete&poll=$row->ID>$form[16]</a></td>";

		echo "<td><a href=admin.php?adminmode=poll&action=edit&poll=$row->ID>$form[17]</a></td>";

		echo "<td><a href=admin.php?adminmode=poll&action=reset&poll=$row->ID>$form[19]</a></td>";

		if($row->isOpen == 1)
		{
			$toggle = $form[23];
		}

		else $toggle = $form[22];

		echo "<td><a href=admin.php?adminmode=poll&action=toggle&poll=$row->ID>$toggle</a></td>";

		echo "</tr>";
	}
	
	echo "</table>";

	?>

	<form method=post action=admin.php?adminmode=poll&action=add>

	<input type=text name=pollQ size=25> <?php echo $form[45]; ?>

	<br><input type=text name=maxV value=1 size=2> <?php echo $form[44]; ?>

	<br><input type=submit value='<?php echo $form[7]; ?>'>

	</form>

	<?php

}
elseif(($action == "delete") && (isset($poll)))
{
	query("DELETE FROM pollQ WHERE ID = $poll");

	query("DELETE FROM pollA WHERE QID = $poll");

	query("DELETE FROM pollVoted WHERE pollID = $poll");

	refresh("admin.php?adminmode=poll", "0");
}

elseif($action == "add")
{
	$pollQ = mysql_escape_string ($_POST['pollQ']);

	$maxVotes = mysql_escape_string ($_POST['maxV']);

	$query = query("INSERT INTO pollQ SET text = '$pollQ', maxVotes = $maxVotes");

	refresh("admin.php?adminmode=poll", "0");

}
elseif($action == "edit" && isset($poll))
{
	$queryQ = query("SELECT * FROM pollQ WHERE ID = $poll");

	$queryA = query("SELECT * FROM pollA WHERE QID = $poll");

	$rowQ = fetch($queryQ);

	echo "<center>$rowQ->text</center>";

	if(num($queryA) == 0)
	{
		echo "<br><br>".$form[21];
	}
	else
	{
		for($A=0;$A<num($queryA);$A++)
		{
			$rowA = fetch($queryA);

			echo "<br>$rowA->Atext";
		}
	}
	?>

	<br><br>

	<form method=post action=admin.php?adminmode=poll&action=addanswer&poll=<?php echo $poll; ?>>

	<input type=text name=answer>

	<br>

	<input type=submit value='<?php echo $form[7]; ?>'>

	</form>

	<?php

}
elseif(($action == "addanswer") && (isset($poll)))
{
	$answer = mysql_escape_string ($_POST['answer']);

	if(!isset($answer))
	{
		die($form[38]);
	}
	
	$query = query("INSERT INTO pollA SET Atext = '$answer', QID = $poll");

	refresh("admin.php?adminmode=poll&action=edit&poll=$poll", "0");

}
elseif(($action == "toggle") && (isset($poll)))
{
	$query = query("SELECT isOpen FROM pollQ WHERE ID = $poll");

	$row = fetch($query);

	if($row->isOpen == 1)
	{
		$isOpen = 0;
	}
	else
	{
		$isOpen = 1;
	}

	query("UPDATE pollQ SET isOpen = $isOpen WHERE ID = $poll");

	refresh("admin.php?adminmode=poll", "0");

}
elseif($action == "reset" && isset($poll))
{
	query("UPDATE pollA SET votes = 0 WHERE QID = $poll");

	query("DELETE FROM pollVoted WHERE pollID = $poll");

	refresh("admin.php?adminmode=poll", 0);
}

?>
