<?php
require_once 'config/config.php';
?>

<table><tr><td></td>
<td>
<form method=POST action=index.php?kiosk=kiosk&action=togglecrewsale><input type=submit value='<?php
$sale = crewsale(); 
echo $crewsale[$sale]; ?>'>
</form>
</td>
<td width=40%><?php /*
<form method=POST action=login.php?action=changeuser>
<?php /*select_su();  ?>
<input type=submit value='Bytt bruker'>
</form>
*/ ?>
</td></tr>
<tr><td>
