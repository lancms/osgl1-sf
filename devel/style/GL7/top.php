<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
require_once 'config/config.php';
/*
echo $_SERVER['PHP_SELF'];
foreach ($_SERVER['argv'] as $name => $value) {
	if($name == "?") echo "?";
	else
		echo $name."=".$value;
}
*/
?>
<html>
<head>
<meta name="Design" content="Design by: wasp^ http://mats.rove.no">
<title>Globelan 7</title>
<link href="style/GL7/style.css" rel="stylesheet" type="text/css">
</head>

<body topmargin="0" leftmargin="0">


<!-- LOGO START -->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td class=blue-pic width="100%" height="5"></td>
        </tr>
        <tr>
          <td class=logo width="100%" height="13"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td width="100%" background="style/GL7/images/logo_bak.gif"><a href="index.php"><img border="0" src="style/GL7/images/logo.jpg" width="591" height="107"></a></td>
  </tr>
  <tr>
    <td width="100%">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td class=logo width="100%" height="13"></td
        ></tr>
        <tr>
          <td class=blue-pic width="100%" height="5"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-- LOGO SLUTT -->


<!-- Hovedtabell START -->
<table border="0" width="100%" cellspacing="0" cellpadding="0" height="574">
  <tr>
    <td width="100%" height="574">
      <table border="0" width="100%" cellspacing="0" cellpadding="0" height="151">
        <tr valign="top">
          <td class=sidetabeller  width="15%" height="625">

		              <!-- Meny venstre START -->
		              <table border="0" width="100%" cellspacing="0" cellpadding="0">
		                <tr>
		                  <td width="100%"> <table border="0" width="100%" cellspacing="0" cellpadding="0" height="1">
		                      <tr>
		                        <td class=menyfarge width="100%" height="19"> <table border="0" width="100%" cellpadding="0">
		                            <tr>
		                              <td class=menyfarge width="100%">Meny</td>
		                            </tr>
		                          </table></td>
		                      </tr>
		                      <tr>
		                        <td class=blue-pic width="100%" height="5"></td>
		                      </tr>
		                    </table></td>
              </tr>


			                <tr>
			                  <td width="100%"> <table cellSpacing="4" cellPadding="0" width="100%" border="0">
			                      <tr>
			                        <td width="100%" valign="top"> <table cellSpacing="0" cellPadding="0" width="100%" border="0">
			                            <tbody>
			                              <tr>
			                                <td width="100%" valign="top"> <table width="100%" height="27">
                                  <tbody>
                                  <?php include 'style/menu.php'; ?>

</tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%"> <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class=menyfarge width="100%"> <table border="0" width="100%" cellpadding="0">
                          <tr>
                            <td class=menyfarge width="100%">Users online</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td class=blue-pic width="100%" height="5"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%"> <table border="0" width="100%" cellpadding="0">
                    <tr>
                      <?php include 'style_incs/online_users.php'; ?>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%"> <table border="0" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class=menyfarge width="100%"> <table border="0" width="100%" cellpadding="0">
                          <tr>
                            <td class=menyfarge width="100%">Vote</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td class=blue-pic width="100%" height="5"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%"> <table border="0" width="100%" cellpadding="0">
                    <tr>
                      <td width="100%">
                      <?php include_once 'style_incs/show_vote.php'; ?>
                        </td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td width="100%"></td>
              </tr>
            </table>
          </td>
<!-- Meny venstre SLUTT -->
		  <!-- Tabell før midt START -->
		            
          <td width="70%" height="625"><table width="99%" height="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td align="center" valign="top"><p>&nbsp;<br>
