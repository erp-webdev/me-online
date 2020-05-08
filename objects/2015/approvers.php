<?php
	
	if ($logged == 1) {
        
        if ($profile_level) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = REQ_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Approvers Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $searchappr_sess = $_SESSION['searchappr'];
            if ($_POST) {        
                $searchappr = $_POST['searchappr'] ? $_POST['searchappr'] : NULL;            
                $_SESSION['searchappr'] = $searchappr;
            }
            elseif ($searchappr_sess) {
                $searchappr = $searchappr_sess ? $searchappr_sess : NULL;
                $_POST['searchappr'] = $searchappr != 0 ? $searchappr : NULL;
            }
            else {
                $searchappr = NULL;
                $_POST['searchappr'] = NULL;
            }                     

            if (strlen($searchappr) >= 5) :
                $approver_data = $mainsql->get_employee($start, REQ_NUM_ROWS, $searchappr, 0);
                $approver_count = $mainsql->get_employee(0, 0, $searchappr, 1);
                $pages = $mainsql->pagination("approvers", $approver_count, REQ_NUM_ROWS, 9);            
            else :
                $approver_data = NULL;
                $approver_count = NULL;
                $pages = NULL;
            endif;
        
        else :
        
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";    
        
        endif;

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>