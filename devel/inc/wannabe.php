<?php

require_once 'config/config.php';

$action	=	$_GET['action'];
$user	=	getcurrentuserid();

if(!isset($action)) {

	$query	=	"SELECT * FROM users WHERE ID = '$user'";
	$result	=	query($query);

	$var	=	fetch($result);

	$Agree 	=	$var->wannabe;

	if($Agree == 1) {
	 $Agree = " checked";
	}

	echo 	"
	<form name='Agree' method='post' action='index.php?inc=wannabe&action=ListQue'>
	<input type='checkbox' name='Agree' value='1'".$Agree.">
	".lang("Yes, I want to be a crew member!", "inc_wannabe", "Text used in wannabe")."
	<br><input type='submit' name='Submit' value='".lang("Continue", "inc_wannabe", "Text used in wannabe")."'>
	</form>
	";

}

elseif($action == "ListQue") {

	$Agree	=	$_POST['Agree'];

	if($Agree != 1) {
		echo lang("You must check the checkbox", "inc_wannabe", "Text used in wannabe");
		refresh("index.php?inc=wannabe", 2);
	} else {

	$list	=	"
	<form name='SelQue' method='post' action='index.php?inc=wannabe&action=EndQue'>
	 <table>
	  <tr>
	   <td><b>".lang("Wannabe", "inc_wannabe", "Text to display in wannabe")."</b></td>
	  </tr>
	 ";

	$query	=	"SELECT * FROM wannabeQue";
	$result	=	query($query);

		while($var 	= fetch($result)) {

		$ID		=	$var->ID;
		$Que	=	$var->content;
		$Type	=	$var->type;

		$list  .= 	"
		<tr>
		 <td><b>".$Que."<b></td>
		</tr>
		";


		if($Type == 1) {

			$query2		=	"SELECT * FROM wannabeAlt WHERE queID = '$ID'";
			$result2	=	query($query2);

			while($var2 = fetch($result2)) {

			$AltID		=	$var2->ID;
			$Alt		=	$var2->content;


			$query3		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND  queID = '$ID'";
			$result3 	= 	query($query3);

			$Sel		= 	fetch($result3);
			$SelID		=	$Sel->ans;

			$Check		=	"";

			if($SelID == $AltID) {
		 	 $Check		=	" checked";
			}

			$list   .= "
			<tr>
			 <td><input type='radio' name='".$ID."' value='".$AltID."'".$Check.">".$Alt."</td>
			</tr>
			";

			}

		} else {

			$query4		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND queID = '$ID'";
			$result4 	= 	query($query4);
			$Answ		= 	fetch($result4);

			$Text		=	$Answ->ans;

			$list 	.= "
			 <tr>
			   <td><textarea name='$ID'>".$Text."</textarea></td>
			 </tr>
			 ";

		}

		$list	.= "
		<tr>
		 <td>&nbsp;</td>
		</tr>
		";

	}



	$list	.= "
	  <tr>
	   <td><input type='submit' name='Submit' value='".lang("Save", "inc_wannabe", "Text to display in wannabe")."'></td>
	  </tr>
	 </table>
	</form>";

	echo $list;

	}

}

elseif($action == "EndQue") {


	$query	= 	"SELECT * FROM wannabeQue";
	$result	= 	query($query);

	  while($Res = fetch($result)) {

	   $ID		=	$Res->ID;
	   $post	=	$_POST[$ID];
	   $post	=	escape_string($post);

	   if(empty($post)) nicedie(lang("Please answer the questions !", "admin_wannabemin", "Text used in wannabemin"));

	   if(!empty($post)) {

	   	$ans		=	$_POST[$ID];
		$ans		=	escape_string($ans);

		$query4		= 	"SELECT * FROM wannabeUsers WHERE queID = '$ID' AND user = '$user'";
		$result4	= 	query($query4);
		$num		=	num($result4);

		if($num >= 1) {
		 $query2 	= 	"UPDATE wannabeUsers SET ans = '$ans' WHERE queID = '$ID' AND user = '$user'";
		} else {
	     $query2 	= 	"INSERT INTO wannabeUsers (ID, user, ans, queID) VALUES (NULL, '$user', '$ans', '$ID')";
		}
		$result2	= 	query($query2);

		query("UPDATE users SET wannabe = '1' WHERE ID = '$user'"); // Just as easy
		$result4	=	query($query);

	   }

	  }

	  echo lang("Updated !", "inc_wannabe", "Text to display in wannabe");

	}



?>