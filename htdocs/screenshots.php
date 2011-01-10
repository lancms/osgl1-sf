<?php

	$page = 'screens';

	require_once ('function.php');
	require_once ('top.php');

?>

<h2>Screenshots</h2>

<p><b>These shots are taken using the SVN trunk at january 10. 2011. The design is called <i>Alfa1</i> (we're good with names!).</b></p>


<a href="screenshots/org/AlfaLAN-main.png"><img src="screenshots/AlfaLAN-main.png" /></a>
<p>This is the main page when you're logged in and an event is chosen (either automaticly by virtualhost or manually).</p>

<a href="screenshots/org/AlfaLAN-register.png"><img src="screenshots/AlfaLAN-register.png" /></a>
<p>This is the user registration form. Some of the fields can be deactivated by the global administrators.</p>

<a href="screenshots/org/AlfaLAN-edit index.png"><img src="screenshots/AlfaLAN-edit index.png" /></a>
<p>Using the tinyMCE editor you can quickly create static pages that look nice.</p>

<a href="screenshots/org/AlfaLAN-eventadmin.png"><img src="screenshots/AlfaLAN-eventadmin.png" /></a>
<p>This is where you find what administrative modules you've got access to for the active event.</p>

<a href="screenshots/org/AlfaLAN-eventconfig.png"><img src="screenshots/AlfaLAN-eventconfig.png" /></a>
<p>Event administrators can activate and deactive modules as they see fit.</p>

<a href="screenshots/org/AlfaLAN-globaladmin.png"><img src="screenshots/AlfaLAN-globaladmin.png" /></a>
<p>Global administrators may add events and have access to all parts of the system.</p>

<?php
	require_once ('bottom.php');
?>
