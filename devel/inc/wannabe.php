<?php

require_once 'config/config.php';

$action = $_GET['action'];
$user = getcurrentuserid();

// Isn't there some other, nicer way to do this, or does my mind play tricks on me again?
if (getcurrentuserid() == 1)
{
	nicedie(lang("Please login and try again"));
}

if (!isset($action))
{
	$query = sprintf ("SELECT * FROM users WHERE ID = %s", escape_string($user));
	$result = query($query);

	$var = fetch($result);

	//$Agree = $var->wannabe;
	if($var->wannabeDenied == 1) {
		echo lang("Sorry, your application has been denied by the admins. You are not allowed to view or edit your application again. Please apply again at our next event.", "inc_wannabe", "Text to display if users.wannabeDenied == 1");
		nicedie();
	}

	if ($var->wannabe == 1)
	{
		$Agree = " checked";
		$query = "SELECT * FROM wannabeQue";
	}
	else $query = "SELECT * FROM wannabeQue WHERE 0"; // Not showing any questions

	$list = "
	<form name='SelQue' method='post' action='index.php?inc=wannabe&action=EndQue'>
	 <table>
	  <tr>
	   <td><b>".lang("Wannabe", "inc_wannabe", "Text to display in wannabe")."</b></td>
	  </tr>
	  <tr>
	   <td><input type='checkbox' name='Agree' value='1'".$Agree.">".lang("Yes, I want to be a crew member.", "inc_wannabe", "Text to display in wannabe")."<br><br></td>
	  </tr>
	 ";
	
	//$query = "SELECT * FROM wannabeQue";
	$result = query($query);

	while ($var = fetch($result))
	{
		$ID = $var->ID;
		$Que = $var->content;
		$Type = $var->type;

		$list .= "
		<tr>
		 <td><b>".$Que."<b></td>
		</tr>
		";


		if ($Type == 1)
		{
			$query2 = sprintf ("SELECT * FROM wannabeAlt WHERE queID = %s", escape_string($ID));
			$result2	= query($query2);

			while($var2 = fetch($result2))
			{
				$AltID = $var2->ID;
				$Alt = $var2->content;

				$query3 = sprintf ("SELECT * FROM wannabeUsers WHERE user = %s AND  queID = %s", escape_string($user), escape_string($ID));
				$result3 = query($query3);

				$Sel = fetch($result3);
				$SelID = $Sel->ans;
				$Check = "";

				if ($SelID == $AltID)
				{
					$Check = " checked";
				}

			$list .= "
				<tr>
					<td><input type='radio' name='".$ID."' value='".$AltID."'".$Check.">".$Alt."</td>
				</tr>
				";
			}
		}
		else
		{
			$query4 = sprintf ("SELECT * FROM wannabeUsers WHERE user = %s AND queID = %s", escape_string($user), escape_string($ID));
			$result4 = query($query4);
			$Answ = fetch($result4);

			$Text = $Answ->ans;

			$list .= "
				<tr>
					<td><textarea name='$ID'>".$Text."</textarea></td>
				</tr>
				";
		}

		$list .= "
			<tr>
				<td>&nbsp;</td>
			</tr>
			";
	}
	$list .= "
		<tr>
			<td><input type='submit' name='Submit' value='".lang("Save", "inc_wannabe", "Text to display in wannabe")."'></td>
		</tr>
	</table>
</form>
		";
	echo $list;
}
elseif ($action == "EndQue")
{
	$Agree = $_POST['Agree'];
	
	if ($Agree == 1)
	{
		// Shortcut?
		$q4 = sprintf("UPDATE users SET wannabe = '1' WHERE ID = %s", escape_string($user)); // Just as easy
		$result4 = query($q4);
		$query = "SELECT * FROM wannabeQue";
		$result = query($query);

		while ($Res = fetch($result))
		{
			$ID = $Res->ID;
			$post = $_POST[$ID];

			if (empty($post))
			{
				// Ugly; ut we do not care if the user has answered the question...d
				//echo lang("Please answer all the questions!<br>\n", "admin_wannabemin", "Text used in wannabemin");
			}

			if (!empty($post))
			{
				$ans = $_POST[$ID];

				// XXX: Is this the first $query4?
				$query4 = sprintf ("SELECT * FROM wannabeUsers WHERE queID = %s AND user = %s", escape_string($ID), escape_string($user));
				$result4 = query($query4);
				$num = num($result4);

				if ($num >= 1)
				{
					$query2 = sprintf ("UPDATE wannabeUsers SET ans = '%s' WHERE queID = %s AND user = %s", escape_string($ans), escape_string($ID), escape_string($user));
				}
				else
				{
					$query2 = sprintf ("INSERT INTO wannabeUsers (ID, user, ans, queID) VALUES (NULL, %s, '%s', %s)", escape_string($user), escape_string($ans), escape_string($ID));
				}
				// XXX: This part need some explanation!
				$result2 = query ($query2);
				
		   }
		}
		echo lang("Updated !", "inc_wannabe", "Text to display in wannabe");
		refresh("index.php?inc=wannabe", 2);
	}
	else
	{
		echo lang("Updated: You will not be a crew member.", "inc_wannabe", "Text to display in wannabe");
		// Shortcut?
		query(sprintf("UPDATE users SET wannabe = '0' WHERE ID = %s", escape_string($user)));
		refresh("index.php?inc=wannabe", 2);
	}
}
?>
