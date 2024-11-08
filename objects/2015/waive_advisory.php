<?php
   if($logged == 1){
      $user = $logsql->check_login_user($profile_idnum, $profile_email);
      $last_password_update = $user[0]['password_update_at'];

      if($is_password_hashed){
         $last_password_update_span = date('Y-m-d', strtotime('+'.PASSWORD_REMINDER.' month', strtotime($last_password_update)));
     }
     else{
         $last_password_update_span = date('Y-m-d', strtotime('+'.PASSWORD_UPDATE_IF_NOT_HASHED.' month', strtotime($last_password_update)));
     }

     if(date('Y-m-d') >= $last_password_update_span){
         $waive = $user[0]['password_waive'] ? $user[0]['password_waive'] + 1 : 1;

         if($waive<=MAX_PASSWORD_WAIVE){
            $logsql->update_users_activity($profile_idnum, $profile_email, $waive);
         }
         else{
            echo "<script> alert('You have reached the maximum limit of waiving the Password Update Advisory. To ensure the security of your account, you are now required to change your password.')</script>";
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/change_password'</script>";
         }
      }
   }

   echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
?>

