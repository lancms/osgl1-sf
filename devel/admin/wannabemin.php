<?php

require 'config/config.php';

if (!acl_access("wannabe"))
{
	nicedie(lang("DIIIIIIIIIIIIIE!! No access!", "admin_wannabemin", "No access text in wannabemin"));
}

$action = $_GET['action'];

$Type	= $_POST['type'];

if($Type == "Txt") {
  $action = "addQueTxt";
}
elseif($Type == "Radio") {
  $action = "addQueRadio";
}

if(!isset($action)) {
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=addCat'>".lang("Add catagory", "admin_wannabemin", "Text to display in wannabe admin menu")."</a><br>";
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=addQue'>".lang("Add question", "admin_wannabemin", "Text to display in wannabe admin menu")."</a><br>";
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=ViewUsers'>".lang("View Users", "admin_wannabemin", "Text to display in wannabe admin menu")."</a>";
}

elseif($action == "addCat") {
	echo "
		<form name='addCat' method='post' action='admin.php?adminmode=wannabemin&action=DoaddCat'>
		  <table>
			<tr>
			  <td><strong>".lang("Add catagory", "admin_wannabemin", "Text to display in wannabemin&action=addCat")."</strong></td>
			</tr>
			<tr>
			  <td>".lang("Catagory name:", "admin_wannabemin", "Text to display in wannabemin&action=addCat")."
			  <input type='text' name='CatName'></td>
			</tr>
			<tr>
			  <td>".lang("Catagory description:", "admin_wannabemin", "Text to display in wannabemin&action=addCat")."</td>
			</tr>
			<tr>
			  <td><textarea name='CatInfo' cols='52' rows='5'></textarea></td>
			</tr>
			<tr>
			  <td><input type='submit' name='addCat' value='".lang("Add", "admin_wannabemin", "Text to display in wannabemin&action=addCat")."'></td>
			</tr>
		  </table>
		</form>
		";
}

elseif($action == "DoaddCat") {

	$CatName	=	$_POST['CatName'];
 	$CatInfo	=	$_POST['CatInfo'];
	
	if(empty($CatName) || empty($CatInfo)) {
	
	nicedie(lang("Are you completly sure you did not forget something?", "admin_wannabemin", "Error message in wannabemin&action=DoaddCat"));
	
	} else {
	
	$CatName	=	escape_string($CatName);
 	$CatInfo	=	escape_string($CatInfo);

	$query		= 	"INSERT INTO wannabeCat (id, name, info) VALUES (NULL, '$CatName', '$CatInfo')";
	$result 	= 	query($query);
	
	echo lang("Catagory created", "admin_wannabemin", "Text to display in wannabemin&action=DoaddCat");

	refresh("admin.php?adminmode=wannabemin", 2);
	
	}
}

elseif($action == "addQueTxt") {

	$Que		=	$_POST['que'];
	$Cat		=	$_POST['cat'];

	$Que		=	escape_string($Que);
	$Cat		=	escape_string($Cat);

	if(empty($Cat) || empty($Que)) {
	
	nicedie(lang("Are you completly sure you did not forget something?", "admin_wannabemin", "Error message in wannabemin&action=addQueTxt"));
	
	} else {

	$query		= 	"INSERT INTO wannabeQue (id, content, catid, type) VALUES (NULL, '$Que', '$Cat', '0')";
  	$result 	= 	query($query);

	}

	echo lang("Question added to the database", "admin_wannabemin", "Text to display in wannabemin&action=addQueTxt");

	refresh("admin.php?adminmode=wannabemin", 2);
}

elseif($action == "addQue") {

	 $list		=	"";

	 $query		= 	"SELECT * FROM wannabeCat";
	 $result 	= 	query($query);

	  while($cat = mysql_fetch_assoc($result)) {

	   $id		=	$cat['id'];
	   $name	=	$cat['name'];

	   $list   .= "<option value='$id'>$name</option>\n";

	  }

	echo "
		<form name='addQue' method='post' action='admin.php?adminmode=wannabemin&action=addQue'>
		  <table>
			<tr>
			  <td><strong>".lang("Add question", "admin_wannabemin", "Text to display in wannabemin&action=addQue")."</strong></td>
			</tr>
			<tr>
			  <td>".lang("Question:", "admin_wannabemin", "Text to display in wannabemin&action=addQue")."</td>
			  <td><input type='text' name='que'></td>
			</tr>
			<tr>
			  <td>".lang("Type:", "admin_wannabemin", "Text to display in wannabemin&action=addQue")."</td>
			  <td><select name='type'>
				<option value='Txt'>".lang("Text", "admin_wannabemin", "Text to display in wannabemin&action=addQue")."</option>
				<option value='Radio'>".lang("Alternatives", "admin_wannabemin", "Text to display in wannabemin&action=addQue")."</option>
			  </select></td>
			</tr>
			<tr>
			  <td>".lang("Catogory:", "admin_wannabemin", "Text to display in wannabemin&action=addQue")."</td>
			  <td><select name='cat'>
			  ".$list."
			  </select></td>
			</tr>
			<tr>
			  <td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text to display in wannabemin&action=addQue")."'></td>
			</tr>
		  </table>
		</form>
		";
}

elseif($action == "addQueRadio") {

	$Cat		=	$_POST['cat'];
	$Que		=	$_POST['que'];
	
	$Cat		=	escape_string($Cat);
	$Que		=	escape_string($Que);

	$query		=	"SELECT * FROM wannabeQue WHERE content = '$Que'";
	$result 	= 	query($query);
	$r			=	fetch($result);
	
	$QueId		=	$r->id;

	if(empty($Cat) || empty($Que)) {
	
	nicedie(lang("Are you completly sure you did not forget something?", "admin_wannabemin", "Error message in wannabemin&action=DoaddCat"));
	
	} else {

	$query		= 	"INSERT INTO wannabeQue (id, content, catid, type) VALUES (NULL, '$Que', '$Cat', '1')";
  	$result 	= 	query($query);

	$list		=	"";

	$query 	= 	"SELECT * FROM wannabeAltRadio WHERE queid = '$QueId'";
	$result = 	query($query);

	 while($Alt = mysql_fetch_assoc($result)) {
 	  
	  $oldAlt	= $Alt['content'];
	  $list	   .= 	"
		<tr>
		  <td>".lang("Alternative", "admin_wannabemin", "Text to display in wannabemin&action=addQueRadio")."</td>
		  <td>$oldAlt</td>
		  <td><a href='admin.php?adminmode=wannabemin&action=DelRadioAlt&id=$altID'>delete</a></td>
		</tr>
	   ";

	 }

	echo "
		  <form name='addQueRadio' method='post' action='admin.php?adminmode=wannabemin&action=DoaddQueRadio'>
		  <input type='hidden' name='que' value='$Que'>
		   <table>
			<tr>
			  <td>".lang("Add Alternatives", "admin_wannabemin", "Text to display in wannabemin&action=addQueRadio")."</td>
			</tr>
			 ".$list."
			  <tr>
				<td>".lang("New Alternative:", "admin_wannabemin", "Text to display in wannabemin&action=addQueRadio")."</td>
				<td><input type='text' name='alt'></td>
			  </tr>
			  <tr>
				<td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text to display in wannabemin&action=addQueRadio")."'></td>
			  	<td><a href='admin.php?adminmode=wannabemin'>".lang("Save", "admin_wannabemin", "Text to display in wannabemin&action=DoaddQueRadio")."</a></td>
			  </tr>
			</table>
		  </form>
		";
	
	}
}

elseif($action == "DoaddQueRadio") {
	
	$Alt		=	$_POST['alt'];
	$Que		=	$_POST['que'];
	$id			=	$_GET['id'];
	
	$Alt		=	escape_string($Alt);
	$Que		=	escape_string($Que);
	$id			=	escape_string($id);
	
	if(!empty($Que) || !empty($Alt)) {
	
	$query		=	"SELECT * FROM wannabeQue WHERE content = '$Que'";
	$result 	= 	query($query);
	$r			=	fetch($result);
	
	$QueId		=	$r->id;
	
	} else {
	 $QueId = $id;
	 $Alt   = $id;
	}

	
	if(empty($QueId) || empty($Alt)) {
	
	nicedie(lang("Are you completly sure you did not forget something?", "admin_wannabemin", "Error message in wannabemin&action=DoaddQueRadio"));
	
	} else {
	
	 if(empty($id)) {
	  $query	= 	"INSERT INTO wannabeAltRadio (id, content, queid) VALUES (NULL, '$Alt', '$QueId')";
	  $result 	= 	query($query);
	 }
	
	}
	
	$list		=	"";

	$query 	= 	"SELECT * FROM wannabeAltRadio WHERE queid = '$QueId'";
	$result = 	query($query);

	 while($Alt = mysql_fetch_assoc($result)) {
 	  
	  $oldAlt	= $Alt['content'];
	  $altID	= $Alt['id'];
	  $list	   .= 	"
		<tr>
		  <td>".lang("Alternative", "admin_wannabemin", "Text to display in wannabemin&action=DoaddQueRadio")."</td>
		  <td>$oldAlt</td>
		  <td><a href='admin.php?adminmode=wannabemin&action=DelRadioAlt&id=$altID'>delete</a></td>
		</tr>
	   ";

	 }

	echo "
		  <form name='addQueRadio' method='post' action='admin.php?adminmode=wannabemin&action=DoaddQueRadio'>
		  <input type='hidden' name='que' value='$Que'>
		   <table>
			<tr>
			  <td>".lang("Add Alternatives", "admin_wannabemin", "Text to display in wannabemin&action=DoaddQueRadio")."</td>
			</tr>
			 ".$list."
			  <tr>
				<td>".lang("New Alternative:", "admin_wannabemin", "Text to display in wannabemin&action=DoaddQueRadio")."</td>
				<td><input type='text' name='alt'></td>
			  </tr>
			  <tr>
				<td><input type='submit' name='Submit' value='".lang("Add", "admin_wannabemin", "Text to display in wannabemin&action=DoaddQueRadio")."'></td>
			  	<td><a href='admin.php?adminmode=wannabemin'>".lang("Save", "admin_wannabemin", "Text to display in wannabemin&action=DoaddQueRadio")."</a></td>
			  </tr>
			</table>
		  </form>
		";

}

elseif($action == "ViewUsers") {

	$query		=	"SELECT * FROM users WHERE wannabe = '1'";
	$result 	= 	query($query);
	
	$count		=	mysql_num_rows($result);
	
	$list		=	"
	<table>
	 <tr>
	  <td>".lang("View Users", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</td>
	 </tr>
	 ";
	 
	 if(!$count) {
	  $list	   .= "
	  <tr>
	   <td>".lang("Nobody here", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</td>
	  </tr>
	  ";
	 } else {
	
	 while($User = mysql_fetch_assoc($result)) {
	  
	  $Nick		=	$User['nick'];
	  $Id		=	$User['ID'];
	  
	  $list	   .=	"
	  	<tr>
		 <td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$Id'>$Id</a></td>
		 <td><a href='admin.php?adminmode=wannabemin&action=DoViewUsers&id=$Id'>$Nick</a></td>
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
	
	$query		=	"SELECT * FROM wannabeUsers WHERE user = '$UserID'";
	$result 	= 	query($query);
	
	$list		=	"
	<table>
	 <tr>
	  <td><b>".lang("View Users", "admin_wannabemin", "Text to display in wannabemin&action=ViewUsers")."</b></td>
	 </tr>
	 ";
	
	while($Get = mysql_fetch_assoc($result)) {
	
	$Ans		=	$Get['ans'];
	$QueID		=	$Get['queid'];
	$CatID		=	$Get['catid'];
	
	$query		=	"SELECT * FROM wannabeQue WHERE id = '$QueID'";
	$result 	= 	query($query);
	$e			=	fetch($result);
	
	$Type		=	$e->Type;
	$Que		=	$e->content;

	$query		=	"SELECT * FROM wannabeCat WHERE id = '$CatID'";
	$result 	= 	query($query);
	$z			=	fetch($result);
	
	$Cat		=	$z->content;


	if($Type) {
	
	$query		=	"SELECT * FROM wannabeAltRadio WHERE id = '$Ans'";
	$result 	= 	query($query);
	$r			=	fetch($result);
	
	$Alt		=	$r->content;
	
	$list 	   .=	"
		<tr>
		 <td>".lang("Question:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")." $Que ".lang("Crew Type:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")." $Cat</td>
		</tr>
		<tr>
		 <td>$Ans</td>
		</tr>
	";
	} else {
	
	$list 	   .=	"
		<tr>
		 <td>".lang("Question:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")." $Que ".lang("Crew Type:", "admin_wannabemin", "Text to display in wannabemin&action=DoViewUsers")." $Cat</td>
		</tr>
		<tr>
		 <td>$Ans</td>
		</tr>
	";
	
	}
  }
  $list	   .= "</table>";
  echo $list;
}


elseif($action == "DelRadioAlt") {

	$Alt		=	$_GET['id'];
	$Alt		=	escape_string($Alt);

	$query		=	"SELECT * FROM wannabeAltRadio WHERE id = '$Alt'";
	$result 	= 	query($query);
	$r			=	fetch($result);
	
	$id			=	$r->queid;
	
	$query		=	"DELETE FROM wannabeAltRadio WHERE id = '$Alt'";
	$result 	= 	query($query);
	
	
	
	echo lang("Alternative has been deleted", "admin_wannabemin", "Text to display in wannabemin&action=DelRadioAlt");

	refresh("admin.php?adminmode=wannabemin&action=DoaddQueRadio&id=$id", 2);


}
?>