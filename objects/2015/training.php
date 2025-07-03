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

            if ($training_response === false) {
                // echo "Error: Unable to connect to the training service.";
                $trainings = [];
            } else {
                $status_code = 0;
                if (isset($http_response_header)) {
                    sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $status_code);
                }

                if ($status_code >= 200 && $status_code < 300) {
                    $training_data = json_decode($training_response, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $trainings = isset($training_data['trainings']) ? $training_data['trainings'] : [];
                    } else {
                        echo "Error: Invalid data received from the training service.";
                    }
                } elseif ($status_code == 401) {
                    echo "Error: Unauthorized. Your session may have expired. Please log out and log in again.";
                } else {
                    $error_message = "Error fetching training data (HTTP status: $status_code).";
                    $error_data = json_decode($training_response, true);
                    if (json_last_error() === JSON_ERROR_NONE && isset($error_data['message'])) {
                        $error_message .= " " . htmlspecialchars($error_data['message']);
                    }
                    echo $error_message;
                }
            }
        }
        else{
            echo "Error: " . $_SESSION['peoplesedge_login_error'];
        }

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
