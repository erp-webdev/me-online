<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
        
        $id = $_GET["id"];
        if (!$id) :
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/activity'</script>";
        endif;
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
        
		$page_title = "My Registration";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;		        
        
        // FEDDBACK ACTIVITY
        if ($_POST['btnfback'] || $_POST['btnfback_x']) :
        
            $fback_activity = $tblsql->activity_action($_POST, NULL, 'feedback');			
            if($fback_activity) : 
                echo '{"success": true}';
                exit();
            else :
                echo '{"success": false}';
                exit();
            endif;
        
        endif;
        
        $registrants = $tblsql->get_registrant(0, 0, 0, 0, $id);
        $activity_title = $tblsql->get_activities($id);

        if(isset($_GET['export'])){
            $filename = 'registrants_'.$activity_title[0]['activity_title'].'.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            $output = fopen('php://output', 'w');
            fputcsv($output, array('Company', 'Employee ID', 'Name', 'Location', 'Will go directly', 'Date Registered', 'Status'));
            foreach ($registrants as $value) {
                fputcsv($output, array(
                    $value['CompanyID'],
                    $value['EmpID'],
                    $value['FName'].' '.$value['LName'],
                    $value['registry_location'],
                    $value['registry_godirectly'] ? 'Yes' : 'No',
                    date("M j, Y", $value['registry_date']).' '.date("g:ia", $value['registry_date']),
                    ($value['registry_status'] == 2) ? 'Approved' : (($value['registry_status'] == 4) ? 'Attended' : 'For Approval')
                ));
            }
            fclose($output);
            exit();
        }

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>