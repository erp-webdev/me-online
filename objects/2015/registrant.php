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

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>