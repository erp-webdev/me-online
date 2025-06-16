<?php
    if ($logged == 1 ) {
        if (isset($_SESSION['peoplesedge_access_token'])) {
            $access_token = $_SESSION['peoplesedge_access_token'];

            $access_file_url = MEWEB.'/peoplesedge/api/employee/medical'; 
            $data = [
                'EmpID' => $profile_idnum,
                'EmpDB' => $profile_dbname,
                'CompanyID' => $profile_comp
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
            $ape_file_response = file_get_contents($access_file_url, false, $file_context);

            $ape_result = NULL;
            if($ape_file_response){
                $ape_result = json_decode($ape_file_response, true);

                $MedicalDate = $ape_result['MedicalDate'];
                $MedicalRemarks = $ape_result['MedicalRemarks'];
                $ViewURL = $ape_result['viewUrl'];
                $DownloadURL = $ape_result['downloadUrl'];
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