<?php
require 'config/config.php';

if (!acl_access("wannabe"))
{
	nicedie(lang("DIIIIIIIIIIIIIE!! No access!", "admin_wannabemin", "No access text in wannabemin"));
}

$action = $_GET['action'];
$user	= getcurrentuserid();

if(!isset($action)) {
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=addQue'>".lang("Add question", "admin_wannabemin", "Text to display in wannabe admin menu")."</a><br>";
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=ViewUsers'>".lang("View Users", "admin_wannabemin", "Text to display in wannabe admin menu")."</a>";
}

if($action == "addQue") {

	$query		= 	"SELECT * FROM wannabeQue";
	$result 	= 	query($query);

	$list		=	"
	<table>
	 <tr>
	  <td><b>".lang("Questions:", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	 </tr>
	";

		while($var 	= fetch($result)) {

			$ID		=	$var->ID;
			$Que	=	$var->content;

			$list  .=	"
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

elseif($action == "EditQue") {

	$ID		=	$_GET['id'];
	$ID		=	escape_string($ID);

	if(empty($ID)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query		= 	"SELECT * FROM wannabeQue WHERE ID = '$ID'";
	$result 	= 	query($query);
	$var 		= 	fetch($result);

	$Que		=	$var->content;
	$Type		=	$var->type;

	if($Type == 1) {

		$list	=	"
		 <option value='2'>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
		 <option value='1' selected>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</option>
		";

	} else {

		$list	=	"
		 <option value='2' selected>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
		 <option value='1'>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</option>
		";

	}

	echo	"
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

elseif($action == "DoEditQue") {

	$Que	=	$_POST['Que'];
	$Type	=	$_POST['Type'];
	$ID		=	$_POST['id'];

	$Que	=	escape_string($Que);
	$Type	=	escape_string($Type);
	$ID		=	escape_string($ID);

	if(empty($ID) || empty($Que) || empty($Type)) nicedie(lang("Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin"));

	$query	= 	"UPDATE wannabeQue SET content = '$Que', type = '$Type' WHERE ID = '$ID'";
	$result	=	query($query);

	if($Type == 1) {

		echo lang("Time to add som alternatives.", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$ID", 2);

	} else {

		echo lang("Question has been edited", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin", 2);

	}

}

elseif($action == "DelQue") {

	$ID		=	$_GET['id'];
	$ID		=	escape_string($ID);

	if(empty($ID)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query	=	"DELETE FROM wannabeQue WHERE ID = '$ID'";
	$result = 	query($query);



	echo lang("Question has been deleted", "admin_wannabemin", "Text to display in wannabemin&action=DelRadioAlt");

	refresh("admin.php?adminmode=wannabemin", 2);

}

elseif($action == "AddAlt") {

	$ID		=	$_GET['id'];

	if(empty($ID)) {
	 $ID	=	$_POST['id'];
	}

	$ID		=	escape_string($ID);

	if(empty($ID)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query	= 	"SELECT * FROM wannabeAlt WHERE QueID = '$ID'";
	$result = 	query($query);

	$list	=	"
	<form name='addAlt' method='post' action='admin.php?adminmode=wannabemin&action=DoAddAlt'>
	<input type='hidden' name='QueID' value='".$ID."'>
	<table>
	 <tr>
	  <td><b>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	 </tr>
	";

		while($var 	= fetch($result)) {

		$AltID	=	$var->ID;
		$Alt	=	$var->content;

		$list  .=	"
		<tr>
		 <td>".lang("Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
		 <td>".$Alt."</td>
		 <td><a href='admin.php?adminmode=wannabemin&action=DelAlt&id=$AltID'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
		</tr>
		";

		}

	$list  .= "
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

elseif($action == "DoAddAlt") {

	$QueID	=	$_POST['QueID'];
	$Alt	=	$_POST['Alt'];

	$QueID	=	escape_string($QueID);
	$Alt	=	escape_string($Alt);

	if(empty($QueID) || empty($Alt)) nicedie(lang("Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin"));

	$query	= 	"INSERT INTO wannabeAlt (ID, content, queID) VALUES (NULL, '$Alt', '$QueID')";
	$result = 	query($query);

	$query	= 	"SELECT * FROM wannabeAlt WHERE queID = '$QueID'";
	$result = 	query($query);

	$list	=	"
	<form name='addAlt' method='post' action='admin.php?adminmode=wannabemin&action=DoAddAlt'>
	<input type='hidden' name='QueID' value='".$QueID."'>
	<table>
	 <tr>
	  <td><b>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	 </tr>
	";

		while($var 	= fetch($result)) {

		$AltID	=	$var->ID;
		$Alt	=	$var->content;

		$list  .=	"
		<tr>
		 <td>".lang("Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
		 <td>".$Alt."</td>
		 <td><a href='admin.php?adminmode=wannabemin&action=DelAlt&id=$AltID'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
		</tr>
		";

		}

	$list	   .= "
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

elseif($action == "DelAlt") {

	$ID		=	$_GET['id'];
	$ID		=	escape_string($ID);

	if(empty($ID)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query		=	"SELECT * FROM wannabeAlt WHERE ID = '$ID'";
	$result 	= 	query($query);
	$r			=	fetch($result);

	$QueID		=	$r->queID;

	$query		=	"DELETE FROM wannabeAlt WHERE ID = '$ID'";
	$result 	= 	query($query);

	echo lang("Alternative has been deleted", "admin_wannabemin", "Text used in wannabemin");

	refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$QueID", 2);
}

elseif($action == "AddNewQue") {

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

elseif($action == "DoAddNewQue") {

	$Que		=	$_POST['Que'];
	$Type		=	$_POST['Type'];

	if(empty($Que) || empty($Type)) nicedie(lang("Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin")."( Que == $Que AND Type == $Type)");

	$Que		=	escape_string($Que);
	$Type		=	escape_string($Type);

	$query		= 	"INSERT INTO wannabeQue (ID, content, type) VALUES (NULL, '$Que', '$Type')";
	$result		=	query($query);

	$query		=	"SELECT * FROM wannabeQue WHERE content = '$Que' AND type = '$Type'";
	$result		=	query($query);

	$r			=	fetch($result);

	$ID			=	$r->ID;

	if($Type == 1) {

		echo lang("Time to add som alternatives.", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$ID", 2);

	} else {

		echo lang("Question has been added", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin", 2);

	}

}

elseif($action == "ViewUsers") {

	$query		=	"SELECT * FROM users WHERE wannabe = '1'";
	$result 	= 	query($query);

	$count		=	num($result);

	$list		=	"
	<table>
	 <tr>
	  <td>".lang("View Users", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</td>
	 </tr>
	 ";

	 if($count == 0) {
	  $list	   .= "
	  <tr>
	   <td>".lang("Nobody here", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</td>
	  </tr>
	  ";
	 } else {

	 while($UInfo = fetch($result)) {

	  $Nick		=	$UInfo->nick;
	  $ID		=	$UInfo->ID;

	  $list	   .=	"
	  	<tr>
		 <td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$ID'>$ID</a></td>
		 <td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$ID'>$Nick</a></td>
		 <td><a href='admin.php?adminmode=wannabemin&action=ViewComment&id=$ID'>".lang("View comments", "admin_wannabemin", "Text to display in wannabemin")."</a></td>
		</tr>
	  ";


	 }
	}

	$list	   .= "</table>";

	echo $list;

}
elseif($action == "DoViewUsers") {

	$UID		=	$_GET['id'];
	$UserID		=	escape_string($UID);

	if(empty($UID)) nicedie(lang("Please specify the userID", "admin_wannabemin", "Text used in wannabemin"));

	$query		=	"SELECT * FROM wannabeUsers WHERE user = '$UserID'";
	$result 	= 	query($query);

	$list		=	"
	<table>
	 <tr>
	  <td><b><a href=admin.php?adminmode=wannabemin&action=ViewUsers>".lang("View Users", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</a></b></td>
	 </tr>
	 ";

	$query		=	"SELECT * FROM wannabeQue";
	$result 	= 	query($query);

	while($Get = fetch($result)) {

	$Que		=	$Get->content;
	$QueID		=	$Get->ID;
	$Type		=	$Get->type;

	$query2		=	"SELECT * FROM wannabeUsers WHERE user = '$UserID' AND queID = '$QueID'";
	$result2 	= 	query($query2);

	$var		=	fetch($result2);

	$Ans		=	$var->ans;


	if($Type == 1) {

	//$query3		=	"SELECT * FROM wannabeAlt WHERE queID = '$QueID'"; // Removed by Lak; wrong!
	$query3 	= "SELECT * FROM wannabeAlt WHERE ID = '$Ans'";
	$result3 	= 	query($query3);

	$var2		=	fetch($result3);

	$AltAns		=	$var2->content;

	$list 	   .=	"
		<tr>
		 <td><b>".lang("Question:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</b> $Que </td>
		</tr>
		<tr>
		 <td><em>$AltAns</em></td>
		</tr>
	";

	} else {

	$list 	   .=	"
		<tr>
		 <td><b>".lang("Question:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</b> $Que </td>
		</tr>
		<tr>
		 <td><em>".$Ans."</em></td>
		</tr>
	";

		}

  	}
	$query		= 	"SELECT * FROM wannabeComment WHERE user = '$user'";
	$result 	= 	query($query);
	$var 		= 	fetch($result);

	$Comment	=	$var->comment;
	$like		=	$var->like;

	if($like == 1) $Check1 = " checked";
	elseif($like == 2) $Check2 = " checked";

	  $list	   .= "
	  <form name='AddComment' method='post' action='admin.php?adminmode=wannabemin&action=AddComment'>
	  <input type='hidden' name='UserID' value='$UserID'>
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
		<td><input type='radio' name='like' value='1'".$Check1.">".lang("Yes", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</td>
		<td><input type='radio' name='like' value='2'".$Check2.">".lang("Nope", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</td>
	   </tr>
	   <tr>
		<td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text used in wannabemin")."'></td>
	   </tr>
	  </form>
	  </table>
	  ";

  echo $list;

  $q = query("SELECT * FROM wannabeComment WHERE user = '$UserID'");
  echo "<table>";
  while($r = fetch($q)) {
		echo "
		  <tr>
			<td><b>". IDtonick($r->by) .":</b></td>
		  </tr>
		  <tr>
			<td><em>". $r->comment ."</em></td>
		  </tr>
		  ";
		  if($r->like == 1) $like = lang("Yes", "admin_wannabemin", "Text used in wannabemin");
		  elseif($r->like == 2) $like = lang("Nope", "admin_wannabemin", "Text used in wannabemin");
		echo "
		 <tr>
		  <td>". lang("Do you like this wannabe?", "admin_wannabemin", "Text used in wannabemin"). " <b>". $like ."</b></td>
		 </tr>
		 ";



  	}

	echo "</table>";

}

elseif($action == "AddComment") {

	$ID		=	$_POST['UserID'];
	$Com	=	$_POST['Comment'];
	$Like	=	$_POST['like'];

	$ID		=	escape_string($ID);
	$Com	=	escape_string($Com);
	$Like	=	escape_string($Like);

	if(empty($ID) || empty($Com) || empty($Like)) nicedie(lang("Did you forget something ? Like writing a comment ?", "admin_wannabemin", "Text used in wannabemin"));

	$query	=	"SELECT * FROM `wannabeComment` WHERE `user` = '$ID' AND `by` = '$user'";
	$result	=	query($query);
	$num	=	num($result);

	if($num != 0) {
	 $query	=	"UPDATE `wannabeComment` SET `comment` = '$Com', `like` = '$Like' WHERE `user` = '$ID' AND `by` = '$user'";
	} else {
	 $query	= 	"INSERT INTO `wannabeComment` ( `ID` , `comment` , `like` , `user` , `by` ) VALUES (NULL, '$Com', '$Like', '$ID', '$user')";
	}
	$result	=	query($query);

	echo lang("Comment added", "admin_wannabemin", "Text used in wannabemin");
	refresh("admin.php?adminmode=wannabemin&action=ViewComment&id=$ID", 2);

}

elseif($action == "ViewComment") {

	$ID		=	$_GET['id'];
	$ID		=	escape_string($ID);

	if(empty($ID)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));


	  $q = query("SELECT * FROM wannabeComment WHERE user = '$ID'");
	  echo "<table>";
	  while($r = fetch($q)) {
			echo "
			  <tr>
				<td><b>". IDtonick($r->by) .":</b></td>
			  </tr>
			  <tr>
				<td><em>". $r->comment ."</em></td>
			  </tr>
			  ";
			  if($r->like == 1) $like = lang("Yes", "admin_wannabemin", "Text used in wannabemin");
			  elseif($r->like == 2) $like = lang("Nope", "admin_wannabemin", "Text used in wannabemin");
			echo "
			 <tr>
			  <td>". lang("Do you like this wannabe?", "admin_wannabemin", "Text used in wannabemin"). " <b>". $like ."</b></td>
			 </tr>
			 ";

		}

		echo "</table>";

}

?>