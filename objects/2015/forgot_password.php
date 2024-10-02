<?php    
	require_once(DOCUMENT.'/lib/phpmailer/src/Exception.php');
    require_once(DOCUMENT.'/lib/phpmailer/src/PHPMailer.php');
    require_once(DOCUMENT.'/lib/phpmailer/src/SMTP.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
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
            if ($qnumber == 1) :
                if (!preg_match('/^[0-9]{10}$/', $qanswer)) :
                    echo '{"success": false, "error": "The SSS # must be a valid 10-digit number. No special characters."}';
                    exit();
                endif;
            elseif ($qnumber == 2) :
                if (!preg_match('/^[0-9]{9}$/', $qanswer)) :
                    echo '{"success": false, "error": "The TIN # must be a valid 9-digit number. No special characters."}';
                    exit();
                endif;
            elseif ($qnumber == 3) :
                if (!preg_match('/^[0-9]{12}$/', $qanswer)) :
                    echo '{"success": false, "error": "The PAGIBIG # must be a valid 12-digit number. No special characters."}';
                    exit();
                endif;
            endif;

            $emp_info = $logsql->get_member_forgot_password($_POST['empidnum'], $qanswer);

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

                $bytes = openssl_random_pseudo_bytes(50);
                $token = bin2hex($bytes);

                $reset = $logsql->insert_reset_token($_POST['empidnum'], $emp_info[0]['EmailAdd'], $token);
                $reset_link = WEB.'/reset-password?token='.$token;
                //var_dump($reset_link);

                $email = new PHPMailer(true);
                $email->SetFrom(NOTIFICATION_EMAIL); 
                if(DBHOST == "192.168.13.33"){
                    $email->IsSMTP();  // telling the class to use SMTP
                    $email->Host     = "192.168.13.34"; // SMTP server
                    $email->Port       = 1025; // set the SMTP port for the Gemail server
                    $email->Username   = "noreply@alias.megaworldcorp.com"; // SMTP account username example
                    $email->Password   = "";
                }

                $message = "<div style='display: block; border: 5px solid #024485; padding: 10px; font-size: 12px; font-family: Verdana; width: 100%;'><span style='font-size: 18px; color: #024485; font-weight: bold;'>Megaworld SSEP Password Reset</span><br><br>Hi ".$emp_info[0]['FName'].",<br><br>";
                $message .= "You are receiving this email because we received a password reset request for your account.<br>";
                $message .= "Please click <a href='".$reset_link."'>here</a> to reset your password<br><br>";
                $message .= "If you did not request a password reset, no further action is required.<br><br>";
                $message .= "Note: Reset link expires after an hour.<br><br>";
                $message .= "Thanks,<br>";
                $message .= "Megaworld SSEP Admin";
                $message .= "<hr />".MAILFOOT."</div>";
                
                $email->Subject   = 'Megaworld SSEP Password Reset';
                $email->Body      = $message;
                $email->IsHTML(true);

                if($emp_info[0]['Active']){
                    $email->addAddress( $emp_info[0]['EmailAdd'] );
                }else {
                    $email->addAddress( $emp_info[0]['EmailAdd2'] );
                }

                if($email->Send()) {
                    echo '{"success": true}';
                    exit();
                }else {
                    
                    echo '{"success": false, "error": "Mail error"}';
                    exit();
                }
            else :
                echo '{"success": false, "error": "The account is not exist or inactive. Please call payroll department"}';
                exit();
            endif;
    
        endif;

        $qnum = rand(1, 3);

	endif;
	
?>