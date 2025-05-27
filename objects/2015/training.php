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

            if($training_response){
                $training_data = json_decode($training_response, true);
                $trainings = $training_data['trainings'];
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
