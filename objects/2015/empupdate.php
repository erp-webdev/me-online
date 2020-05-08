<?php
	
	if ($logged == 1) {
        
        if (in_array($profile_idnum, $adminarray3)) {

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = APPR_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Employee Update Management";	

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

            $upddate_data = $tblsql->get_upemployee2($start, APPR_NUM_ROWS, $searchappr, 0);
            $upddate_count = $tblsql->get_upemployee2(0, 0, $searchappr, 1);

            //var_dump($upddate_data);

            $pages = $mainsql->pagination("empupdate", $upddate_count, APPR_NUM_ROWS, 9);
        }
        else
        {
            echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."'</script>";
        }

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>