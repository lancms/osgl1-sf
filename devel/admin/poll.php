<?php

require_once ('config/config.php');

if (!acl_access("poll"))
{
	nicedie ($admin['noaccess']);
}

if (isset($_GET['action']))
{
	$action = $_GET['action'];
}
else
{
	$action = "list";
}

$poll = $_GET['poll'];

if ($action == "list")
{
	echo "<table>";

	$query = query("SELECT * FROM pollQ");

	$num = num($query);

	for($o=0;$o<$num;$o++)
	{
		$row = fetch($query);

		echo "<tr><td>$row->text</td>";

		echo "<td><a href=admin.php?adminmode=poll&action=delete&poll=$row->ID>".lang("Delete", "admin_poll", "form[16]")."</a></td>";

		echo "<td><a href=admin.php?adminmode=poll&action=edit&poll=$row->ID>".lang("Edit", "admin_poll", "form[17]")."</a></td>";

		echo "<td><a href=admin.php?adminmode=poll&action=reset&poll=$row->ID>".lang("Reset votes", "admin_poll", "form[19]")."</a></td>";

		if($row->isOpen == 1)
		{
			$toggle = lang ("Close", "admin_poll", "form[23]");
		}
		else
		{
			$toggle = lang ("Open", "admin_poll", "form[22]");
		}

		echo "<td><a href=admin.php?adminmode=poll&action=toggle&poll=$row->ID>$toggle</a></td>";

		echo "</tr>";
	}
	
	echo "</table>";

	?>

	<form method=post action=admin.php?adminmode=poll&action=add>

	<input type=text name=pollQ size=25> <?php echo lang ("Vote-question", "admin_poll", "form[45]"); ?>

	<br><input type=text name=maxV value=1 size=2> <?php echo lang ("Number of votes per user", "admin_poll", "form[44]"); ?>

	<br><input type=submit value='<?php echo lang ("Add", "admin_poll", "form[7]"); ?>'>

	</form>

	<?php

}
elseif (($action == "delete") && (isset($poll)))
{
	query("DELETE FROM pollQ WHERE ID = '".escape_string($poll)."'");

	query("DELETE FROM pollA WHERE QID = '".escape_string($poll)."'");

	query("DELETE FROM pollVoted WHERE pollID = '".escape_string($poll)."'");

	refresh("admin.php?adminmode=poll", "0");
}

elseif ($action == "add")
{
	$pollQ = $_POST['pollQ'];

	$maxVotes = $_POST['maxV'];

	$query = query("INSERT INTO pollQ SET text = '".escape_string($pollQ)."', maxVotes = '".escape_string($maxVotes)."'");

	refresh("admin.php?adminmode=poll", "0");

}
elseif (($action == "edit") && (isset($poll)))
{
	$queryQ = query("SELECT * FROM pollQ WHERE ID = '".escape_string($poll)."'");

	$queryA = query("SELECT * FROM pollA WHERE QID = '".escape_string($poll)."'");

	$rowQ = fetch($queryQ);

	echo "<center>$rowQ->text</center>";

	if(num($queryA) == 0)
	{
		echo "<br><br>".lang("Please add some <b>answers</b>!", "admin_poll", "form[21]");
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

	<input type=submit value='<?php echo lang ("Add", "admin_poll", "form[7]"); ?>'>

	</form>

	<?php

}
elseif(($action == "addanswer") && (isset($poll)))
{
	$answer = $_POST['answer'];

	if (!isset($answer))
	{
		nicedielang ("Error: You forgot to enter an answer.", "admin_poll", "form[38]");
	}
	
	$query = query("INSERT INTO pollA SET Atext = '".escape_string($answer)."', QID = '".escape_string($poll)."'");

	refresh("admin.php?adminmode=poll&action=edit&poll=$poll", "0");

}
elseif(($action == "toggle") && (isset($poll)))
{
	$query = query("SELECT isOpen FROM pollQ WHERE ID = '".escape_string($poll)."'");

	$row = fetch($query);

	if($row->isOpen == 1)
	{
		$isOpen = 0;
	}
	else
	{
		$isOpen = 1;
	}

	query("UPDATE pollQ SET isOpen = '".escape_string($isOpen)."' WHERE ID = '".escape_string($poll)."'");

	refresh("admin.php?adminmode=poll", "0");

}
elseif($action == "reset" && isset($poll))
{
	query("UPDATE pollA SET votes = 0 WHERE QID = '".escape_string($poll)."'");

	query("DELETE FROM pollVoted WHERE pollID = '".escape_string($poll)."'");

	refresh("admin.php?adminmode=poll", 0);
}

?>
