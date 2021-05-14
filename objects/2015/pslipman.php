<?php
	
	if ($logged == 1) {
        
        if ($profile_ps) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = APPR_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Payslip Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $searchpsman_sess = $_SESSION['searchpsman'];
            if ($_POST) {        
                $searchpsman = $_POST['searchpsman'] ? $_POST['searchpsman'] : NULL;            
                $_SESSION['searchpsman'] = $searchpsman;
            }
            elseif ($searchpsman_sess) {
                $searchpsman = $searchpsman_sess ? $searchpsman_sess : NULL;
                $_POST['searchpsman'] = $searchpsman != 0 ? $searchpsman : NULL;
            }
            else {
                $searchpsman = NULL;
                $_POST['searchpsman'] = NULL;
            }                              

            $psman_data = $tblsql->get_employee_with_inactive($start, APPR_NUM_ROWS, $searchpsman, 0, $profile_dbname);
            $psman_count = $tblsql->get_employee_with_inactive(0, 0, $searchpsman, 1, $profile_dbname);

            $pages = $mainsql->pagination("pslipman", $psman_count, APPR_NUM_ROWS, 9);
        
        else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";    
        
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>