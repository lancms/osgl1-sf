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

			$Id		=	$var->id;
			$Que	=	$var->content;

			$list  .=	"
			<tr>
			 <td><a href='admin.php?adminmode=wannabemin&action=EditQue&id=$Id'>".$Que."</a></td>
			 <td><a href='admin.php?adminmode=wannabemin&action=DelQue&id=$Id'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
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

	$Id		=	$_GET['id'];
	$Id		=	escape_string($Id);

	if(empty($Id)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query		= 	"SELECT * FROM wannabeQue WHERE id = '$Id'";
	$result 	= 	query($query);
	$var 		= 	fetch($result);

	$Que		=	$var->content;
	$Type		=	$var->type;

	if($Type == 1) {

		$list	=	"
		 <option value='0'>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
		 <option value='1' selected>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</option>
		";

	} else {

		$list	=	"
		 <option value='0' selected>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
		 <option value='1'>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</option>
		";

	}

	echo	"
	<form name='editQue' method='post' action='admin.php?adminmode=wannabemin&action=DoEditQue'>
	<input type='hidden' name='Id' value='".$Id."'>
	 <table>
	  <tr>
	   <td><b>".lang("Edit Question", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	  </tr>
	  <tr>
	   <td>".lang("Question:", "admin_wannabemin", "Text used in wannabemin")."</td>
	   <td><input type='text' name='Que' value='".$Que."'>
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
	$Id		=	$_POST['Id'];

	$Que	=	escape_string($Que);
	$Type	=	escape_string($Type);
	$Id		=	escape_string($Id);

	if(empty($Id) || empty($Que) || empty($Type)) nicedie(lang("Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin"));

	$query	= 	"UPDATE wannabeQue SET content = '$Que', type = '$Type' WHERE id = '$Id'";
	$result	=	query($query);

	if($Type == 1) {

		echo lang("Time to add som alternatives.", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$Id", 2);

	} else {

		echo lang("Question has been edited", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin", 2);

	}

}

elseif($action == "DelQue") {

	$Id		=	$_GET['id'];
	$Id		=	escape_string($Id);

	if(empty($Id)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query	=	"DELETE FROM wannabeQue WHERE id = '$Id'";
	$result = 	query($query);



	echo lang("Question has been deleted", "admin_wannabemin", "Text to display in wannabemin&action=DelRadioAlt");

	refresh("admin.php?adminmode=wannabemin", 2);

}

elseif($action == "AddAlt") {

	$Id		=	$_GET['id'];

	if(empty($Id)) {
	 $Id	=	$_POST['id'];
	}

	$Id		=	escape_string($Id);

	if(empty($Id)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query	= 	"SELECT * FROM wannabeAlt WHERE QueId = '$Id'";
	$result = 	query($query);

	$list	=	"
	<form name='addAlt' method='post' action='admin.php?adminmode=wannabemin&action=DoAddAlt'>
	<input type='hidden' name='QueId' value='".$Id."'>
	<table>
	 <tr>
	  <td><b>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	 </tr>
	";

		while($var 	= fetch($result)) {

		$AltId	=	$var->id;
		$Alt	=	$var->content;

		$list  .=	"
		<tr>
		 <td>".lang("Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
		 <td>".$Alt."</td>
		 <td><a href='admin.php?adminmode=wannabemin&action=DelAlt&id=$AltId'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
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

	$QueId	=	$_POST['QueId'];
	$Alt	=	$_POST['Alt'];

	$QueId	=	escape_string($QueId);
	$Alt	=	escape_string($Alt);

	if(empty($QueId) || empty($Alt)) nicedie(lang("Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin"));

	$query	= 	"INSERT INTO wannabeAlt (id, content, queid) VALUES (NULL, '$Alt', '$QueId')";
	$result = 	query($query);

	$query	= 	"SELECT * FROM wannabeAlt WHERE queid = '$QueId'";
	$result = 	query($query);

	$list	=	"
	<form name='addAlt' method='post' action='admin.php?adminmode=wannabemin&action=DoAddAlt'>
	<input type='hidden' name='QueId' value='".$QueId."'>
	<table>
	 <tr>
	  <td><b>".lang("Alternatives", "admin_wannabemin", "Text used in wannabemin")."</b></td>
	 </tr>
	";

		while($var 	= fetch($result)) {

		$AltId	=	$var->id;
		$Alt	=	$var->content;

		$list  .=	"
		<tr>
		 <td>".lang("Alternative:", "admin_wannabemin", "Text used in wannabemin")."</td>
		 <td>".$Alt."</td>
		 <td><a href='admin.php?adminmode=wannabemin&action=DelAlt&id=$AltId'>".lang("Delete", "admin_wannabemin", "Text used in wannabemin")."</a></td>
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

	$Id		=	$_GET['id'];
	$Id		=	escape_string($Id);

	if(empty($Id)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query		=	"SELECT * FROM wannabeAlt WHERE id = '$Id'";
	$result 	= 	query($query);
	$r			=	fetch($result);

	$QueId		=	$r->queid;

	$query		=	"DELETE FROM wannabeAlt WHERE id = '$Id'";
	$result 	= 	query($query);

	echo lang("Alternative has been deleted", "admin_wannabemin", "Text used in wannabemin");

	refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$QueId", 2);
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
		 <option value='0' selected>".lang("Text", "admin_wannabemin", "Text used in wannabemin")."</option>
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

	if(empty($Que) || empty($Type)) nicedie(lang("Nope, this is not the way you shoul do it... Try writing somthing in the fields next time :)", "admin_wannabemin", "Text used in wannabemin"));

	$Que		=	escape_string($Que);
	$Type		=	escape_string($Type);

	$query		= 	"INSERT INTO wannabeQue (id, content, type) VALUES (NULL, '$Que', '$Type')";
	$result		=	query($query);

	$query		=	"SELECT * FROM wannabeQue WHERE content = '$Que' AND type = '$Type'";
	$result		=	query($query);

	$r			=	fetch($result);

	$Id			=	$r->id;

	if($Type == 1) {

		echo lang("Time to add som alternatives.", "admin_wannabemin", "Text used in wannabemin");
		refresh("admin.php?adminmode=wannabemin&action=AddAlt&id=$Id", 2);

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
	  $Id		=	$UInfo->ID;

	  $list	   .=	"
	  	<tr>
		 <td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$Id'>$Id</a></td>
		 <td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$Id'>$Nick</a></td>
		 <td><a href='admin.php?adminmode=wannabemin&action=ViewComment&id=$Id'>".lang("View comments", "admin_wannabemin", "Text to display in wannabemin")."</a></td>
		</tr>
	  ";


	 }
	}

	$list	   .= "</table>";

	echo $list;

}
elseif($action == "DoViewUsers") {

	$UserID		=	$_GET['id'];
	$UserID		=	escape_string($UserID);

	if(empty($UserID)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query		=	"SELECT * FROM wannabeUsers WHERE user = '$UserID'";
	$result 	= 	query($query);

	$list		=	"
	<table>
	 <tr>
	  <td><b>".lang("View Users", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</b></td>
	 </tr>
	 ";

	$query		=	"SELECT * FROM wannabeQue";
	$result 	= 	query($query);

	while($Get = fetch($result)) {

	$Que		=	$Get->content;
	$QueID		=	$Get->id;
	$Type		=	$Get->type;

	$query2		=	"SELECT * FROM wannabeUsers WHERE user = '$UserID' AND queid = '$QueID'";
	$result2 	= 	query($query2);

	$var		=	fetch($result2);

	$Ans		=	$var->ans;


	if($Type == 1) {

	$query3		=	"SELECT * FROM wannabeAlt WHERE queid = '$QueID'";
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

  $list	   .= "
  <form name='AddComment' method='post' action='admin.php?adminmode=wannabemin&action=AddComment'>
  <input type='hidden' name='UserID' value='$UserID'>
   <tr>
    <td><b>".lang("Add comment:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")."</b></td>
   </tr>
   <tr>
    <td><textarea name='Comment'></textarea></td>
   </tr>
   <tr>
    <td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text used in wannabemin")."'></td>
   </tr>
  </form>
  </table>
  ";

  echo $list;

}

elseif($action == "AddComment") {

	$Id		=	$_POST['UserID'];
	$Com	=	$_POST['Comment'];

	$Id		=	escape_string($Id);
	$Com	=	escape_string($Com);

	if(empty($Id) || empty($Com)) nicedie(lang("Did you forget something ? Like writing a comment ?", "admin_wannabemin", "Text used in wannabemin"));

	$query	= 	"INSERT INTO `wannabeComment` ( `id` , `comment` , `user` , `by` ) VALUES (NULL, '$Com', '$Id', '$user')";
	$result	=	query($query);

	echo lang("Comment added", "admin_wannabemin", "Text used in wannabemin");
	refresh("admin.php?adminmode=wannabemin&action=ViewComment&id=$Id", 2);

}

elseif($action == "ViewComment") {

	$Id		=	$_GET['id'];
	$Id		=	escape_string($Id);

	if(empty($Id)) nicedie(lang("Something is not right.", "admin_wannabemin", "Text used in wannabemin"));

	$query		=	"SELECT * FROM wannabeComment WHERE user = '$Id' ORDER BY id DESC";
	$result 	= 	query($query);
	$list	   .=	"
	<table>
	";

	while($var = fetch($result)) {

	$Comment	=	$var->comment;
	$By			=	$var->by;

	$query2		=	"SELECT * FROM users WHERE id = '$By'";
	$result2	=	query($query2);

	$get		=	fetch($result2);

	$By			=	$get->nick;

	$list	   .=	"
	<tr>
	 <td><b>".lang("Comment posted by:", "admin_wannabemin", "Text used in wannabemin")."</b> $By</td>
	</tr>
	<tr>
	 <td>$Comment</td>
	</tr>
	";
	}

	$list	  .=	"
	</table>
	";

	echo $list;

}

?>