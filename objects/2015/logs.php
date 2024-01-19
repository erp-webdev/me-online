<?php

    # PAGINATION
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
    $start = LOGS_NUM_ROWS * ($page - 1);

    //*********************** MAIN CODE START **********************\\

    # ASSIGNED VALUE
    $page_title = "Logs";	

    //***********************  MAIN CODE END  **********************\\

    global $sroot, $profile_id, $unix3month;

    $searchlogs_sess = $_SESSION['searchlogs'];
    $logsfrom_sess = $_SESSION['logsfrom'];
    $logsto_sess = $_SESSION['logsto'];
    if ($_POST) {        
        $searchlogs = $_POST['searchlogs'] ? $_POST['searchlogs'] : NULL;            
        $_SESSION['searchlogs'] = $searchlogs;
        $logsfrom = $_POST['logsfrom'] ? $_POST['logsfrom'] : NULL;            
        $_SESSION['logsfrom'] = $logsfrom;
        $logsto = $_POST['logsto'] ? $_POST['logsto'] : NULL;            
        $_SESSION['logsto'] = $logsto;
    }
    elseif ($searchlogs_sess) {
        $searchlogs = $searchlogs_sess ? $searchlogs_sess : NULL;
        $_POST['searchlogs'] = $searchlogs != 0 ? $searchlogs : NULL;
        $logsfrom = $logsfrom_sess ? $logsfrom_sess : NULL;
        $_POST['logsfrom'] = $logsfrom != 0 ? $logsfrom : NULL;
        $logsto = $logsto_sess ? $logsto_sess : NULL;
        $_POST['logsto'] = $logsto != 0 ? $logsto : NULL;
    }
    else {
        $searchlogs = NULL;
        $_POST['searchlogs'] = NULL;
        $logsfrom = NULL;
        $_POST['logsfrom'] = NULL;
        $logsto = NULL;
        $_POST['logsto'] = NULL;
    }                     

    $logs_data = $mainsql->get_logs(NULL, $start, LOGS_NUM_ROWS, $searchlogs, 0, ($logsfrom ? date("m/d/Y", strtotime($logsfrom)) : NULL), ($logsfrom ? date("m/d/Y", strtotime($logsto)) : NULL));
    $logs_count = $mainsql->get_logs(NULL, 0, 0, $searchlogs, 1, ($logsfrom ? date("m/d/Y", strtotime($logsfrom)) : NULL), ($logsfrom ? date("m/d/Y", strtotime($logsto)) : NULL));

    $pages = $mainsql->pagination("logs", $logs_count, LOGS_NUM_ROWS, 9);
	
?>