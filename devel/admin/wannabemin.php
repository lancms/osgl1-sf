<?php

require 'config/config.php';

if (!acl_access("wannabe"))
{
	nicedie($admin['noaccess']);
}

$action = $_GET['action'];

$Type	= $_POST['type'];

if($Type == "Txt") {
  $action = "addQueTxt";
}
elseif($Type == "Radio") {
  $action = "addQueRadio";
}

## FUNCTIONS ##

	function getQueId($Que) {

	  $query	= 	"SELECT * FROM wannabeQue WHERE content = '$Que'";
	  $result 	= 	mysql_query($query) or
					die(mysql_error());

	  $Que 		= 	mysql_fetch_assoc($result);

	  return		$Que['id'];

	}

	function getNick($Id) {

	  $query	= 	"SELECT * FROM users WHERE id = '$Id' AND wannabe = '1'";
	  $result 	= 	mysql_query($query) or
					die(mysql_error());

	  $Que 		= 	mysql_fetch_assoc($result);

	  return		$Que['nick'];

	}

	function listAlt($QueId) {

	 $rtn		=	"";

	  $query 	= 	"SELECT * FROM wannabeAltRadio WHERE queid = '$QueId'";
	  $result 	= 	mysql_query($query) or
					die(mysql_error());

	  while($Alt = mysql_fetch_assoc($result)) {

	  $oldAlt	= $Alt['content'];

	   $rtn		.= 	"
		<tr>
		  <td>Alternative:</td>
		  <td>$oldAlt</td>
		</tr>
	   ";

	  }

	 return $rtn;

	}

	function listCat() {

	 $list		=	"";

	 $query		= 	"SELECT * FROM wannabeCat";
	 $result 	= 	mysql_query($query) or
					die(mysql_error());

	  while($cat = mysql_fetch_assoc($result)) {

	   $id		=	$cat['id'];
	   $name	=	$cat['name'];

	   $list 	.= "<option value='$id'>$name</option>\n";

	  }

	  return 		$list;

	}

## END ##


if(!isset($action)) {
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=addCat'>Add catagory</a><br>";
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=addQue'>Add question</a><br>";
	echo "&bull; <a href='admin.php?adminmode=wannabemin&action=ViewUsers'>View Users</a>";
}

elseif($action == "addCat") {
	echo "
		<form name='addCat' method='post' action='admin.php?adminmode=wannabemin&action=DoaddCat'>
		  <table width='400'>
			<tr>
			  <td colspan='2'><strong>Add Catogory</strong></td>
			</tr>
			<tr>
			  <td>Catogory name: </td>
			  <td><input type='text' name='CatName'></td>
			</tr>
			<tr>
			  <td>Catogory info: </td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td colspan='2'><textarea name='CatInfo' cols='52' rows='5'></textarea></td>
			</tr>
			<tr>
			  <td colspan='2'><input type='submit' name='addCat' value='Legg til'></td>
			</tr>
		  </table>
		</form>
		";
}

elseif($action == "DoaddCat") {

	$CatName	=	$_POST['CatName'];
 	$CatInfo	=	$_POST['CatInfo'];

	$query		= 	"INSERT INTO wannabeCat (id, name, info) VALUES (NULL, '$CatName', '$CatInfo')";
	$result 	= 	mysql_query($query) or
					die(mysql_error());

	refresh("admin.php?adminmode=wannabemin", 0);
}

elseif($action == "addQueTxt") {

	$Que		=	$_POST['que'];
	$Cat		=	$_POST['cat'];

	$query		= 	"INSERT INTO wannabeQue (id, content, catid, type) VALUES (NULL, '$Que', '$Cat', '0')";
  	$result 	= 	mysql_query($query) or
					die(mysql_error());

	echo "Spørsmålet \"".$Que."\" ble lagt til";

	refresh("admin.php?adminmode=wannabemin", 2);
}

elseif($action == "addQue") {

	echo "
		<form name='addQue' method='post' action='admin.php?adminmode=wannabemin&action=addQue'>
		  <table width='400'>
			<tr>
			  <td colspan='2'><strong>Add Quest </strong></td>
			</tr>
			<tr>
			  <td>Question:</td>
			  <td><input type='text' name='que'></td>
			</tr>
			<tr>
			  <td>Type:</td>
			  <td><select name='type'>
				<option value='Txt'>Tekst sp&oslash;rsm&aring;l</option>
				<option value='Radio'>Radio sp&oslash;rsm&aring;l</option>
			  </select></td>
			</tr>
			<tr>
			  <td>Catogory:</td>
			  <td><select name='cat'>
			  ".listCat()."
			  </select></td>
			</tr>
			<tr>
			  <td colspan='2'><input type='submit' name='Submit' value='Add'></td>
			</tr>
		  </table>
		</form>
		";
}

elseif($action == "addQueRadio") {

	$Cat		=	$_POST['cat'];
	$Que		=	$_POST['que'];
	$QueId		=	getQueId($Que);

	$query		= 	"INSERT INTO wannabeQue (id, content, catid, type) VALUES (NULL, '$Que', '$Cat', '1')";
  	$result 	= 	mysql_query($query) or
					die(mysql_error());

	echo "
		  <form name='addQueRadio' method='post' action='admin.php?adminmode=wannabemin&action=DoaddQueRadio'>
		  <input type='hidden' name='que' value='$Que'>
		   <table width='400'>
			<tr>
			  <td colspan='2'>Add Alternatives </td>
			</tr>
			 ".listAlt($QueId)."
			  <tr>
				<td>Alternative:</td>
				<td><input type='text' name='alt'></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><input type='submit' name='Submit' value='Add'></td>
			  </tr>
			</table>
		  </form>
		";
}

elseif($action == "DoaddQueRadio") {

	$Que		=	$_POST['que'];
	$QueId		=	getQueId($Que);
	$Alt		=	$_POST['alt'];

	$query	= 	"INSERT INTO wannabeAltRadio (id, content, queid) VALUES (NULL, '$Alt', '$QueId')";
	$result = 	mysql_query($query) or
				die(mysql_error());

	echo "
		  <form name='addQueRadio' method='post' action='admin.php?adminmode=wannabemin&action=DoaddQueRadio'>
		  <input type='hidden' name='que' value='$Que'>
		   <table width='400'>
			<tr>
			  <td colspan='2'>Add Alternatives </td>
			</tr>
			 ".listAlt($QueId)."
			  <tr>
				<td>Alternative:</td>
				<td><input type='text' name='alt'></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><input type='submit' name='Submit' value='Add'></td>
			  </tr>
			</table>
		  </form>
		";

}

elseif($action == "ViewUsers") {

	echo "dette ble jeg ikke helt ferdig med<br>men det kommer snart..";


}
?>