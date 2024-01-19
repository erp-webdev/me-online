<?php
	
	if ($logged == 1) {
        
        echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/myrequest'</script>";

		# PAGINATION
		$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
		$start = NOTI_NUM_ROWS * ($page - 1);
		
		//*********************** MAIN CODE START **********************\\
			
		# ASSIGNED VALUE
		$page_title = "Notification";	
		
		//***********************  MAIN CODE END  **********************\\
		
		global $sroot, $profile_id, $unix3month;
        
        $searchnoti_sess = $_SESSION['searchnoti'];
        $notitype_sess = $_SESSION['notitype'];
        $notifrom_sess = $_SESSION['notifrom'];
        $notito_sess = $_SESSION['notito'];
        if ($_POST) {        
            $searchnoti = $_POST['searchnoti'] ? $_POST['searchnoti'] : NULL;            
            $_SESSION['searchnoti'] = $searchnoti;
            $notitype = $_POST['notitype'] ? $_POST['notitype'] : NULL;            
            $_SESSION['notitype'] = $notitype;
            $notifrom = $_POST['notifrom'] ? $_POST['notifrom'] : NULL;            
            $_SESSION['notifrom'] = $notifrom;
            $notito = $_POST['notito'] ? $_POST['notito'] : NULL;            
            $_SESSION['notito'] = $notito;
        }
        elseif ($searchnoti_sess || $notitype_sess) {
            $searchnoti = $searchnoti_sess ? $searchnoti_sess : NULL;
            $_POST['searchnoti'] = $searchnoti != 0 ? $searchnoti : NULL;
            $notitype = $notitype_sess ? $notitype_sess : NULL;
            $_POST['notitype'] = $notitype != 0 ? $notitype : NULL;
            $notifrom = $notifrom_sess ? $notifrom_sess : NULL;
            $_POST['notifrom'] = $notifrom != 0 ? $notifrom : NULL;
            $notito = $notito_sess ? $notito_sess : NULL;
            $_POST['notito'] = $notito != 0 ? $notito : NULL;
        }
        else {
            $searchnoti = NULL;
            $_POST['searchnoti'] = NULL;
            $notitype = NULL;
            $_POST['notitype'] = NULL;
            $notifrom = NULL;
            $_POST['notifrom'] = NULL;
            $notito = NULL;
            $_POST['notito'] = NULL;
        }                     
        
        $notification_data = $tblsql->get_notification(NULL, $start, NOTI_NUM_ROWS, $searchnoti, 0, $profile_idnum, $notifrom, $notito, $notitype);
        $notification_count = $tblsql->get_notification(NULL, 0, 0, $searchnoti, 1, $profile_idnum, $notifrom, $notito, $notitype);

        $pages = $mainsql->pagination("notification", $notification_count, NOTI_NUM_ROWS, 9);
        
        
        //var_dump($notification_data);

	}
	else
	{
		echo "<script language='javascript' type='text/javascript'>window.location.href='".WEB."/login'</script>";
	}
	
?>