<?php
	
	if ($logged == 1) {
        
        if ($profile_level || count($approver_employees)) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = REQ_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "System and DTR Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $searchdtrm_sess = $_SESSION['searchdtrm'];
            if ($_POST) {        
                $searchdtrm = $_POST['searchdtrm'] ? $_POST['searchdtrm'] : NULL;            
                $_SESSION['searchdtrm'] = $searchdtrm;
            }
            elseif ($searchdtrm_sess) {
                $searchdtrm = $searchdtrm_sess ? $searchdtrm_sess : NULL;
                $_POST['searchdtrm'] = $searchdtrm != 0 ? $searchdtrm : NULL;
            }
            else {
                $searchdtrm = NULL;
                $_POST['searchdtrm'] = NULL;
            }                              

            if (strlen($searchdtrm) >= 3) :
                if($profile_level) :
                    $dtrman_data = $mainsql->get_employee($start, REQ_NUM_ROWS, $searchdtrm, 0);
                    $dtrman_count = $mainsql->get_employee(0, 0, $searchdtrm, 1);
                    $pages = $mainsql->pagination("dtrman", $dtrman_count, REQ_NUM_ROWS, 9);          
                else :
                    // allow viewing of dtr if approver of the employee
                    if(count($approver_employees)) :
                        // $dtrman_data = $mainsql->get_approver_employee($start, REQ_NUM_ROWS, $searchdtrm, 0, $profile_idnum, $profile_dbname);

                        $dtrman_data = $mainsql->get_approver_employee($start, REQ_NUM_ROWS, null, 0, $profile_idnum, $profile_dbname);
                        $dtrman_count = $mainsql->get_approver_employee(0, 0, $searchdtrm, 1, $profile_idnum, $profile_dbname);
                        $pages = $mainsql->pagination("dtrman", $dtrman_count, REQ_NUM_ROWS, 9); 
                    endif;
                endif;  
            else :
                // allow viewing of dtr if approver of the employee
                if(count($approver_employees)) :
                    // $dtrman_data = $mainsql->get_approver_employee($start, REQ_NUM_ROWS, $searchdtrm, 0, $profile_idnum, $profile_dbname);

                    $dtrman_data = $mainsql->get_approver_employee($start, REQ_NUM_ROWS, null, 0, $profile_idnum, $profile_dbname);
                    $dtrman_count = $mainsql->get_approver_employee(0, 0, $searchdtrm, 1, $profile_idnum, $profile_dbname);
                    $pages = $mainsql->pagination("dtrman", $dtrman_count, REQ_NUM_ROWS, 9); 
                else:
                    $dtrman_data = NULL;
                    $dtrman_count = NULL;
                    $pages = NULL;
                endif;
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