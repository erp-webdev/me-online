<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = APPR_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Employee Management";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $searchemp_sess = $_SESSION['searchemp'];
        if ($_POST) {        
            $searchemp = $_POST['searchemp'] ? $_POST['searchemp'] : NULL;            
            $_SESSION['searchemp'] = $searchemp;
        }
        elseif ($searchemp_sess) {
            $searchemp = $searchemp_sess ? $searchemp_sess : NULL;
            $_POST['searchemp'] = $searchemp != 0 ? $searchemp : NULL;
        }
        else {
            $searchemp = NULL;
            $_POST['searchemp'] = NULL;
        }                     
        
        $emp_data = $tblsql->get_employee($start, APPR_NUM_ROWS, $searchemp, 0, $profile_dbname);
        $emp_count = $tblsql->get_employee(0, 0, $searchemp, 1, $profile_dbname);
        
        //var_dump($approver_data);

		$pages = $mainsql->pagination("userman", $emp_count, APPR_NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>