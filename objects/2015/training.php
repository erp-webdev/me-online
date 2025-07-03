<?php

	if ($logged == 1) {

		# PAGINATION

		//*********************** MAIN CODE START **********************\\

		# ASSIGNED VALUE
		$page_title = "Training Records";

		//***********************  MAIN CODE END  **********************\\

		global $sroot, $profile_id, $unix3month;

        $trainings =[];
        $selected_year = $_GET['year'] ? $_GET['year'] : date('Y');
        if (isset($_SESSION['peoplesedge_access_token'])) {
            $access_token = $_SESSION['peoplesedge_access_token'];

            $access_url = MEWEB.'/peoplesedge/api/employee/training'; 
            $data = [
                'EmpID' => $profile_idnum,
                'EmpDB' => $profile_dbname,
                'TrainingYear' => $selected_year
            ];

            $options = [
                'http' => [
                    'header' => "Content-Type: application/json\r\n" .
                                "Authorization: Bearer " . $access_token . "\r\n",
                    'method' => 'POST',
                    'content' => json_encode($data),
                    'ignore_errors' => true
                ]
            ];

            $file_context = stream_context_create($options);
            $training_response = file_get_contents($access_url, false, $file_context);

            if ($training_response) {
                $http_status_code = 0;
                if (isset($http_response_header)) {
                    sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $http_status_code);
                }

                if ($http_status_code >= 200 && $http_status_code < 300) {
                    $training_data = json_decode($training_response, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        if (isset($training_data['trainings']) && !empty($training_data['trainings'])) {
                            $trainings = $training_data['trainings'];
                        } else {
                            $error_message = "NO TRAINING RECORDS AVAILABLE";
                        }
                    } else {
                        $error_message = "We received an unexpected response from the server. Please try again by refreshing the page.";
                    }

                } 
                else {
                    $error_data = json_decode($training_response, true);

                    if (json_last_error() === JSON_ERROR_NONE && isset($error_data['error'])) {
                        $error_message = "There was a problem: " . htmlspecialchars($error_data['error']) . ". Please try again.";
                    } elseif (in_array($http_status_code, [401, 403]) || $peoplesedge_login_required) {
                        $error_message = "Your session has expired. Please try to log in again.";
                    } elseif ($http_status_code === 404) {
                        $error_message = "We couldn't track your records. It may have been moved or no longer exists.";
                    } elseif ($http_status_code >= 500) {
                        $error_message = "The server is currently experiencing issues. Please try again later.";
                    } 
                }
            }
            else{
                $error_message = "We couldn’t connect to the server. Please check your internet connection, or try again in a few minutes.";
            }

        }

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
