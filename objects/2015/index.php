<?php
	
	if ($logged == 1) {

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Dashboard";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        //$unread_notification = $mainsql->get_read($profile_idnum);        
        //$unread_notification = $tblsql->get_recent_noti($profile_idnum);        
        //$unread_memo = $mainsql->get_recent_memo();
        
        $cutoff_date = $mainsql->get_nextcutoff($profile_comp);
        
        //var_dump($unread_notification);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>