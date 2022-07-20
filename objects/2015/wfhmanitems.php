<?php
	
	if ($logged == 1) {
        
        if ($accessman->hasAccess($profile_id, $profile_dbname, $profile_dbname, 'wfh')) :

            include(CLASSES."/WFHManagement.php");
            $wfhman = new WFHManagement;

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = APPR_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "WFH Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $searchwciman_sess = $_SESSION['searchwciman'];
            if ($_POST) {        
                $searchwciman = $_POST['searchwciman'] ? $_POST['searchwciman'] : NULL;            
                $_SESSION['searchwciman'] = $searchwciman;
            }
            elseif ($searchwciman_sess) {
                $searchwciman = $searchwciman_sess ? $searchwciman_sess : NULL;
                $_POST['searchwciman'] = $searchwciman != 0 ? $searchwciman : NULL;
            }
            else {
                $searchwciman = NULL;
                $_POST['searchwciman'] = NULL;
            }                              

            // $wciman_data = $wfhman->getWfhClearanceItems($start, REQ_NUM_ROWS, $searchwciman, 0);
            // $wciman_count = $wfhman->getWfhClearanceItems(0, 0, $searchwciman, 1);

            $pages = $mainsql->pagination("wfhman", $wciman_count, APPR_NUM_ROWS, 9);
        
        else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";    
        
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>