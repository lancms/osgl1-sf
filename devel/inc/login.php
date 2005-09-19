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
          
          $query  = "UPDATE users SET tempPassword = '" . $tempPwd . "' WHERE EMail = '" . $mail . "'";
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
?>
