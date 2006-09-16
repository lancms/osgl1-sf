<?php

require_once ("config/config.php");

$action = $_GET['action'];

if (!acl_access("adminUsers"))
{
	$editID = getcurrentuserid();
}
elseif (!isset($_GET['user']))
{
	$editID = getcurrentuserid();
}
elseif ((acl_access("adminUsers")) && (isset($_GET['user'])))
{
	$editID = $_GET['user'];
}

if (getcurrentuserid() == 1)
{
	nicedie($msg['26']);
}

if (($action == "view") || (!isset($action)))
{
	if($_GET['mode'] == "success")
	{
		echo "<font color=red>$profile[7]</font>";
	}

	if($_GET['mode'] == "pwdsuccess")
	{
		echo "<font color=red>$profile[7]</font>";
	}

	$query = query("SELECT * FROM users WHERE users.ID=".escape_string($editID)."");

	$row = fetch($query);
	echo "<form method=post action=index.php?inc=useradmin&action=edit&user=$row->ID>";
	echo '<table>';
	osgl_table($profile['8'],"<input type=text name=nick value='$row->nick'>");
	osgl_table(lang("Firstname", "inc_useradmin", "Users firstname in useradmin?action=view"), "<input type=text name=firstName value='$row->firstName'>");
	osgl_table(lang("Lastname", "inc_useradmin", "Users lastname in useradmin?action=view"), "<input type=text name=lastName value='$row->lastName'>");

	osgl_table($profile[4], "<textarea name=aboutme rows=10 cols=60>$row->aboutMe</textarea>");

	osgl_table($form[76], "<input type=text name=cellphone value='$row->cellphone'>");

	osgl_table($form[25], "<a href=index.php?inc=useradmin&action=changepass&user=$editID>$form[33]</a>");

	osgl_table($profile[6], "<a href=index.php?inc=useradmin&action=changemail&user=$editID>$form[34]</a>");

	osgl_table($form['74'], "<input type=text name=street value='$row->street'>");
	osgl_table($form['75'], "<input type=text name=postNr value='$row->postNr' size=5><input type=text name=postPlace value='$row->postPlace'>");

	$birthdayinfo = "<select name=birthDAY>";
	for($i=1;$i<32;$i++)
	{
		if($i != $row->birthDAY)
		{
			$select = "";
		}
		else
		{
			$select = "SELECTED";
		}

		$birthdayinfo .= "<option value=$i $select>$i</option>\n";
	}
	$birthdayinfo .= "</select>";
	$birthdayinfo .= "<select name=birthMONTH><option value=0></option>\n\n";
	for($m=1;$m<13;$m++)
	{
		if($row->birthMONTH != $m)
		{
			$select = "";
		}
		else
		{
			$select = "SELECTED";
		}
		$birthdayinfo .= "<option value=$m $select>$month[$m]</option>\n";
	}
	$birthdayinfo .= "</select>";
	$birthdayinfo .= "<select name=birthYEAR>";
	for($y=1950;$y<2004;$y++)
	{
		if($y != $row->birthYEAR)
		{
			$selected = "";
		}
		else
		{
			$selected = "SELECTED";
		}
		$birthdayinfo .= "<option value=$y $selected>$y</option>\n";
	}
	osgl_table($form['77'], $birthdayinfo);

	echo "<tr><td class=profileLeft width=30%>$profile[9]</td><td class=profileRight>";

	if(acl_access("ACL")) {
		// User is allowed to make changes to ACL
		$groups = query("SELECT * FROM groups");
		echo "<select name=myGroup>";
		//$Gnum = num($groups);
		while($Group = fetch($groups))
		{
			//$Group = fetch($groups)
			echo "<option value=$Group->ID";
			if($row->myGroup == $Group->ID)
			{
				echo " SELECTED";
			}
			echo ">$Group->groupname</option>";
		}
		echo "</select>";
	}
	else
	{
		$groups = query("SELECT * FROM groups WHERE ID = '".escape_string($row->myGroup)."'");
		$Group = fetch($groups);
		echo $Group->groupname;

	}

	echo "</td></tr>";

	echo "<tr><td class=profileLeft width=30%>$profile[13]</td><td class=profileRight>";

	echo "<select name=allowPublic>";

	for($y=0;$y<count($allowPublicFor);$y++)
	{
		echo "<option value=$y";

		if($row->AllowPublic == $y)
		{
			echo " SELECTED";
		}

		echo ">$allowPublicFor[$y]</option>";
	}

	echo "</select>";
	if(!config("disable_userstyle")) {
		echo "<tr><td class=profileLeft width=30%>$profile[14]</td><td class=profileRight>";

		echo "<select name=userDesign>";

		for ($y=0;$y<count($styles);$y++)
		{
			echo "<option value=$styles[$y]";

			if($row->userDesign == $styles[$y])
			{
				echo " SELECTED";
			}

			echo ">$styles[$y]</option>";
		}

		echo "</select>";

		echo "</td></tr>";
	}
	echo "</table>";

	echo "<br><input type=submit value='$form[15]'>";

}
elseif ($action == "edit")
{
	$q = query("SELECT * FROM users WHERE ID = '".escape_string($editID)."'");
	$r = fetch($q);
	$nick = $_POST['nick'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$mail = $_POST['mail'];
	$aboutme = htmlspecialchars($_POST['aboutme']);

	if(acl_access("ACL"))
	{
		$myGroup = $_POST['myGroup'];
	}
	else
	{
		$myGroup = $r->myGroup;
	}
	$cellphone = $_POST['cellphone'];
	$allowPublic = $_POST['allowPublic'];
	$userDesign = $_POST['userDesign'];
	$street = $_POST['street'];
	$postNr = $_POST['postNr'];
	$postPlace = $_POST['postPlace'];
	$birthDAY = $_POST['birthDAY'];
	$birthMONTH = $_POST['birthMONTH'];
	$birthYEAR = $_POST['birthYEAR'];
	$name = $firstName." ".$lastName;

	$verify = verify("edit", $editID, $nick, $firstName, $lastName);
	if ($verify != "allowed")
	{
		nicedie($form[$verify]);
	}

	$query = query("UPDATE users SET
		nick='".escape_string($nick)."',
		firstName = '".escape_string($firstName)."',
		lastName = '".escape_string($lastName)."',
		name = '".escape_string($name)."',
		aboutMe = '".escape_string($aboutme)."',
		cellphone = '".escape_string($cellphone)."',
		allowPublic = '".escape_string($allowPublic)."',

		street = '".escape_string($street)."',
		postNr = '".escape_string($postNr)."',
		postPlace = '".escape_string($postPlace)."',
		birthDAY = '".escape_string($birthDAY)."',
		birthMONTH = '".escape_string($birthMONTH)."',
		birthYEAR = '".escape_string($birthYEAR)."',
		myGroup = '".escape_string($myGroup)."'
		WHERE ID = '".escape_string($editID)."'");
	if(!config("disable_userstyle")) query("UPDATE users SET userDesign = '".escape_string($userDesign)."' WHERE ID = '".escape_string($editID)."'");

	refresh("index.php?inc=useradmin&user=$editID", "0");
	/* userID:username:firstname:lastname:aboutMe:cellphone:allowpublic:street:postNr:postPlace:birthDAY:birthMONTH:birthYEAR:myGroup:userDesign" */
	$a = ":::";
	dblog(11, $editID.$a.$nick.$a.$firstName.$a.$lastName.$a.$aboutme.$a.$cellphone.$a.$allowPublic.$a.$street.$a.$postNr.$a.$postPlace.$a.$birthDAY.$a.$birthMONTH.$a.$birthYEAR.$a.$myGroup.$a.$userDesign,
	$r->ID.$a.$r->nick.$a.$r->firstName.$a.$r->lastName.$a.$r->aboutMe.$a.$r->cellphone.$a.$r->AllowPublic.$a.$r->street.$a.$r->postNr.$a.$r->postPlace.$a.$r->birthDAY.$a.$r->birthMONTH.$a.$r->birthYEAR.$a.$r->myGroup.$a.$r->userDesign);


}
elseif ($action == "changepass")
{
	?>

	<table>

	<form method=post action=index.php?inc=useradmin&user=<?php echo $editID; ?>&action=doeditpass>

	<?php

	osgl_table($form[25], "<input type=password name=pwd1>");

	osgl_table($form[26], "<input type=password name=pwd2>");

	osgl_table("", "<input type=submit value='$form[15]'>");

	echo '</table>';

}
elseif ($action == "doeditpass")
{
	$pwd1 = $_POST['pwd1'];

	$pwd2 = $_POST['pwd2'];

	if($pwd1 != $pwd2)
	{
		nicedie($form[14]);
	}
	else
	{
		$cpass = crypt_pwd($pwd1);
		query("UPDATE users SET users.password='".escape_string($cpass)."' WHERE users.ID=".escape_string($editID)."");
		refresh("index.php?inc=useradmin&mode=pwdsuccess&user=$editID", "0");
	}
}
elseif ($action == "changemail")
{
	$query = query("SELECT * FROM users WHERE users.ID = '".escape_string($editID)."'");

	$row = fetch($query);
	?>

	<table>
	<form method=post action=index.php?inc=useradmin&action=dochangemail&user=<?php echo $editID; echo ">";

	osgl_table($profile[6], "<input type=text name=newmail value='$row->EMail'>");

	osgl_table("", "<input type=submit value='$form[15]'>");

	echo '</table></form>';

	echo $form[36];
}
elseif ($action == "dochangemail")
{
	$query = query("SELECT * FROM users WHERE users.ID=".escape_string($editID)."");

	$check = fetch($query);

	$newmail = $_POST['newmail'];

	if($newmail == $check->EMail)
	{
		echo $form[35];
		refresh("index.php?inc=useradmin&user=$editID");
	}
	else
	{
		$ran = createcifer() or nicedie($msg['28']);
		$update = query("UPDATE users SET users.EMail='".escape_string($newmail)."', verified='".escape_string($ran)."' WHERE users.ID = '".escape_string($editID)."'");

		if(!mail("$newmail", $mail[0], mail_body($ran), "From: ".$mail[2]))
		{
			nicedie($msg[5]);
		}
		else
		{
			refresh("index.php?inc=useradmin&edit=$editID&mode=mailsuccess", 0);
		}
	}
}

/*
function user_table($userLeft, $userRight)
// TODO: Move this to functions.php!
{
	echo "<tr><td class=profileLeft width=25%>$userLeft</td><td class=profileRight>";

	echo $userRight;

	echo "</td></tr>\n\n";
}
*/
?>
