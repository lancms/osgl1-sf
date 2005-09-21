<?php
require_once ('config/config.php');
$q = getcurrentuserid();
$action = $_GET['action'];

if ($q == 1)
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

if($action == "resendPwd") {

  echo "
  <form method='post' action='?inc=login&action=doResendPwd'>
    " . lang("Forgotten your password?" , "inc_login" , "Forgotten password text") . " <br>
    " . lang("Your mail adress:" , "inc_login" , "Mail adress text") . "
    <input type='text' name='mail'>
    <input type='submit' value='" . lang("Send password" , "inc_login" , "Submit button text") . "'>
  </form>    
  ";

}

elseif ($action == "doResendPwd") {
  $mail = $_POST['mail'];
    
  if(!empty($mail)) {
    
    if( strstr($mail, "@") || strstr($mail, ".") ) {
      
      $query  = "SELECT * FROM users WHERE EMail = '" . $mail . "'";
      $result = query($query);
      
      $num    = num($result);

      if($num == 1) {
      
        $i = fetch($result);
                
        $last = $i->lastPasswordReset;
        $last = $last + $resend_delay;
        
        $time = time();

        if($last < $time) {
          
          $var = "abchefghjkmnpqrstuvwxyz0123456789";
          srand((double)microtime()*1000000);
          $i = 0;
          $length = 10;

          while ($i <= $length) {

            $num = rand() % 33;
            $tmp = substr($var, $num, 1);
            $pass = $pass . $tmp;
            $i++;
          
          }
          
          $tempPwd = $pass;
          
          $query  = "UPDATE users SET lastPasswordReset = '" . time() . "' WHERE EMail = '" . $mail . "'";
          $result = query($query);
          
          $md5Pwd = md5($tempPwd);
          
          $query  = "UPDATE users SET tempPassword = '" . $md5Pwd . "' WHERE EMail = '" . $mail . "'";
          $result = query($query);
          
          /* FIX THIS */
          mail();
          
          echo lang("The password has been sendt to your mail" , "inc_login" , "Sendt mail");

        } else {
          
          echo lang("You can not use this function more today" , "inc_login" , "Too soon");
          refresh("?inc=login&action=resendPwd" , "6");
        
        }
      
      } else {
      
        echo lang("The mail adress is not in the database" , "inc_login" , "Not in db");
        refresh("?inc=login&action=resendPwd" , "2");
        
      }
      
    } else {
      
      echo lang("Your email is not valid" , "inc_login" , "Not valid mail");
      refresh("?inc=login&action=resendPwd" , "2");
     
    }
      
  } else {
    
    echo lang("You need to fill inn your email adress" , "inc_login" , "No-Mail text");
    refresh("?inc=login&action=resendPwd" , "2");
    
  }

}

elseif($action == "verifyPwd") {
 
  echo "
  <form method='post' action='?inc=login&action=doVerifyPwd'>
    " . lang("Forgotten your password?" , "inc_login" , "Forgotten password text") . " <br>
    " . lang("Your mail adress:" , "inc_login" , "Mail adress text") . " <input type='text' name='email'> <br>
    " . lang("Username:" , "inc_login" , "Username text") . " <input type='text' name='username'> <br>
    " . lang("Temp password:" , "inc_login" , "Temp Password text") . " <input type='text' name='tempPwd'> <br>
    <input type='submit' value='" . lang("Verify" , "inc_login" , "Submit button text") . "'>
  </form>
  ";
  
}

elseif($action == "doVerifyPwd") {

  $email    = $_POST['email'];
  $tempPwd  = $_POST['tempPwd'];
  $username = $_POST['username'];
  
  if(empty($email) || empty($tempPwd) || empty($username)) {
    
    echo lang("You need to fill out all the fields" , "inc_login" , "Empty form");
    refresh("?inc=login&action=verifyPwd" , "2");
    
  } else {
  
    $query  = "SELECT * FROM users WHERE EMail = '" . $email . "'";
    $result = query($query);
    
    $i      = fetch($result);
    
    $dbUser = $i->nick;
    $dbTempPwd = md5($i->tempPwd);
    
    if($dbUser == $username) {
    
      if($tempPwd == $dbTempPwd) {
      
        echo lang("Success, please change your password. Ane PLEASE remember it this time" , "inc_login" , "Success text") . " <br>
        <form method='post' action='?inc=login&action=doChangePwd'>
          " . lang("New Password:" , "inc_login" , "Password text") . " <input type='text' name='pwd1'> <br>
          " . lang("Repeat Password" , "inc_login" , "Password text") . " <input type='text' name='pwd2'> <br>
          <input type='submit' value='" . lang("Change" , "inc_login" , "Submit button text") . "'>
        </form>
        ";
      
      } else {
      
        echo lang("The temp password does not match the temp password in the mail" , "inc_login" , "Temp passwords does not match");
        refresh("?inc=login&action=verifyPwd" , "2");
      
      }
    
    } else {
    
      echo lang("The username does not match the email adress" , "inc_login" , "username does not match email");
      refresh("?inc=login&action=verifyPwd");
    
    }
  
  }

}

elseif($action == "doChangePwd") {

  $pwd1   = $_POST['pwd1'];
  $pwd2   = $_POST['pwd2'];
  $MD5Pwd = MD5($pwd1);
  
  if($pwd1 == $pwd2) {
    
    $query  = "UPDATE users SET password = '" . $md5Pwd . "' WHERE EMail = '" . $email . "'";
    $result = query($query);
    
    echo lang("Your password has now been changed, you can now login" , "inc_login" , "Success changed");
    refresh("?inc=login" , "2");
  
  } else {
    
    echo lang("The passwords does not match" , "inc_login" , "Not match");
    refresh("?inc=login&action=verifyPwd" , "2");
  
  }

}
?>
