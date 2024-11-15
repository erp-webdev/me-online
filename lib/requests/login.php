<?php	

    include("../../config.php");

    extract($_POST);

    if ($admin) :

        $expire = time() + 60;
        $_SESSION['megassep_admin'] = 'admin';
        $_SESSION['ssep_comp'] = NULL;

        $success = $_SESSION['megasubs_admin'];

    else :
        if ($grecaptcharesponse) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if(ENABLE_RECAPTCHA && 
                (!in_array($ip, ['218.66.169.201']) ||     //china
                strpos($ip, '10.10.') !== 0 ||            //agt
                strpos($ip, '192.168.32.') !== 0 ||       //tws
                strpos($ip, '192.168.40.') !== 0 ||        //gcp
                strpos($ip, '172.16.40.') !== 0)           //ueg
            ){           

                $recaptchaResponse = $grecaptcharesponse;
                $secretKey = RECAPTCHA_SECRET_KEY;
                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptchaResponse");
                $responseKeys = json_decode($response, true);
                $proceed_login = $responseKeys["success"];
            }
            else{
                $proceed_login = true;
            }
    
            if ($proceed_login) {
                $cookiename = 'megasubs_user'; 

                $checkfmem = $logsql->check_member($username, $password);
                $getmem = $logsql->get_member2($username, $password);

                $login_failed_attempt = $logsql->check_login_user($username);

                if($login_failed_attempt && $login_failed_attempt[0]['account_locked_at']){
                    $success=2;
                }
                else{
                    if ($checkfmem == 1)
                    {
                        if($getmem[0]['DBNAME'] != 'MARKETING'){
                            $success=1;

                            $is_hash = $getmem[0]['PasswordHash'] ? 1 : 0;

                            $login_failed_attempt ?  $logsql->update_login_failed($username, 0, $getmem[0]['EmailAdd']) : $logsql->insert_user_activity($username, $getmem[0]['EmailAdd'], $is_hash);

                            $expire = time() + 60;
                            $_SESSION[$cookiename] = $username;
                            $_SESSION['ssep_comp'] = $getmem[0]['CompanyID'];
                            $_SESSION['megasubs_password'] = $password;
                            $_SESSION['megasubs_db'] = $getmem[0]['DBNAME'];
                
                            //AUDIT TRAIL
                            $post['EMPID'] = $username;
                            $post['TASKS'] = "LOGIN";
                            $post['DATA'] = $username;
                            $post['DATE'] = date("m/d/Y H:i:s.000");
                            $log = $logsql->log_action($post, 'add');
                        }
                    }        
                    elseif ($checkfmem > 1)
                    {
                        $dbname = '';
                        foreach ($getmem as $key => $value) :
                            $dbname .= "<option value='".trim($value['DBNAME'])."'>".trim($value['DBNAME'])."</option>";
                        endforeach;
                        
                        $success = $dbname;
                        
                    }
                    else
                    {	
                        $success = 0;		
            
                        if($login_failed_attempt){
                            if($login_failed_attempt[0]['login_failed'] < MAX_FAILED_LOGIN){
                                $attempt = $login_failed_attempt[0]['login_failed'] + 1;
                                $logsql->update_login_failed($username, $attempt);

                                $success = ($attempt==MAX_FAILED_LOGIN) ? 2 : 0;
                            }
                            else{
                                $success=2;
                            }
                        }
                        else{
                            $logsql->insert_login_failed($username);
                        }
                    }	 
                }
            } else {
                $success = 3;
            }
        } else {
           $success = 3;
        }
    endif;

	echo $success;

?>