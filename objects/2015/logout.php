<?php
	
	if ($logged == 1) {
	
		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		
		# CLEAN THE GET VARIABLES
		if (isset($_GET['id']))
		{ 
			$_GET['id'] = $mainsql->clean_variable($_GET['id'], 1); 
		}
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$article_page = true;
		$page_title = "Megaworld Portal";	
		
		//***********************  MAIN CODE END  **********************\\

		$cookiename = 'megasubs_user';
		
        if ($profile_idnum != 'admin') :
            //AUDIT TRAIL
            $post['EMPID'] = $profile_idnum;
            $post['TASKS'] = "LOGOUT";
            $post['DATA'] = $profile_idnum;
            $post['DATE'] = date("m/d/Y H:i:s.000");

            $log = $mainsql->log_action($post, 'add');
        endif;
        
		unset($_SESSION[$cookiename]);
        unset($_SESSION['megasubs_db']);
        unset($_SESSION['ssep_comp']);
        unset($_SESSION['megasubs_admin']);
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>