<?php
	if ($logged == 1) {
        if ($wfhc_app) :
            
            // include OBJ . '/wfh/WFHClearance.php';
            // $wfh_clearance = new WFHClearance();

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "WFH Clearance";

            global $sroot, $profile_id, $unix3month;


            //***********************  MAIN CODE END  **********************\\
        
	}
	else
	{
		if ($_POST['btnwfhapply'] || $_POST['btnwfhapply_x']){
			echo '{"success": false, "error": "Your session has expired! Kindly logout and login again to continue."}';
			exit();
		}
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

	}

?>
