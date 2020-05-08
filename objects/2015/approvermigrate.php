<?php

    # PAGINATION
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
    $start = NUM_ROWS * ($page - 1);

    //*********************** MAIN CODE START **********************\\

    # ASSIGNED VALUE
    $page_title = "Daily Time Record";	

    //***********************  MAIN CODE END  **********************\\

    global $sroot, $profile_id, $unix3month;

    $emp_data = $tblsql->get_employee();

    $emp_count = 0;

    foreach ($emp_data as $key => $value) :

        $apprmigrate = $mainsql->approver_action($value['EmpID'], 'migrate');
        //echo $apprmigrate;

        if ($apprmigrate) :
            $emp_count++;
        endif;

    endforeach;

    echo $emp_count.' employee\'s approvers has been set';
	
?>