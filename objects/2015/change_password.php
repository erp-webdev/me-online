<?php

    if ($logged == 1 && $profile_level != 8) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Change Password";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;

		if ($_POST['opassword'] && $_POST['npassword'] && $_POST['cpassword'] && $_POST['dbname']) :
            $idnum = $_POST['empnum'];
            $oldpass = $_POST['opassword'];
            $newpass = $_POST['npassword'];
            $conpass = $_POST['cpassword'];
            $dbname = $_POST['dbname'];

            $chkmem = $register->get_member($idnum, $dbname);  
            
            if ($chkmem) {
                if ($chkmem[0]['PasswordHash']) {
                    if (!(password_verify($oldpass, $chkmem[0]['PasswordHash']))) {
                        echo '{"success":false,"error":"Error: Invalid old password"}';
                        exit(); 
                    }
                } else {
                    $chkmem2 = $register->check_member($idnum, $oldpass);    
                    if(!$chkmem2){
                        echo '{"success":false,"error":"Error: Invalid old password"}';
                        exit(); 
                    }
                }
            }
                
            if ($newpass != $conpass) : 
                echo '{"success":false,"error":"Error: Password mismatch"}';
                exit(); 
            endif;
             
            if(isStrongPassword($newpass)){
                $accounts = $logsql->get_member2($idnum, $oldpass);
   
                if($accounts){
                   foreach($accounts as $acc){
                        $hashedPassword = password_hash($newpass, PASSWORD_DEFAULT);
                        $edit_password = $register->change_password($hashedPassword, $idnum, $acc['DBNAME']);
                        
                   }
                    $logsql->update_users_activity($idnum, $profile_email);
                }

                //AUDIT TRAIL
                $post['EMPID'] = $profile_idnum;
                $post['TASKS'] = "CHANGE_PASSWORD";
                $post['DATA'] = $profile_idnum;
                $post['DATE'] = date("m/d/Y H:i:s.000");
                $log = $mainsql->log_action($post, 'add');
            
                echo '{"success":true}';
                exit(); 
            }
            else{
                echo '{"success":false,"error":"Password should contain uppercase & lowercase letter, a number, and special character, and should be at least 8 characters long."}';
                exit(); 
            }
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
	}


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