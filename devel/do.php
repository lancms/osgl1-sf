<?php

require_once 'config/config.php';

$action = $_GET['action'];

if(!isset($action)) {
	require_once $base_path."style/top.php";
	nicedie("Hacking?");
}

if($action=="login") {
    if(isset($_POST['username']) && isset($_POST[password])) {
        $username = $_POST['username'];
        $pwd = $_POST['password'];
    } else {
        nicedie();
    }

    $res = log_in($username, $pwd);

    elseif($res == -1) // the password is incorrect
    {
        include $base_path."style/top.php";
        echo "The password you entered is incorrect for this user";
    }
    elseif($res == -2) { // User not verified
        $uid = getuseridx($username, $pwd);
        header("Location: do.php?action=verify&uid=$uid");
    }
    elseif($res == 1)
    {
	    $q = query("SELECT password,ID,rememberMe FROM users WHERE nick LIKE '$username' AND rememberMe = 1");
	    if(num($q) == 1) {
		    $r =fetch($q);
		    setcookie($cookiename."_remID", $r->ID, time()+(24*60*60));
		    setcookie($cookiename."_remPASS", $r->password, time()+10800);
	    }
		    
        header("Location: index.php");
    }
    else
    {
        include $base_path."style/top.php";
        echo "Unknown error : $res";
    }

} elseif($action=="logout") {
    $res = log_out();
    include $base_path."style/top.php";
    if($res == 0)
        echo "You are not logged in.";
    else
        echo "Logged out!";

} elseif($action=="verify") {
    include $base_path."style/top.php";
    ?>
	 <?php
	 echo $msg[23];
	 echo "<br>";
	 echo $msg[24];
	 ?>
    <form method=post action=do.php?action=doverify>
    <input type=text name=verifycode>
    <input type=submit value='<?php echo $form[59]; ?>'>
    <input type=hidden value='<?php echo $_GET["uid"]; ?>' name="uid">
    </form>
	 <?php
} elseif($action=="doverify") {

    $uid = $_POST['uid'];
    $my_userID = $uid;
    db_connect();
    $sql_query = "SELECT verified FROM users WHERE ID = $my_userID";
    $query = mysql_query($sql_query) or die(mysql_error());
    $result = mysql_fetch_object($query);

    if($result->verified == $_POST['verifycode']) {

        include $base_path."style/top.php";
        echo $msg[3];
        $query = mysql_query("UPDATE users SET verified = 0 WHERE ID = $my_userID") or die(mysql_error());
        $sID = $_COOKIE[$cookiename];
        $login = mysql_query("UPDATE session SET userID = $my_userID WHERE sID = '$sID'");
    } else {
        echo $msg[4];
    }


} else {
	// Default reason works.
	nicedie();
}





include $base_path."style/bottom.php";
?>
