<?php
require 'config/config.php';

if (!acl_access("wannabe"))
{
	nicedie(lang("DIIIIIIIIIIIIIE!! No access!", "admin_wannabemin", "No access text in wannabemin"));
}

$action = $_GET['action'];
$user	= getcurrentuserid();

if (!isset($action))
{
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=addQue'>".lang("Add question", "admin_wannabemin", "Text to display in wannabe admin menu")."</a><br>";
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=ViewUsers'>".lang("View Users", "admin_wannabemin", "Text to display in wannabe admin menu")."</a>";
}

if ($action == "addQue")
{
	$query = "SELECT * FROM wannabeQue";
	$result = query($query);

	$list = "
	<table>
	 <tr>
	  <td><b>".lang("Questions:", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	 </tr>
	 ";

	while ($var = fetch($result))
	{
		$ID = $var->ID;
		$Que = $var->content;

		$list .=	"
			<tr>
			<td><a href='admin.php?adminmode=wannabemin&action=EditQue&id=$ID'>".$Que."</a></td>
			<td><a href='admin.php?adminmode=wannabemin&action=DelQue&id=$ID'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
			</tr>
			";
	}
	$list	.= "
		<tr>
		<td><a href='admin.php?adminmode=wannabemin&action=AddNewQue'>".lang("Add new question", "admin_wannabemin", "Text used in wannabemin")."</a></td>
		</tr>
		</table>
		";

	echo $list;

}
elseif ($action == "EditQue")
{

	$ID = $_GET['id'];

	if (empty($ID))
	{
		nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));
	}

	$query = sprintf ("SELECT * FROM wannabeQue WHERE ID=%s", escape_string($ID));
	$result = query($query);
	$var = fetch($result);

	$Que = $var->content;
	$Type = $var->type;

	if ($Type == 1)
	{
		$list = "
			<option value='2'>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
			<option value='1' selected>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</option>
			";
	}
	else
	{
		$list = "
			<option value='2' selected>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
			<option value='1'>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</option>
			";
	}

	echo "
	<form name='editQue' method='post' action='admin.php?adminmode=wannabemin&action=DoEditQue'>
	<input type='hidden' name='id' value='".$ID."'>
	 <table>
	  <tr>
	   <td><b>".lang("Edit Question", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	  </tr>
	  <tr>
	   <td>".lang("Question:", "admin_wannabemin", "Text used in wannabemin")."</td>
	   <td><textarea cols=60 rows=10 name='Que'>".$Que."</textarea>
	  </tr>
	  <tr>
	   <td>".lang("Type:", "admin_wannabemin", "Text used in wannabemin")."</td>
	   <td>
	    <select name='Type'>
		 ".$list."
		</select>
	   </td>
	  </tr>
	  <tr>
	   <td><input type='submit' name='Submit' value='".lang("Edit", "admin_wannabemin", "Text used in wannabemin")."'></td>
	  </tr>
	 </table>
	</form>
	";

}
elseif ($action == "DoEditQue")
{
	$Que = $_POST['Que'];
	$Type = $_POST['Type'];
	$ID = $_POST['id'];

	if ((empty($ID)) || (empty($Que)) || (empty($Type)))
	{
		nicedie(lang("Nope, this is not the way you should do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin"));
	}

	$query = sprintf ("UPDATE wannabeQue SET content='%s', type='%s' WHERE ID=%s", escape_string($Que), escape_string($Type), escape_string($ID));
	$result = query($query);

	if ($Type == 1)
	{
		echo lang("Time to add some alternatives.", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$ID", 2);
	}
	else
	{
		echo lang("Question has been edited", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin", 2);
	}
}
elseif ($action == "DelQue")
{
	$ID = $_GET['id'];

	if (empty($ID))
	{
		nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));
	}

	$query = sprintf ("DELETE FROM wannabeQue WHERE ID=%s", escape_string($ID));
	$result = query($query);

	echo lang("Question has been deleted", "admin_wannabemin", "Text to display in wannabemin&action=DelRadioAlt");

	refresh("admin.php?adminmode=wannabemin", 2);
}
elseif ($action == "AddAlt")
{
	$ID = $_GET['id'];

	if (empty($ID))
	{
	 $ID = $_POST['id'];
	}
	
	if (empty($ID))
	{
		nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));
	}

	$query = sprintf ("SELECT * FROM wannabeAlt WHERE QueID = %s", escape_string($ID));
	$result = query($query);

	$list = "
		<form name='addAlt' method='post' action='admin.php?adminmode=wannabemin&action=DoAddAlt'>
		<input type='hidden' name='QueID' value='".$ID."'>
		<table>
		<tr>
		<td><b>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</b></td>
		</tr>
		";

	while ($var = fetch($result))
	{
		$AltID = $var->ID;
		$Alt = $var->content;

		$list .= "
			<tr>
				<td>".lang("Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
				<td>".$Alt."</td>
				<td><a href='admin.php?adminmode=wannabemin&action=DelAlt&id=$AltID'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
			</tr>
			";
	}
	
	$list .= "
		<tr>
			<td>".lang("New Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
			<td><input type='text' name='Alt'></td>
		</tr>
		<tr>
			<td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text used in wannabemin")."'></td>
			<td><a href='admin.php?adminmode=wannabemin'>".lang("Save", "admin_wannabemin", "Text used in wannabemin")."</a></td>
		</tr>
		</table>
		</form>
	";
	echo $list;
}
elseif ($action == "DoAddAlt")
{
	$QueID = $_POST['QueID'];
	$Alt = $_POST['Alt'];

	if ((empty($QueID)) || (empty($Alt)))
	{
		nicedie(lang("Nope, this is not the way you should do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin"));
	}

	$query = sprintf ("INSERT INTO wannabeAlt (ID, content, queID) VALUES (NULL, '%s', %s)", escape_string($Alt), escape_string($QueID));
	$result = query($query);

	$query = sprintf ("SELECT * FROM wannabeAlt WHERE queID = %s", escape_string($QueID));
	$result = query($query);

	$list = "
		<form name='addAlt' method='post' action='admin.php?adminmode=wannabemin&action=DoAddAlt'>
			<input type='hidden' name='QueID' value='".$QueID."'>
			<table>
				<tr>
					<td><b>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</b></td>
				</tr>
		";

	while ($var = fetch($result))
	{
		$AltID = $var->ID;
		$Alt = $var->content;

		$list .= "
			<tr>
				<td>".lang("Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
				<td>".$Alt."</td>
				<td><a href='admin.php?adminmode=wannabemin&action=DelAlt&id=$AltID'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
			</tr>
			";
	}

	$list .= "
	  <tr>
	   <td>".lang("New Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
	   <td><input type='text' name='Alt'></td>
	  </tr>
	  <tr>
	   <td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text used in wannabemin")."'></td>
	   <td><a href='admin.php?adminmode=wannabemin'>".lang("Save", "admin_wannabemin", "Text used in wannabemin")."</a></td>
	  </tr>
	 </table>
	</form>
	";
	echo $list;
}
elseif ($action == "DelAlt")
{
	$ID = $_GET['id'];

	if (empty($ID))
	{
		nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));
	}

	$query = sprintf ("SELECT * FROM wannabeAlt WHERE ID = %s", escape_string($ID));
	$result = query($query);
	$r = fetch($result);

	$QueID = $r->queID;

	$query = sprintf ("DELETE FROM wannabeAlt WHERE ID = %s", escape_string($ID));
	$result = query($query);

	echo lang("Alternative has been deleted", "admin_wannabemin", "Text used in wannabemin");

	refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$QueID", 2);
}
elseif ($action == "AddNewQue")
{
	echo	"
	<form name='AddQue' method='post' action='admin.php?adminmode=wannabemin&action=DoAddNewQue'>
	 <table>
	  <tr>
	   <td><b>".lang("Add Question", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	  </tr>
	  <tr>
	   <td>".lang("Question:", "admin_wannabemin", "Text used in wannabemin")."</td>
	   <td><textarea cols=60 rows=10 name='Que'></textarea>
	  </tr>
	  <tr>
	   <td>".lang("Type:", "admin_wannabemin", "Text used in wannabemin")."</td>
	   <td>
	    <select name='Type'>
		 <option value='2'>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
		 <option value='1'>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</option>
		</select>
	   </td>
	  </tr>
	  <tr>
	   <td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text used in wannabemin")."'></td>
	  </tr>
	 </table>
	</form>
	";
}
elseif ($action == "DoAddNewQue")
{
	$Que = $_POST['Que'];
	$Type = $_POST['Type'];

	if ((empty($Que)) || (empty($Type)))
	{
		nicedie(lang("Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin")."( Que == $Que AND Type == $Type)");
	}

	$query = sprintf ("INSERT INTO wannabeQue (ID, content, type) VALUES (NULL, '%s', '%s')", escape_string($Que), escape_string($Type));
	$result = query($query);

	$query = sprintf ("SELECT * FROM wannabeQue WHERE content = '%s' AND type = '%s'", escape_string($Que), escape_string($Type));
	$result = query($query);

	$r = fetch($result);

	$ID = $r->ID;

	if ($Type == 1)
	{
		echo lang("Time to add some alternatives.", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$ID", 2);
	}
	else
	{
		echo lang("Question has been added", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin", 2);
	}
}
elseif ($action == "ViewUsers")
{
	$query = "SELECT * FROM users WHERE wannabe = '1'";
	$result = query($query);

	$count = num($result);

	$list = "
		<table>
			<tr>
				<td>".lang("View Users", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</td>
			</tr>
		";

	if ($count == 0)
	{
		$list .= "
			<tr>
				<td>".lang("Nobody here", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</td>
			</tr>
			";
	}
	else
	{
		while ($UInfo = fetch($result))
		{
			$Nick = $UInfo->nick;
			$ID = $UInfo->ID;

			$list .= "
				<tr>
					"; //<td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$ID'>$ID</a></td>
					$q = query("SELECT * FROM wannabeComment WHERE user = ".escape_string($UInfo->ID)." AND approve != 0");
					$image = NULL;
					while($r = fetch($q)) {
						if($r->approve == 1) $image .= "<img src=images/yes.gif>";
						elseif($r->approve == 2) $image .= "<img src=images/no.gif>";
						
					}
					$q = query("SELECT * FROM wannabeComment WHERE user = ".escape_string($UInfo->ID)." AND adminID = ".escape_string(getcurrentuserid()));
					$r = fetch($q);
					$rowColor = NULL;
					if($r->approve == 0) $rowColor = " bgcolor=yellow";
					elseif($r->approve == 1) $rowColor = " bgcolor=green";
					elseif($r->approve == 2) $rowColor = " bgcolor=red";
					$list .= "
					<td$rowColor>$image</td>
					<td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$ID'>$Nick</td>
					<td>".$UInfo->name."</a></td>
				</tr>
				";
		}
	}
	$list .= "</table>";
	echo $list;
}
elseif ($action == "DoViewUsers")
{
	$UID = $_GET['id'];

	if (empty($UID))
	{
		nicedie(lang("Please specify the userID", "admin_wannabemin", "Text used in wannabemin"));
	}
	
	$q = query("SELECT * FROM users WHERE ID = ".escape_string($UID));
	$r = fetch($q);
	echo "<table>";
	osgl_table(lang("Nick: ", "admin_wannabemin", "DoViewUsers->profile->nick"), $r->nick);
	osgl_table(lang("Name: ", "admin_wannabemin", "DoViewUsers->profile->name"), $r->name);
	osgl_table(lang("Birthday: ", "admin_wannabemin", "DoViewUsers->profile->birthday"), $r->birthDAY." / ".$r->birthMONTH." ".$r->birthYEAR );
	osgl_table(lang("EMail: ", "admin_wannabemin", "DoViewUsers->profile->EMail"), $r->EMail);
	osgl_table(lang("Cellphone: ", "admin_wannabemin", "DoViewUsers->profile->Cellphone"), $r->cellphone);
	osgl_table(lang("Street: ", "admin_wannabemin", "DoViewUsers->profile->Street"), $r->street);
	osgl_table(lang("Post # / place: ", "admin_wannabemin", "DoViewUsers->profile->poststuff"), $r->postNr." ".$r->postPlace);
	
	echo "</table>";
	
	$query = sprintf ("SELECT * FROM wannabeUsers WHERE user = %s", escape_string($UID));
	$result = query($query);

	$list = "
		<table>
			<tr>
				<td><b><a href=admin.php?adminmode=wannabemin&action=ViewUsers>".lang("View Users", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</a></b></td>
			</tr>
		";

	$query = "SELECT * FROM wannabeQue";
	$result = query($query);

	while ($Get = fetch($result))
	{
		$Que = $Get->content;
		$QueID = $Get->ID;
		$Type = $Get->type;

		$query2 = sprintf ("SELECT * FROM wannabeUsers WHERE user = %s AND queID = %s", escape_string($UID), escape_string($QueID));
		$result2 = query($query2);

		$var = fetch($result2);

		$Ans = $var->ans;

		if ($Type == 1)
		{
			$query3 = sprintf ("SELECT * FROM wannabeAlt WHERE ID = '%s'", escape_string($Ans));
			$result3 = query($query3);
			$var2 = fetch($result3);

			$AltAns = $var2->content;

			$list .= "
				<tr>
					<td><b>".lang("Question:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</b> $Que </td>
				</tr>
				<tr>
					<td><em>$AltAns</em></td>
				</tr>
				";
		}
		else
		{
			$list .= "
				<tr>
					<td><b>".lang("Question:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</b> $Que </td>
				</tr>
				<tr>
					<td><em>".$Ans."</em></td>
				</tr>
				";
		}
  	}

	$query = sprintf ("SELECT * FROM wannabeComment WHERE user = %s AND adminID = %s",  escape_string($UID), escape_string(getcurrentuserid()));
	$result = query($query);
	$var = fetch($result);

	$Comment = $var->comment;
	$approve = $var->approve;

	if ($approve == 1)
	{
		$Check1 = " checked";
	}
	elseif ($approve == 2) 
	{
		$Check2 = " checked";
	}
	else $Check0 = " checked";

	$list .= "
		<form name='AddComment' method='post' action='admin.php?adminmode=wannabemin&action=AddComment'>
			<input type='hidden' name='UserID' value='$UID'>
			<tr>
				<td><b>".lang("Add comment:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</b></td>
			</tr>
			<tr>
				<td><textarea name='Comment'>$Comment</textarea></td>
			</tr>
			<tr>
				<td>".lang("Do You like this wannabe ?", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</td>
			</tr>
			<tr>
				<td><input type='radio' name='approve' value='1'".$Check1.">".lang("Yes", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</td>
				<td><input type='radio' name='approve' value='0'".$Check0.">!".lang("Not decided yet", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</td>
				<td><input type='radio' name='approve' value='2'".$Check2.">".lang("Nope", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</td>
			</tr>
			<tr>
				<td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text used in wannabemin")."'></td>
			</tr>
		</form>
	</table>
		";

	echo $list;

	$query = sprintf ("SELECT * FROM wannabeComment WHERE user = %s", escape_string($UID));
	$q = query($query);
	echo "<table>";
	while ($r = fetch($q))
	{
		if($r->approve == 1) $smiley = "<img src=images/yes.gif>";
		elseif($r->approve == 2) $smiley = "<img src=images/no.gif>";
		else $smiley = ""; // If not set/not "voted"
		echo "
			<tr>
				<td><b>". IDtonick($r->adminID) ." ".$smiley.":</b></td>
			</tr>
			<tr>
				<td><em>". $r->comment ."</em></td>
			</tr>
			
			";
		// Removeing this, and putting a small smiley "up there" instead
		/*
		if ($r->approve == 1)
		{
			//$approve = lang("Yes", "admin_wannabemin", "Text used in wannabemin");
		}
		elseif ($r->approve == 2)
		{
			//$approve = lang("Nope", "admin_wannabemin", "Text used in wannabemin");
		}
		echo "
			<tr>
				<td>". lang("Do you like this wannabe?", "admin_wannabemin", "Text used in wannabemin"). " <b>". $approve ."</b></td>
			</tr>
			";
		*/
  	}
	echo "</table>";
}
elseif ($action == "AddComment")
{
	$ID = $_POST['UserID'];
	$Com = $_POST['Comment'];
	$Like = $_POST['approve'];

	if ((empty($ID)) || (empty($Com)))
	{
		nicedie(lang("Did you forget something ? Like writing a comment ?", "admin_wannabemin", "Text used in wannabemin"));
	}
	if(empty($Like)) $Like = 0;
	$query = sprintf ("SELECT * FROM wannabeComment WHERE user = %s AND adminID = %s", escape_string($ID), escape_string($user));
	$result = query($query);
	$num = num($result);

	if ($num != 0)
	{
		$query = sprintf ("UPDATE wannabeComment SET comment = '%s', approve = '%s' WHERE user = %s AND adminID = %s", escape_string($Com), escape_string($Like), escape_string($ID), escape_string($user));
	}
	else
	{
		$query = sprintf ("INSERT INTO wannabeComment (ID, comment, approve, user, adminID) VALUES (NULL, '%s', '%s', '%s', '%s')", escape_string($Com), escape_string($Like), escape_string($ID), escape_string($user));
	}
	$result = query($query);
	echo lang("Comment added", "admin_wannabemin", "Text used in wannabemin");
	refresh("admin.php?adminmode=wannabemin&action=DoViewUsers&id=$ID", 2);
}
elseif ($action == "ViewComment")
{
	$ID = $_GET['id'];
	if (empty($ID))
	{
		nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));
	}
	
	$query = sprintf ("SELECT * FROM wannabeComment WHERE user = %s", escape_string($ID));
	$q = query ($query);
	echo "<table>";
	while ($r = fetch($q))
	{
		echo "
			<tr>
				<td><b>". IDtonick($r->adminID) .":</b></td>
			</tr>
			<tr>
				<td><em>". $r->comment ."</em></td>
			</tr>
			";
		if ($r->approve == 1)
		{
			$approve = lang("Yes", "admin_wannabemin", "Text used in wannabemin");
		}
		elseif ($r->approve == 2)
		{
			$approve = lang("Nope", "admin_wannabemin", "Text used in wannabemin");
		}
		
		echo "
			<tr>
				<td>". lang("Do you like this wannabe?", "admin_wannabemin", "Text used in wannabemin"). " <b>". $approve ."</b></td>
			</tr>
			";
		}
		echo "</table>";
}
?>
