<?php
	
	if ($logged == 1) {
        
        if ($profile_level) :

            # PAGINATION
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
            $start = REQ_NUM_ROWS * ($page - 1);

            //*********************** MAIN CODE START **********************\\

            # ASSIGNED VALUE
            $page_title = "Requests Management";	

            //***********************  MAIN CODE END  **********************\\

            global $sroot, $profile_id, $unix3month;

            $rmantype_sess = $_SESSION['rmantype'];
            $searchrman_sess = $_SESSION['searchrman'];
            $rmanfrom_sess = $_SESSION['rmanfrom'];
            $rmanto_sess = $_SESSION['rmanto'];
            if ($_POST) {        
                $rmantype = $_POST['rmantype'] ? $_POST['rmantype'] : NULL;            
                $_SESSION['rmantype'] = $rmantype;
                $searchrman = $_POST['searchrman'] ? $_POST['searchrman'] : NULL;            
                $_SESSION['searchrman'] = $searchrman;
                $rmanfrom = $_POST['rmanfrom'] ? $_POST['rmanfrom'] : date('Y-m-d', strtotime("-6 months"));  
                $_SESSION['rmanfrom'] = $rmanfrom;
                $rmanto = $_POST['rmanto'] ? $_POST['rmanto'] : date('Y-m-d');            
                $_SESSION['rmanto'] = $rmanto;
            }
            elseif ($searchrman_sess || $rmantype_sess) {
                $rmantype = $rmantype_sess ? $rmantype_sess : NULL;
                $_POST['rmantype'] = $rmantype != 0 ? $rmantype : NULL;
                $searchrman = $searchrman_sess ? $searchrman_sess : NULL;
                $_POST['searchrman'] = $searchrman != 0 ? $searchrman : NULL;
                $rmanfrom = $rmanfrom_sess ? $rmanfrom_sess : date('Y-m-d', strtotime("-6 months"));
                $_POST['rmanfrom'] = $rmanfrom != 0 ? $rmanfrom : date('Y-m-d', strtotime("-6 months"));
                $rmanto = $rmanto_sess ? $rmanto_sess : date('Y-m-d');
                $_POST['rmanto'] = $rmanto != 0 ? $rmanto : date('Y-m-d');
            }
            else {
                $rmantype = NULL;
                $_POST['rmantype'] = NULL;
                $searchrman = NULL;
                $_POST['searchrman'] = NULL;
                $rmanfrom = date('Y-m-d', strtotime("-6 months"));
                $_POST['rmanfrom'] = date('Y-m-d', strtotime("-6 months"));
                $rmanto = date('Y-m-d');
                $_POST['rmanto'] = date('Y-m-d');
            }                     

            //var_dump($searchrman);

            if (strlen($searchrman) >= 5) :
                $notification_data = $mainsql->get_notification(NULL, $start, REQ_NUM_ROWS, $searchrman, 0, NULL, $rmanfrom, $rmanto, $rmantype);
                $notification_count = $mainsql->get_notification_count(NULL, 0, 0, $searchrman, NULL, $rmanfrom, $rmanto, $rmantype);
                $pages = $mainsql->pagination("reqman", $notification_count[0]['EmpCount'], REQ_NUM_ROWS, 9);
            else :
                $notification_data = NULL;
                $notification_count = NULL;
                $pages = NULL;
            endif;

            //var_dump($notification_count);

            //var_dump($notification_data);
        else :
		  echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
        endif;
	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>