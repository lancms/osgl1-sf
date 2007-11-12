<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
require_once 'config/config.php';
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html lang="EN">

  <head>
    <title>OSGlobeLan</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" type="text/css" href="style/default/style.css">
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
	</script>
	<script type="text/javascript">
	_uacct = "UA-2253518-8";
	urchinTracker();
</script>
  </head>

  <body>
    <div id="box">

	  <div id="header">
	    <h1>OSGlobeLan</h1>
	  </div>

	  <div id="menu">
	    <h2>Menu</h2>
		 <ul>
			<?php
			include_once 'style/menu.php';
			?>

		</ul>
	  </div>

	  <div id="content">
