<?php	

    include("../../config.php");

    extract($_POST);

    function validateTurnstile($token, $secret, $remoteip = null) {
        $url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

        $data = [
            'secret' => $secret,
            'response' => $token
        ];

        if ($remoteip) {
            $data['remoteip'] = $remoteip;
        }

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === FALSE) {
            return ['success' => false, 'error-codes' => ['internal-error']];
        }

        return json_decode($response, true);

    }

    function verifyHCaptcha($token, $ip) {
        $payload = http_build_query([
            "secret" => HCAPTCHA_SECRET_KEY,
            "response" => $token,
            "remoteip" => $ip,
            "sitekey" => HCAPTCHA_SITE_KEY,
        ]);

        $ctx = stream_context_create([
            "http" => [
            "method" => "POST",
            "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            "content" => $payload,
            "timeout" => 5,
            ],
        ]);

        $raw = file_get_contents(
            "https://api.hcaptcha.com/siteverify",
            false,
            $ctx
        );

        $j = json_decode($raw, true);
        if (!empty($j["success"])) {
            return [true, []];
        }

        return [false, $j["error-codes"] ? $j["error-codes"] : []];
    }

    if ($admin) :

        $expire = time() + 60;
        $_SESSION['megassep_admin'] = 'admin';
        $_SESSION['ssep_comp'] = NULL;

        $success = $_SESSION['megasubs_admin'];

    else :
        $proceed_login = false;

        if(ENABLE_CAPTCHA){
            $ip = $_SERVER['REMOTE_ADDR'];
            $ip = '218.66.169.201';
            $ip_exeptions = explode(',', RECAPTCHA_IP_EXCEPTIONS);
            $for_hcaptcha = false;
            if(in_array($ip, $ip_exeptions)){
                $for_hcaptcha = true;
            }

            if($for_hcaptcha){
                $hcaptcha_token = $_POST['captcha_response'] ? $_POST['captcha_response'] : '';
                list($is_valid, $error_codes) = verifyHCaptcha($hcaptcha_token, $ip);

                if ($is_valid) {
                    $proceed_login = true;
                } else{
                    $success = 3;
                }

            } else {
            
                $secret_key = CF_TURNSTILE_SECRET_KEY;
                $token = $_POST['captcha_response'] ? $_POST['captcha_response'] : '';
                $remoteip = $_SERVER['HTTP_CF_CONNECTING_IP'] ? $_SERVER['HTTP_CF_CONNECTING_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
            
                $validation = validateTurnstile($token, $secret_key, $remoteip);
                
                if ($validation['success']) {
                    $proceed_login = true;
                } else{
                    $success = 3;
                }

            }

        }else{
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

                        $login_failed_attempt ?  $logsql->update_login_failed($username, 0, $ip, $browser_agent, $getmem[0]['EmailAdd']) : $logsql->insert_user_activity($username, $getmem[0]['EmailAdd'], $is_hash);

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
                            $logsql->update_login_failed($username, $attempt, $ip, $browser_agent);

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
        
    endif;

    $_SESSION['peoplesedge_access_token'] = NULL;
    $_SESSION['peoplesedge_login_error'] = NULL;
    
    if(!in_array($success, [2, 3])){
        
        $url = MEWEB.'/peoplesedge/api/jwt/login'; 

        $data = [
            'email' => API_CLIENT_USERNAME,
            'password' => API_CLIENT_PASSWORD
        ];

        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if($response){
            $result = json_decode($response, true);

            if (isset($result['access_token'])) {
                $_SESSION['peoplesedge_access_token'] = $result['access_token'];
            }
            else{
                $_SESSION['peoplesedge_login_error'] = $result['error'] ? $result['error'] : json_encode($result['errors']);
            }
        }

    }

	echo $success;

?>