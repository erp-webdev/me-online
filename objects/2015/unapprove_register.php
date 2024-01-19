<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
        
		$page_title = "For Approval Registrations";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;	
        
        $staff = $tblsql->get_staff($start, NUM_ROWS, 0, $profile_id);
		$staff_count = $tblsql->get_staff(0, 0, 1, $profile_id);

		$pages = $tblsql->pagination("unapprove_register", $staff_count, NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>