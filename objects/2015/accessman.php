<?php
	
	if ($logged == 1) {
        
        if ($profile_idnum == '2016-06-0457') :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = APPR_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Access Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $searchpsman_sess = $_SESSION['searchacman'];
            if ($_POST) {        
                $searchacman = $_POST['searchacman'] ? $_POST['searchacman'] : NULL;            
                $_SESSION['searchacman'] = $searchacman;
            }
            elseif ($searchacman_sess) {
                $searchacman = $searchacman_sess ? $searchacman_sess : NULL;
                $_POST['searchacman'] = $searchacman != 0 ? $searchacman : NULL;
            }
            else {
                $searchacman = NULL;
                $_POST['searchacman'] = NULL;
            }                              

            $acman_data = $tblsql->get_users_access($start, APPR_NUM_ROWS, $searchacman, 0, $profile_dbname);
            $acman_count = $tblsql->get_users_access(0, 0, $searchacman, 1, $profile_dbname);

            $pages = $mainsql->pagination("accessman", $acman_count, APPR_NUM_ROWS, 9);
        
        else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";    
        
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>