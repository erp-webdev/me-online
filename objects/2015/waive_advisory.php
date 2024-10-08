<?php
   if($logged == 1){
      $user = $logsql->check_login_user($profile_idnum, $profile_email);
      $waive = $user[0]['password_waive'] ? $user[0]['password_waive'] + 1 : 1;

      if($waive<=MAX_PASSWORD_WAIVE){
         $logsql->update_users_activity($profile_idnum, $profile_email, $waive);
         echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
      }
      else{
         echo "<script> alert('You have already waived the password update advisory three times which is the maximum limit. To ensure the security of your account, it is now mandatory to change your password.')</script>";
         echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/change_password'</script>";
      }
   }
?>
