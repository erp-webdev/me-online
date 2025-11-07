<?php
    if ($logged == 1 ) {
        if (isset($_SESSION['peoplesedge_access_token'])) {
            $access_token = $_SESSION['peoplesedge_access_token'];

            $ratee_id = $_GET['ratee'];
            $access_file_url = MEWEB.'/peoplesedge/api/employee/pmr/'.$ratee_id.'/documents'; 

            $options = [
                'http' => [
                    'header' => "Content-Type: application/json\r\n" .
                                "Authorization: Bearer " . $access_token . "\r\n",
                    'method' => 'GET',
                    'content' => 'application/json',
                    'ignore_errors' => true
                ]
            ];

            $file_context = stream_context_create($options);
            $pmr_response = file_get_contents($access_file_url, false, $file_context);

            if ($pmr_response) {
                $http_status_code = 0;
                if (isset($http_response_header)) {
                    sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $http_status_code);
                }

                if ($http_status_code >= 200 && $http_status_code < 300) {
                    $pmr_data = json_decode($pmr_response, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        if($pmr_data['evaluation']['EmpID'] == $profile_idnum && $pmr_data['evaluation']['EmpDB'] == $profile_dbname){
                            if (isset($pmr_data['evaluation']) && !empty($pmr_data['evaluation'])) {
                                if(in_array($pmr_data['post_evaluation']['Status'], ['Post Evaluation Endorsed to Payroll', 'Post Evaluation Completed'])){
                                    $evaluation = $pmr_data['evaluation'];
                                    $post_evaluation = $pmr_data['post_evaluation'];
                                }
                                else{
                                    $error_message = "You do not have permission yet to access this page. Please wait for further notice or you may contact your People Partner.";
                                }
                            }
                            else{
                                $error_message = "You do not have permission to access this page.";
                            }
                        }
                        else{
                            $error_message = "You do not have permission to access this page.";
                        }

                        if (isset($pmr_data['documents']) && !empty($pmr_data['documents'])) {
                            $documents = $pmr_data['documents'];
                        } else {
                            $error_message = "NO DOCUMENTS AVAILABLE";
                        }
                    } else {
                        $error_message = "We received an unexpected response from the server. Please try again by refreshing the page or re-login to ME Online.";
                    }

                } 
                else {
                    $error_data = json_decode($pmr_response, true);

                    if (json_last_error() === JSON_ERROR_NONE && isset($error_data['error'])) {
                        $error_message = "There was a problem: " . htmlspecialchars($error_data['error']) . ". Please try again.";
                    } elseif (in_array($http_status_code, [401, 403])) {
                        $error_message = "Your session has expired. Please try to log in again.";
                    } elseif ($http_status_code === 404) {
                        $error_message = "We couldn't track your records. It may have been moved or no longer exists. Please try again by  re-logging in to ME Online.";
                    } elseif ($http_status_code >= 500) {
                        $error_message = "The server is currently experiencing issues. Please try again later.";
                    } 
                }
            }
            else{
                $error_message = "We couldn’t connect to the server. Please check your internet connection, or try again in a few minutes.";
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