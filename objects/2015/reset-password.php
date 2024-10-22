<?php
   include(CLASSES."/regsql.class.php");
   if ($logged == 1) :

      echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";		

   else :
         
      //*********************** MAIN CODE START **********************\\
         
         # ASSIGNED VALUE
         $page_title = "Reset Password";	
      
      //***********************  MAIN CODE END  **********************\\

      $register = new regsql;

      if ($_GET['token']) {
         $_SESSION['reset_token'] = $_GET['token'];
      }
      else{
         $token=$_SESSION['reset_token'];
         $expiry = $logsql->check_reset_token($token);

         if ($expiry) {
            if(isStrongPassword($_POST['resetpassword'])){
               $accounts = $logsql->get_member_by_email($expiry[0]['EmailAdd']);

               if($accounts){
                  foreach($accounts as $acc){
                     $hashedPassword = password_hash($_POST['resetpassword'], PASSWORD_DEFAULT);
                     $register->change_password($_POST['resetpassword'], $hashedPassword, $expiry[0]['EmpID'], $acc['DBNAME']);
                  }

                  //AUDIT TRAIL
                  $post['EMPID'] = $$expiry[0]['EmpID'];
                  $post['TASKS'] = "RESET_PASSWORD";
                  $post['DATA'] = $expiry[0]['EmpID'];
                  $post['DATE'] = date("m/d/Y H:i:s.000");
      
                  //$log = $logsql->log_action($post, 'add');
         
                  echo '{"success":true}';
                  exit(); 
               }
            }
            else{
               echo '{"success":false,"error":"Password should contain uppercase & lowercase letter, a number, and special character, and should be at least 8 characters long."}';
               exit(); 
            }
         } else {
            echo '{"success":false,"error":"Error: Invalid or expired token."}';
            exit(); 
         }
      }

   endif;


   function isStrongPassword($password) {

      if (strpos($password, '&') !== false || strpos($password, '+') !== false) {
          echo '{"success":false,"error":"New password must not contain ampersand (&) nor plus sign (+)."}';
          exit(); 
      }

      // Check if the password is at least 8 characters long
      if (strlen($password) < 8) {
          return false;
      }
      
      // Check if the password contains at least one uppercase letter
      if (!preg_match('/[A-Z]/', $password)) {
          return false;
      }
      
      // Check if the password contains at least one lowercase letter
      if (!preg_match('/[a-z]/', $password)) {
          return false;
      }
      
      // Check if the password contains at least one digit
      if (!preg_match('/[0-9]/', $password)) {
          return false;
      }
      
      // Check if the password contains at least one special character
      if (!preg_match('/[\W_]/', $password)) {
          return false;
      }
      
      return true;
  }
?>
