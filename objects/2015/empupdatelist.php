<?php

    # PAGINATION
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1 ;
    $start = NUM_ROWS * ($page - 1);

    //*********************** MAIN CODE START **********************\\

    # ASSIGNED VALUE
    $page_title = "Employee Update List";	

    //***********************  MAIN CODE END  **********************\\

    global $sroot, $profile_id, $unix3month;

    echo '<table>';
    echo '<tr><td>Employee ID</td>';
    echo '<td>Full Name</td>';
    echo '<td>Last Name</td>';
    echo '<td>First Name</td>';
    echo '<td>Middle Name</td>';
    echo '<td>Nickname</td>';
    echo '<td>Date Hired</td>';
    echo '<td>Contact Person</td>';
    echo '<td>Contact Address</td>';
    echo '<td>Contact Mobile</td>';
    echo '<td>TIN Number</td>';
    echo '<td>SSS Number</td>';
    echo '<td>HDMF Number</td>';
    echo '<td>PhilHealth Number</td>';
    echo '<td>Division</td>';
    echo '<td>Department</td>';
    echo '<td>Company</td><tr>';

    $emp_data = $tblsql->get_users_updates();

    foreach ($emp_data as $key => $value) :

        $emp_info = $mainsql->get_users_bydb($value['EmpID'], $value['DBNAME']);
        echo '<tr><td>'.$value['EmpID'].'</td>';
        echo '<td>'.$emp_info[0]['FullName'].'</td>';
        echo '<td>'.$emp_info[0]['LName'].'</td>';
        echo '<td>'.$emp_info[0]['FName'].'</td>';
        echo '<td>'.$emp_info[0]['MName'].'</td>';
        echo '<td>'.$emp_info[0]['NickName'].'</td>';
        echo '<td>'.date('Y-m-d', strtotime($emp_info[0]['HireDate'])).'</td>';
        echo '<td>'.$emp_info[0]['ContactPerson'].'</td>';
        echo '<td>'.$emp_info[0]['ContactAddress'].'</td>';
        echo '<td>'.$emp_info[0]['ContactMobileNbr'].'</td>';
        echo '<td>'.$emp_info[0]['TINNbr'].'</td>';
        echo '<td>'.$emp_info[0]['SSSNbr'].'</td>';
        echo '<td>'.$emp_info[0]['PagibigNbr'].'</td>';
        echo '<td>'.$emp_info[0]['PhilHealthNbr'].'</td>';
        echo '<td>'.$emp_info[0]['DivisionName'].'</td>';
        echo '<td>'.$emp_info[0]['DeptDesc'].'</td>';
        echo '<td>'.$value['DBNAME'].'</td><tr>';        

    endforeach;

    echo '</table>';
	
?>