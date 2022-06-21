<?php
	if ($logged == 1) {
        if ($wfhc_app) :

            include OBJ . '/WFH/WFHClearance.php';

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "WFH Clearance";

            global $sroot, $profile_id, $unix3month;
            
            $wfh_clearance = new WFHClearance;
            

            //***********************  MAIN CODE END  **********************\\
        else :

            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";

        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
