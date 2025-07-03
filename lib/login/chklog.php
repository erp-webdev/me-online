<?php

	$cookiename = 'megasubs_user';

	$username = $_SESSION[$cookiename];	
    $password = $_SESSION['megasubs_password'] ? $_SESSION['megasubs_password'] : NULL;	
    $userdb = $_SESSION['megasubs_db'];	
	
	if ($username) {	        
		$redirectUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$_SESSION['login_url'] = $redirectUrl;
		$_SESSION['logout_url'] = $redirectUrl;	
		
		$checkname = $logsql->check_member($username, $password);
		
		if (!$checkname) 
		{
			$logstat = 0;		
		}
		else 
		{
			$userdata = $logsql->get_member2($username, $password, $userdb);        
			
			$logstat = 1;
			$logfname = $userdata[0]['FName'].' '.$userdata[0]['LName'];
            $lognick = $userdata[0]['FName'];
			$logname = $userdata[0]['EmpID'];
            $logpic = $userdata[0]['IMAGEPATH'];
			$userid = $userdata[0]['EmpID'];	
			$email = $userdata[0]['EmailAdd'];	
			$bday = $userdata[0]['BirthDate'];	
			$company = $userdata[0]['CompanyID'];
			$sss = $userdata[0]['SSSNbr'];		
			$tin = $userdata[0]['TINNbr'];	
			$phealth = $userdata[0]['PhilHealthNbr'];	
			$pagibig = $userdata[0]['PagibigNbr'];	
			$acctnum = $userdata[0]['AccountNo'];	
			$location = $userdata[0]['LocationID'];	
            $compressed = $userdata[0]['Compressed'];	
            
            $dbname = $userdb ? $userdb : $userdata[0]['DBNAME'];	
            $minothours = $userdata[0]['MinOTHrs'];	
            
            $usertax = $logsql->get_memtax($userdata[0]['TaxID']);
            $taxdesc = $usertax[0]['Description'];	

			//Checking PeoplesEdge API endpoint
			$peoplesedge_login_required = true;
			if(isset($_SESSION['peoplesedge_access_token'])){
				$access_token = $_SESSION['peoplesedge_access_token'];

				// Ping PeoplesEdge JWT API
				$ping_url = MEWEB.'/peoplesedge/api/jwt/me'; 
				$options = [
					'http' => [
						'header' => "Content-Type: application/json\r\n" .
									"Authorization: Bearer " . $access_token . "\r\n",
						'method' => 'GET',
						'content' => json_encode($data),
						'ignore_errors' => true
					]
				];

				$file_context = stream_context_create($options);
				$ping_response = file_get_contents($ping_url, false, $file_context);

				if ($ping_response) {
					$status_code = 0;
					if (isset($http_response_header)) {
						sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $status_code);
					}

					if ($status_code >= 200 && $status_code < 300) {
						$peoplesedge_login_required = false;
					} 
					else {
						error_log("Error connecting to PeoplesEdge API (HTTP status: $status_code).");
						$error_data = json_decode($ping_response, true);
						if (json_last_error() === JSON_ERROR_NONE && isset($error_data['error'])) {
							error_log($error . htmlspecialchars($error_data['error']));
						}
					}
				}
			}

			// Re-login to PeoplesEdge API if token expires
			if($peoplesedge_login_required){
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

					$status_code = 0;
					if (isset($http_response_header)) {
						sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $status_code);
					}

					if ($status_code >= 200 && $status_code < 300) {
						if (isset($result['access_token'])) {
							$_SESSION['peoplesedge_access_token'] = $result['access_token'];
						}
					}
					else {
						error_log("Error connecting to PeoplesEdge API (HTTP status: $status_code).");
						if (json_last_error() === JSON_ERROR_NONE && isset($result['error'])) {
							error_log(htmlspecialchars($result['error']));
						}
					}
				}
			}
		}		
	}
	else
	{
		$logstat = 0;
	}

?>