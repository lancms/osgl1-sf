<?php

require_once 'config/config.php';

$action	=	$_GET['action'];
$user	=	getcurrentuserid();

if(!isset($action)) {
	
	$query	=	"SELECT * FROM users WHERE id = '$user'";
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
		
		$Id		=	$var->id;
		$Que	=	$var->content;
		$Type	=	$var->type;

		$list  .= 	"
		<tr>
		 <td><b>".$Que."<b></td>
		</tr>
		";
		
		
		if($Type == 1) {
			
			$query2		=	"SELECT * FROM wannabeAlt WHERE queid = '$Id'";
			$result2	=	query($query2);
			
			while($var2 = fetch($result2)) {
			
			$Altid		=	$var2->id;
			$Alt		=	$var2->content;
			
			
			$query3		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND  queid = '$Id'";
			$result3 	= 	query($query3);

			$Sel		= 	fetch($result3);
			$SelId		=	$Sel->ans;

			$Check		=	"";
			
			if($SelId == $Altid) {
		 	 $Check		=	" checked";
			}
			
			$list   .= "
			<tr>
			 <td><input type='radio' name='".$Id."' value='".$Altid."'".$Check.">".$Alt."</td>
			</tr>
			";	
			
			}
		
		} else {
		
			$query4		= 	"SELECT * FROM wannabeUsers WHERE user = '$user' AND queid = '$Id'";
			$result4 	= 	query($query4);
			$Answ		= 	fetch($result4);
	
			$Text		=	$Answ->ans;
		   
			$list 	.= "
			 <tr>
			   <td><textarea name='$Id'>".$Text."</textarea></td>
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

	   $id		=	$Res->id;
	   $post	=	$_POST[$id];
	   $post	=	escape_string($post);
	   
	   if(empty($post)) nicedie(lang("Please answer the questions !", "admin_wannabemin", "Text used in wannabemin"));

	   if(!empty($post)) {

	   	$ans		=	$_POST[$id];
		$ans		=	escape_string($ans);
	   
		$query4		= 	"SELECT * FROM wannabeUsers WHERE queid = '$id' AND user = '$user'";
		$result4	= 	query($query4);
		$num		=	num($result4);

		if($num >= 1) {
		 $query2 	= 	"UPDATE wannabeUsers SET ans = '$ans' WHERE queid = '$id' AND user = '$user'";
		} else {
	     $query2 	= 	"INSERT INTO wannabeUsers (id, user, ans, queid) VALUES (NULL, '$user', '$ans', '$id')";
		}
		$result2	= 	query($query2);
		
		$query3		=	"UPDATE users SET wannabe = '1' WHERE id = '$user'";
		$result4	=	query($query);

	   }

	  }

	  echo lang("Updated !", "inc_wannabe", "Text to display in wannabe");

	}



?>