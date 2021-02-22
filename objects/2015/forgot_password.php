<?php    
	
	if ($logged == 1) :

		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";		

	else :
	        
        //*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Forgot Password";	
		
		//***********************  MAIN CODE END  **********************\\
        
        global $sroot;
        
        if ($_POST['btnforgot'] || $_POST['btnforgot_x']) : 

            $qnumber = trim($_POST['qnumber']);
            $qanswer = trim(str_replace('-', '', $_POST['empidnum2']));
            
            $emp_info = $logsql->get_member($_POST['empidnum']);

            if ($emp_info) :

                if ($qnumber == 1 && $emp_info[0]['SSSNbr']) :
                    if (trim(str_replace('-', '', $emp_info[0]['SSSNbr'])) != $qanswer) :
                        echo '{"success": false, "error": "SSS Number you provide is incorrect"}';
                        exit();
                    endif;
                elseif ($qnumber == 2 && $emp_info[0]['TINNbr']) :
                    if (trim(str_replace('-', '', $emp_info[0]['TINNbr'])) != $qanswer) :
                        echo '{"success": false, "error": "TIN Number you provide is incorrect"}';
                        exit();
                    endif;
                elseif ($qnumber == 3 && $emp_info[0]['PagibigNbr']) :
                    if (trim(str_replace('-', '', $emp_info[0]['PagibigNbr'])) != $qanswer) :
                        echo '{"success": false, "error": "PagIBIG Number you provide is incorrect"}';
                        exit();
                    endif;
                endif;

                $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Megaworld SSEP Password Retrieve</span><br><br>Hi ".$emp_info[0]['FName'].",<br><br>";
                $message .= "Your account password has been successfully retrieve.<br><br>";
                $message .= "<b>".$emp_info[0]['EPassword']."</b><br><br>";
                $message .= "Please click <a href='".WEB."'>here</a> to log in<br><br>";
                $message .= "Thanks,<br>";
                $message .= "Megaworld SSEP Admin";
                $message .= "<hr />".MAILFOOT."</div>";
                
                $headers = "From: ssap-noreply@alias.megaworldcorp.com\r\n";
                $headers .= "Reply-To: noreply@megaworldcorp.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
                $sendmail = mail($emp_info[0]['EmailAdd'], "Megaworld SSEP Password Change", $message, $headers);   

                if ($sendmail) :

                    //AUDIT TRAIL
                    $post['EMPID'] = $profile_idnum;
                    $post['TASKS'] = "FORGOT_PASSWORD";
                    $post['DATA'] = $profile_idnum;
                    $post['DATE'] = date("m/d/Y H:i:s.000");

                    //$log = $tblsql->log_action($post, 'add');

                    echo '{"success": true}';
                    exit();
                else :
                    echo '{"success": false, "error": "Mail error"}';
                    exit();
                endif;
            else :
                echo '{"success": false, "error": "The account is not exist or inactive. Please call payroll department"}';
                exit();
            endif;
    
        endif;

        $qnum = rand(1, 3);

	endif;
	
?>