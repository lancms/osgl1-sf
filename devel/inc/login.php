<?php
require_once 'config/config.php';

$q = getcurrentuserid();

//echo "$q\n<br>";

if($q == 1)
{
    ?>
    <form method=post action=do.php?action=login>
    <br>
    <input type=text name=username size=10>
    <br>
    <input type=password name=password size=10>
    <br>
    <input type=submit value='<?php echo $form[0]; ?>'>
    </form>
    <?php
}

/*if((!$query) || (mysql_num_rows($query)==0)) {
    ?>

    <form method=post action=do.php?action=login>
    <br>
    <input type=text name=username size=10>
    <br>
    <input type=password name=password size=10>
    <br>
    <input type=submit value='<?php echo $form[0]; ?>'>
    </form>
    <?php
} else {

}*/

?>