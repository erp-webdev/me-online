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
            $chkmem = $register->check_member($idnum, $oldpass);                
            if (!$chkmem) : 
                echo '{"success":false,"error":"Error: Invalid old password"}';
                exit(); 
            endif;
            if ($newpass != $conpass) : 
                echo '{"success":false,"error":"Error: Password mismatch"}';
                exit(); 
            endif;
                    
            $edit_password = $register->change_password($newpass, $idnum, $dbname);
        
            //AUDIT TRAIL
            $post['EMPID'] = $profile_idnum;
            $post['TASKS'] = "CHANGE_PASSWORD";
            $post['DATA'] = $idnum;
            $post['DATE'] = date("m/d/Y H:i:s.000");

            $log = $mainsql->log_action($post, 'add');
        
            echo '{"success":true}';
            exit(); 
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
	}

	
?>