<?php
require_once 'config/config.php';

$action	=	$_GET['action'];
$user	=	getcurrentuserid();

	if(!isset($action)) {


	 $list		=	"";

	 $query		= 	"SELECT * FROM wannabeCat";
	 $result 	= 	query($query);

	  while($cat = mysql_fetch_assoc($result)) {

	   $id		=	$cat['id'];
	   $name	=	$cat['name'];
	   $info	=	$cat['info'];
	 
	   $check	=	"";

	   $query2	= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND catid = '$id'";
	   $result2 = 	query($query2);

	   $result2	=	num($result2);

	    if(!$result2) {

		 $check	.=	"<input type='checkbox' name='SelCat[]' value='$id'>\n";

		} else {

		 $check	.=	"<input type='checkbox' name='SelCat[]' value='$id' checked>\n<font color='red'>*</font>\n";

		}

	   $list 	.= "
			<tr>
			  <td>".$check."</td>
			  <td>$name</td>
			  <td>$info</td>
			</tr>
	   ";

	  }

	 echo "
		<form name='SelCat' method='post' action='index.php?inc=wannabe&action=listQue'>
		  <table width='400'>
			<tr>
			  <td colspan='3'><strong>".lang("Wannabe", "inc_wannabe", "Text to display in wannabe")."</strong></td>
			</tr>
			".$list."
			<tr>
			  <td colspan='3'><input type='submit' name='Submit' value='".lang("Next", "inc_wannabe", "Text to display in wannabe")."'></td>
			</tr>
			<tr>
			  <td colspan='3'><font color='red'>*</font> = ".lang("WTF ?!.", "inc_wannabe", "Text to display in wannabe")."</td>
			</tr>
		  </table>
		</form>

	";

	}

	elseif($action == "listQue") {

	$SelCat	=	$_POST['SelCat'];

	if(empty($SelCat)) {
	 refresh("index.php?inc=wannabe", 0);
	}

	$list = "
	<form name='SelQue' method='post' action='index.php?inc=wannabe&action=EndQue'>
	<table>
	";

	 foreach ($SelCat as $Cats) {

	 $query		= 	"SELECT * FROM wannabeQue WHERE catid = '$Cats'";
	 $result 	= 	query($query);

	  while($cat = mysql_fetch_assoc($result)) {

	   $que		=	$cat['content'];
	   $type	=	$cat['type'];
	   $id		=	$cat['id'];

	   $list 	.= "
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>$que</td>
			</tr>
	   ";

	   if(!$type) {
	 	
		$query2		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND queid = '$queid'";
	 	$result2 	= 	query($query2);
	 	$Answ		= 	fetch_array($result2);

	 	$Text		=	$Answ->ans;
	   
	    $list 	.= "
		 <tr>
		   <td><textarea name='$id'>".$Text."</textarea></td>
		 </tr>
		 ";
		 
		} else {

		$query2		= 	"SELECT * FROM wannabeAltRadio WHERE queid = '$id'";
		$result2	= 	query($query2);

		while($Que = mysql_fetch_assoc($result2)) {

			$Alt   = $Que['content'];
			$AltId = $Que['id'];
			$Quest = $Que['queid'];

			$query3		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND  queid = '$Que'";
			$result3 	= 	query($query3);

			$Sel		= 	fetch_array($result3);
			$SelAlt		=	$Sel->ans;
			
			if($SelAlt == $AltId) {
		 	 $Check		=	"checked";
			}

			$list .= "
			<tr>
			 <td><input type='radio' name='$id' value='$AltId'".$Check.">$Alt</td>
			</tr>";

		 }
		}
	   }
	  }
	$list .= "
	<tr>
	 <td><input type='submit' name='Submit' value='".lang("Save", "inc_wannabe", "Text to display in wannabe")."'></td>
	</tr>
	</table>
	</form>";
	echo $list;
	}

	elseif($action == "EndQue") {

	$query	= 	"SELECT * FROM wannabeQue";
	$result	= 	query($query);

	  while($Res = mysql_fetch_assoc($result)) {

	   $id		=	$Res['id'];
	   $post	=	$_POST[$id];


	   if(!empty($post)) {

	   	$ans		=	$_POST[$id];
		$ans		=	escape_string($ans);
	   
		$query3		= 	"SELECT * FROM wannabeQue WHERE id = '$id'";
		$result3	= 	query($query3);
		$Var		= 	fetch_array($result3);

		$queid		=	$Var->id;
		$catid		=	$Var->catid;
		

		$query4		= 	"SELECT * FROM wannabeUsers WHERE queid = '$queid' AND user = '$user'";
		$result4	= 	query($query4);
		$num		=	num($result4);
		
		$query5		=	"SELECT * FROM users WHERE nick = '$user'";
		$result5	=	query($query5);
		$Usr		=	fetch_array($result5);
		
		$userID		=	$Usr->ID;

		if($num) {
		 $query2 	= 	"UPDATE wannabeUsers SET ans = '$ans' WHERE queid = '$queid' AND user = '$userID'";
		} else {
	     $query2 	= 	"INSERT INTO wannabeUsers (id, user, ans, queid, catid) VALUES (NULL, '$user', '$ans', '$queid', '$catid')";
		}
		$result2	= 	query($query2);

	   }

	  }

	  echo lang("Updated !", "inc_wannabe", "Text to display in wannabe");

	 }


?>