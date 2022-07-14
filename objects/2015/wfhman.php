<?php
	
	if ($logged == 1) {
        
        if ($accessman->hasAccess($profile_id, $profile_dbname, $profile_dbname, 'wfh')) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = APPR_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "WFH Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $searchwcman_sess = $_SESSION['searchwcman'];
            if ($_POST) {        
                $searchwcman = $_POST['searchwcman'] ? $_POST['searchwcman'] : NULL;            
                $_SESSION['searchwcman'] = $searchwcman;
            }
            elseif ($searchwcman_sess) {
                $searchwcman = $searchwcman_sess ? $searchwcman_sess : NULL;
                $_POST['searchwcman'] = $searchwcman != 0 ? $searchwcman : NULL;
            }
            else {
                $searchwcman = NULL;
                $_POST['searchwcman'] = NULL;
            }                              

            $wcman_data = $tblsql->get_employee_with_wfhclearance($start, APPR_NUM_ROWS, $searchwcman, 0, $profile_dbname);
            $wcman_count = $tblsql->get_employee_with_wfhclearance(0, 0, $searchwcman, 1, $profile_dbname);

            $pages = $mainsql->pagination("wfhman", $wcman_count, APPR_NUM_ROWS, 9);
        
        else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";    
        
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>