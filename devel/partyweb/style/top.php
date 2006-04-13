<html>
<head>
<title>PartyWeb</title>
<link rel="StyleSheet" href="style/style.css" type="text/css">
<?php
$mode = $_GET['mode'];
$screen = $_GET['screen'];
if($mode == "party")  {
if(isset($screen)) $add = "&screen=$screen";
echo "<meta http-equiv=refresh content=\"60; url=?mode=party$add\">";

}
?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table class="tbl_all" width="100%" height="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height=100 align="left" valign="top" bgcolor="#001334"><img src="style/logo.jpg" width="700" height="100"></td>
  </tr>
  <tr>
    <td width="100%" height="100%"><table class="tbl_behindmain" width="100%" height="100%" cellpadding="0" cellspacing="0">
        <tr>
