<?php
require_once 'config/config.php';

$action	=	$_GET['action'];
$user	=	getcurrentuserid();

	## FUNCTIONS ##

	function ifSel($AltId, $Que, $user) {

	$query		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND  queid = '$Que'";
	$result 	= 	mysql_query($query) or
					die(mysql_error());

	$Sel		= 	mysql_fetch_array($result);

		if($Sel['ans'] == $AltId) {
		 return "checked";
		}

	}

	function CatBef($user, $id) {

	 $list		=	"";

	 $query		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND catid = '$id'";
	 $result 	= 	mysql_query($query) or
					die(mysql_error());

	 $result	=	mysql_num_rows($result);

	    if(!$result) {

		 $list	.=	"<input type='checkbox' name='SelCat[]' value='$id'>\n";

		} else {

		 $list	.=	"<input type='checkbox' name='SelCat[]' value='$id' checked>\n<font color='red'>*</font>\n";

		}

	 return	$list;

	}

	function listCat($user) {

	 $list		=	"";

	 $query		= 	"SELECT * FROM wannabeCat";
	 $result 	= 	mysql_query($query) or
					die(mysql_error());

	  while($cat = mysql_fetch_assoc($result)) {

	   $id		=	$cat['id'];
	   $name	=	$cat['name'];
	   $info	=	$cat['info'];

	   $list 	.= "
			<tr>
			  <td>".CatBef($user, $id)."</td>
			  <td>$name</td>
			  <td>$info</td>
			</tr>
	   ";

	  }

	  return 		$list;

	}

	function getOldTxt($user, $queid) {

	 $query		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND queid = '$queid'";
	 $result 	= 	mysql_query($query) or
					die(mysql_error());
	 $Ans		= 	mysql_fetch_array($result);

	 return 	$Ans["ans"];



	}

	## PHP ##

	if(!isset($action)) {

	 echo "
		<form name='SelCat' method='post' action='index.php?inc=wannabe&action=listQue'>
		  <table width='400'>
			<tr>
			  <td colspan='3'><strong>Wannabe</strong></td>
			</tr>
			".listCat($user)."
			<tr>
			  <td colspan='3'><input type='submit' name='Submit' value='Neste'></td>
			</tr>
			<tr>
			  <td colspan='3'><font color='red'>*</font> = Katogorier du har søk i før.</td>
			</tr>
		  </table>
		</form>

	";

	}

	elseif($action == "listQue") {

	$SelCat	=	@$_POST['SelCat'];

	if(empty($SelCat)) {
	 refresh("index.php?inc=wannabe", 0);
	}

	$list = "
	<form name='SelQue' method='post' action='index.php?inc=wannabe&action=EndQue'>
	<table>
	";

	 foreach ($SelCat as $Cats) {

	 $query		= 	"SELECT * FROM wannabeQue WHERE catid = '$Cats'";
	 $result 	= 	mysql_query($query) or
					die(mysql_error());

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
	    $list 	.= "
		 <tr>
		   <td><textarea name='$id'>".getOldTxt($user, $id)."</textarea></td>
		 </tr>
		 ";
		} else {

		$query2		= 	"SELECT * FROM wannabeAltRadio WHERE queid = '$id'";
		$result2	= 	mysql_query($query2) or
						die(mysql_error());

		while($Que = mysql_fetch_assoc($result2)) {

			$Alt   = $Que['content'];
			$AltId = $Que['id'];
			$Quest = $Que['queid'];

			$list .= "
			<tr>
			 <td><input type='radio' name='$id' value='$AltId'".ifSel($AltId, $Quest, $user).">$Alt</td>
			</tr>";

		 }
		}
	   }
	  }
	$list .= "
	<tr>
	 <td><input type='submit' name='Submit' value='Lagre'></td>
	</tr>
	</table>
	</form>";
	echo $list;
	}

	elseif($action == "EndQue") {

	$query	= 	"SELECT * FROM wannabeQue";
	$result	= 	mysql_query($query) or
				die(mysql_error());

	  while($Res = mysql_fetch_assoc($result)) {

	   $id		=	$Res['id'];
	   $post	=	@$_POST[$id];

	   if(!empty($post)) {

	   	$ans		=	@$_POST[$id];

		$query3		= 	"SELECT * FROM wannabeQue WHERE id = '$id'";
		$result3	= 	mysql_query($query3) or
						die(mysql_error());
		$Var		= 	mysql_fetch_array($result3);

		$queid		=	$Var['id'];
		$catid		=	$Var['catid'];

		$query4		= 	"SELECT * FROM wannabeUsers WHERE id = '$id' AND user = '$user'";
		$result4	= 	mysql_query($query4) or
						die(mysql_error());
		$num		=	mysql_num_rows($result4);

		if($num) {
		 $query2 	= 	"UPDATE wannabeUsers SET ans = '$ans' WHERE queid = '$queid' AND user = '$user' AND catid = '$catid'";
		} else {
	     $query2 	= 	"INSERT INTO wannabeUsers (id, user, ans, queid, catid) VALUES (NULL, '$user', '$ans', '$queid', '$catid')";
		}
		$result2	= 	mysql_query($query2) or
					  	die(mysql_error());

	   }

	  }

	  echo "Søknaden din har nå blitt oppdatert";

	 }


?>