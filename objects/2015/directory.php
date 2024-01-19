<?php

	if ($logged == 1) {

        # PAGINATION
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
        $start = NUM_ROWS * ($page - 1);

        //*********************** MAIN CODE START **********************\\

        # ASSIGNED VALUE
        $page_title = "Corporate Phone Directory (Alliance Global Tower)";	

        //***********************  MAIN CODE END  **********************\\

        global $sroot, $profile_id, $unix3month;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}

?>
