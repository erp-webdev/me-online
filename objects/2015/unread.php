<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NOTI_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Unread Notification";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $unread_data = $mainsql->get_read($profile_idnum, NULL, 0, $start, NOTI_NUM_ROWS);
        $unread_count = $mainsql->get_read($profile_idnum, NULL, 1);

		$pages = $mainsql->pagination("unread", $unread_count, NOTI_NUM_ROWS, 9);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>